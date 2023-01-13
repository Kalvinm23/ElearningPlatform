<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Assignment;
use App\AssignmentHelpsheet;
use App\Helpsheet;
use App\Unit;


class AssignmentHelpsheetsController extends Controller
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

        return view('assignmenthelpsheets.create')->with(compact('assignment'));
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
        $path = $request->file('pdf')->storeAs('public/helpsheets', $pdfNameToStore);

      //create Unit table input
        $helpsheet = new Helpsheet;
        $helpsheet->name = $request->input('name');
        $helpsheet->link = $pdfNameToStore;
        $helpsheet->status = 1;
        $helpsheet->save();     
      
      //create Assignment to Helpsheet relationship
      $ordercount = 0;
      $ordercount = AssignmentHelpsheet::where('Assignment_id', $id)->count();
      $ordercount++;

      $assignmenthelpsheet = new AssignmentHelpsheet;
      $assignmenthelpsheet->assignment_id = $id;
      $assignmenthelpsheet->helpsheet_id = $helpsheet->id;
      $assignmenthelpsheet->order = $ordercount;
      $assignmenthelpsheet->save();

      return redirect('/assignments/'.$id)->with('success', 'Helpsheet Created');
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
        $helpsheets = Assignment::find($id)->helpsheets()->orderBy('order','asc')->get();
        $assignments = Unit::find($assignment->unit_id)->assignments()->orderBy('order','asc')->get();

        $addhelpsheetdatas = Helpsheet::select('id', 'name')->where('status', 1)->orderBy('name','asc')->get();
        $addhelpsheets = [];
        foreach ($addhelpsheetdatas as $addhelpsheetdata)
        {
            $assignmenthelpsheets = AssignmentHelpsheet::where('assignment_id', $id)->where('helpsheet_id', $addhelpsheetdata->id)->count();
            if($assignmenthelpsheets == 0){
                $addhelpsheets[] = [
                    'id' => $addhelpsheetdata->id,
                    'name' => $addhelpsheetdata->name,
                ];
            }

        }

        return view('assignmenthelpsheets.edit')->with(compact('assignment', 'assignments', 'helpsheets', 'addhelpsheets'));
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
            $assignmenthelpsheet = AssignmentHelpsheet::find($order_id[$count]);
            $assignmenthelpsheet->order = $ordercount;
            $assignmenthelpsheet->save();
            $ordercount++;
            
        }
        
        return redirect('/assignments/'.$assignmenthelpsheet->assignment_id)->with('success', 'Helpsheets Updated');
    }

    public function createrelationship($aid, $hid)
    {      
        //create Unit to Course relationship
        $ordercount = 0;
        $ordercount = AssignmentHelpsheet::where('assignment_id', $aid)->count();
        $ordercount++;
  
        $assignmenthelpsheet = new AssignmentHelpsheet;
        $assignmenthelpsheet->assignment_id = $aid;
        $assignmenthelpsheet->helpsheet_id = $hid;
        $assignmenthelpsheet->order = $ordercount;
        $assignmenthelpsheet->save();
  
        return redirect('/assignments/'.$aid)->with('success', 'Helpsheet added to Assignment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $helpsheet = AssignmentHelpsheet::find($id);
        $helpsheet->delete();
        return redirect('/assignments/'.$helpsheet->assignment_id)->with('success', 'Helpsheet Removed');
    }
}
