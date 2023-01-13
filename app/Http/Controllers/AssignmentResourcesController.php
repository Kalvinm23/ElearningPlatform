<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Assignment;
use App\AssignmentResource;
use App\Resource;
use App\ResourceType;
use App\Unit;

class AssignmentResourcesController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $assignment = Assignment::find($id);

        $tdatas = ResourceType::select('id', 'name')->get();
        $types = array();
        foreach ($tdatas as $tdata)
        {
            $types[$tdata->id] = $tdata->name;
        }

        return view('assignmentresources.create')->with(compact('assignment', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //validate data
        $this->validate($request,[
          'name' => 'required',
          'type' => 'required',
      ]);

    if($request->input('type') == 1){

        //validate data
        $this->validate($request,[
            'pdf' => 'required|mimes:pdf|max:20000',

        ]);
        //Handle Contract PDF Upload
        //Get PDF name with extension
        $filenameWithExt = $request->file('pdf')->getClientOriginalName();
        //Get just PDF name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //Get PDF extension
        $extension = $request->file('pdf')->getClientOriginalExtension();
        //PDF name to store
        $pdfNameToStore = $filename.'_'.time().'.'.$extension;
        //Upload PSF
        $path = $request->file('pdf')->storeAs('public/bookchapters', $pdfNameToStore);

    }else{        
        //validate data
        $this->validate($request,[
            'url' => 'required',
        ]);
    }

      //create Unit table input
      $resource = new Resource;
      $resource->name = $request->input('name');
      $resource->resource_type_id = $request->input('type');

      if($request->input('type') == 1){
        $resource->link = $pdfNameToStore;
      }else{
        $resource->link = $request->input('url');
      }
      $resource->status = 1;
      $resource->save();     
      
      //create Assignment to Resource relationship
      $ordercount = 0;
      $ordercount = AssignmentResource::where('Assignment_id', $id)->count();
      $ordercount++;

      $assignmentresource = new AssignmentResource;
      $assignmentresource->assignment_id = $id;
      $assignmentresource->resource_id = $resource->id;
      $assignmentresource->order = $ordercount;
      $assignmentresource->save();

      return redirect('/assignments/'.$id)->with('success', 'Resource Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignment = Assignment::find($id);
        $resources = Assignment::find($id)->resources()->orderBy('order','asc')->get();
        $assignments = Unit::find($assignment->unit_id)->assignments()->orderBy('order','asc')->get();

        $addresourcedatas = Resource::select('id', 'name', 'resource_type_id')->where('status', 1)->orderBy('resource_type_id','asc')->orderBy('name','asc')->get();
        $addresources = [];
        foreach ($addresourcedatas as $addresourcedata)
        {
            $assignmentresources = AssignmentResource::where('assignment_id', $id)->where('resource_id', $addresourcedata->id)->count();
            if($assignmentresources == 0){
                $addresources[] = [
                    'id' => $addresourcedata->id,
                    'name' => $addresourcedata->name,
                    'resource_type_id' => $addresourcedata->resource_type_id,
                ];
            }

        }

        return view('assignmentresources.edit')->with(compact('assignment', 'assignments', 'resources', 'addresources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        $order_id = $request->input('order_id');
        $ordercount = 1;
        for($count = 0; $count < count($order_id); $count++)
        {
            $assignmentresource = AssignmentResource::find($order_id[$count]);
            $assignmentresource->order = $ordercount;
            $assignmentresource->save();
            $ordercount++;
            
        }
        
        return redirect('/assignments/'.$assignmentresource->assignment_id)->with('success', 'Resources Updated');
    }

    public function createrelationship($aid, $rid)
    {      
        //create Unit to Course relationship
        $ordercount = 0;
        $ordercount = AssignmentResource::where('assignment_id', $aid)->count();
        $ordercount++;
  
        $assignmentresource = new AssignmentResource;
        $assignmentresource->assignment_id = $aid;
        $assignmentresource->resource_id = $rid;
        $assignmentresource->order = $ordercount;
        $assignmentresource->save();
  
        return redirect('/assignments/'.$aid)->with('success', 'Resource added to Assignment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = AssignmentResource::find($id);
        $resource->delete();
        return redirect('/assignments/'.$resource->assignment_id)->with('success', 'Resource Removed');
    }
}
