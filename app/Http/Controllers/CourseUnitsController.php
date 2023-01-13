<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Unit;
use App\CourseUnit;

class CourseUnitsController extends Controller
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
    public function addnewunit($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $course = Course::find($id);

        return view('courseunits.create')->with(compact('course'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createnewunit(Request $request, $id)
    {
        //validate data
        $this->validate($request,[
          'name' => 'required',
          'image' => 'required|image|max:2000',
          'description' => 'required',

      ]);
      //Handle Unit Image Upload
      //Get Image name with extension
      $filenameWithExt = $request->file('image')->getClientOriginalName();
      //Get just Image name
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      //Get Image extension
      $extension = $request->file('image')->getClientOriginalExtension();
      //Image name to store
      $imageNameToStore = $filename.'_'.time().'.'.$extension;
      //Upload Image
      $path = $request->file('image')->storeAs('public/unitimages', $imageNameToStore);

      //create Unit table input
      $unit = new Unit;
      $unit->name = $request->input('name');
      $unit->image = $imageNameToStore;
      $unit->description = $request->input('description');
      $unit->status = 1;
      $unit->save();     
      
      //create Unit to Course relationship
      $ordercount = 0;
      $ordercount = CourseUnit::where('course_id', $id)->count();
      $ordercount++;

      $courseunit = new CourseUnit;
      $courseunit->course_id = $id;
      $courseunit->unit_id = $unit->id;
      $courseunit->order = $ordercount;
      $courseunit->save();

      return redirect('/courses/'.$id)->with('success', 'Unit Created');
    }

    public function addunit($cid, $uid)
    {      
        //create Unit to Course relationship
        $ordercount = 0;
        $ordercount = CourseUnit::where('course_id', $cid)->count();
        $ordercount++;
  
        $courseunit = new CourseUnit;
        $courseunit->course_id = $cid;
        $courseunit->unit_id = $uid;
        $courseunit->order = $ordercount;
        $courseunit->save();
  
        return redirect('/courses/'.$cid)->with('success', 'Unit added to Course');
    }

    public function edit($id)
    {
        $course = Course::find($id);
        $units = Course::find($id)->units()->orderBy('order','asc')->paginate(10);

        $addunitdatas = Unit::select('id', 'name')->where('status', 1)->orderBy('name','asc')->get();
        $addunits = [];
        foreach ($addunitdatas as $addunitdata)
        {
            $unitcourse = CourseUnit::where('course_id', $id)->where('unit_id', $addunitdata->id)->count();
            if($unitcourse == 0){
                $addunits[] = [
                    'id' => $addunitdata->id,
                    'name' => $addunitdata->name,
                ];
            }

        }
        return view('courseunits.edit')->with(compact('course', 'units', 'addunits'));
    }

    public function update(Request $request)
    {   
        
        $order_id = $request->input('order_id');
        $ordercount = 1;
        for($count = 0; $count < count($order_id); $count++)
        {
            $courseunit = CourseUnit::find($order_id[$count]);
            $courseunit->order = $ordercount;
            $courseunit->save();
            $ordercount++;
            
        }
        
        return redirect('/courses/'.$courseunit->course_id)->with('success', 'Units Updated');
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = CourseUnit::find($id);
        $unit->delete();
        return redirect('/courses/'.$unit->course_id)->with('success', 'Unit Removed');
    }

}
