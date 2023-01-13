<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Resource;
use App\ResourceType;
use App\AssignmentResource;

class ResourcesController extends Controller
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
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $aresources = Resource::where('status', '=' , 1)->orderBy('resource_type_id','asc')->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $iresources = Resource::where('status', '!=' , 1)->orderBy('resource_type_id','asc')->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('resources.index')->with(compact('aresources', 'iresources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }

        $tdatas = ResourceType::select('id', 'name')->get();
        $types = array();
        foreach ($tdatas as $tdata)
        {
            $types[$tdata->id] = $tdata->name;
        }

        return view('resources.create')->with(compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $this->validate($request,[
          'name' => 'required',
          'type' => 'required',
      ]);

    if($request->input('type') == 1){

        //validate data
        $this->validate($request,[
            'pdf' => 'required|mimes:pdf|max:10000',

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

      return redirect('/resources/'.$resource->id)->with('success', 'Resource Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $resource = Resource::find($id);
        $relationships = Resource::find($id)->assignments()->paginate(9);

        return view('resources.show')->with(compact('resource', 'relationships'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $resource = Resource::find($id);

        $tdatas = ResourceType::select('id', 'name')->get();
        $types = array();
        foreach ($tdatas as $tdata)
        {
            $types[$tdata->id] = $tdata->name;
        }

        return view('resources.edit')->with(compact('resource', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate data
        $this->validate($request,[
          'name' => 'required',
          'type' => 'required',
      ]);
      $resource = Resource::find($id);

    if($request->input('type') == 1){

      //Handle Product Image Upload
      if($request->hasFile('pdf')){

        //validate data
        $this->validate($request,[
            'pdf' => 'required|mimes:pdf|max:10000',
        ]);
  
        //Get pdf name with extension
        $filenameWithExt = $request->file('pdf')->getClientOriginalName();
        //Get just pdf name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //Get pdf extension
        $extension = $request->file('pdf')->getClientOriginalExtension();
        //pdf name to store
        $imageNameToStore = $filename.'_'.time().'.'.$extension;
        //Upload pdf
        $path = $request->file('pdf')->storeAs('public/bookchapters', $imageNameToStore);
        //Delete previous file
        Storage::delete('public/bookchapters/'.$resource->link);

        }
    }else{        
        //validate data
        $this->validate($request,[
            'url' => 'required',
        ]);
    }

      //create Unit table input
      $resource->name = $request->input('name');
      $resource->resource_type_id = $request->input('type');

      if($request->input('type') == 1){
        if($request->hasFile('pdf')){
            $resource->link = $imageNameToStore;
        }
      }else{
        $resource->link = $request->input('url');
      }
      $resource->save();     

      return redirect('/resources/'.$resource->id)->with('success', 'Resource Updated');
    }

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $resourceupdate = Resource::find($id);
        if($resourceupdate->status == 1){
        $resourceupdate->status = 2;
        $resourceupdate->save();
        } 
        else
        {
        $resourceupdate->status = 1;
        $resourceupdate->save();
        }
        return redirect('/resources/'.$id)->with('success', 'Resource Updated');
    }

    public static function resourceinfo($id)
    {
        $resourceinfo = Resource::find($id);

        return $resourceinfo;
    }

    public static function typename($id)
    {
        $type = ResourceType::find($id);

        return $type->name;
    }
}
