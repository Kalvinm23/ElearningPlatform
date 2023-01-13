<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Unit;
use App\AssignmentType;

class AssignmentsController extends Controller
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
        $unit = Unit::find($id);

        $tdatas = AssignmentType::select('id', 'name')->get();
        $types = array();
        foreach ($tdatas as $tdata)
        {
            $types[$tdata->id] = $tdata->name;
        }

        return view('assignments.create')->with(compact('unit', 'types'));
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
            'type' => 'required',
            'name' => 'required',
            'url' => 'required',
            'description' => 'required',
        ]); 
        
        //create Assignment to Unit relationship
        $ordercount = 0;
        $ordercount = Assignment::where('unit_id', $id)->count();
        $ordercount++;

        //create Assignment table input
        $assignment = new Assignment;
        $assignment->name = $request->input('name');
        $assignment->assignment_type_id = $request->input('type');
        $assignment->unit_id = $id;
        $assignment->link = $request->input('url');
        $assignment->description = $request->input('description');
        $assignment->order = $ordercount;
        $assignment->save();     
  
        return redirect('/units/'.$id)->with('success', 'Assignment Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unitedit($id)
    {
        $unit = Unit::find($id);
        $assignments = Unit::find($id)->assignments()->orderBy('order','asc')->get();
        return view('assignments.unitedit')->with(compact('unit', 'assignments'));
    }

    public function orderupdate(Request $request)
    {   
        
        $order_id = $request->input('order_id');
        $ordercount = 1;
        for($count = 0; $count < count($order_id); $count++)
        {
            $assignments = Assignment::find($order_id[$count]);
            $assignments->order = $ordercount;
            $assignments->save();
            $ordercount++;
            
        }
        
        return redirect('/units/'.$assignments->unit_id)->with('success', 'Assignments Updated');
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::find($id);
        $resources = Assignment::find($id)->resources()->orderBy('order','asc')->get();
        $helpsheets = Assignment::find($id)->helpsheets()->orderBy('order','asc')->get();
        $assignments = Unit::find($assignment->unit_id)->assignments()->orderBy('order','asc')->get();

        return view('assignments.show')->with(compact('assignment', 'assignments', 'resources', 'helpsheets'));
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
        $assignment = Assignment::find($id);

        $tdatas = AssignmentType::select('id', 'name')->get();
        $types = array();
        foreach ($tdatas as $tdata)
        {
            $types[$tdata->id] = $tdata->name;
        }

        return view('assignments.edit')->with(compact('assignment', 'types'));
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
            'type' => 'required',
            'name' => 'required',
            'url' => 'required',
            'description' => 'required',

      ]);
      $assignment = Assignment::find($id);

    //create assignment table input
    $assignment->name = $request->input('name');
    $assignment->assignment_type_id = $request->input('type');
    $assignment->link = $request->input('url');
    $assignment->description = $request->input('description');
    $assignment->save();  

      return redirect('/assignments/'.$id)->with('success', 'Assignment Updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignment = Assignment::find($id);
        $assignment->delete();

        $assignmentorders = Assignment::where('unit_id', '=' , $assignment->unit_id)->get();

        $ordercount = 1;

        
        foreach ($assignmentorders as $assignmentorder)
        {
            $assignments = Assignment::find($assignmentorder->id);
            $assignments->order = $ordercount;
            $assignments->save();
            $ordercount++;
        }

        return redirect('/units/'.$assignment->unit_id)->with('success', 'Assignment Removed');
    }

    public static function showname($id)
    {
        $assignment = Assignment::find($id);

        return $assignment->name;
    }

    
    public static function assignmentinfo($id)
    {
        $assignment = Assignment::find($id);

        return $assignment;
    }

    public static function previousassignment($uid, $order)
    {
        $assignment = Assignment::where('unit_id', '=' , $uid)->where('order', '=' , $order)->get()->first();

        return $assignment->id;
    }
}
