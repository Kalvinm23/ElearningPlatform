<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Course;
use App\ProfessionalBody;
use App\Version;
use App\CourseUnit;
use App\Unit;
use App\UserCourse;
use Auth;

class CoursesController extends Controller
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
        $acourses = Course::where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $icourses = Course::where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('courses.index')->with(compact('acourses', 'icourses'));
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

        $pdatas = ProfessionalBody::select('id', 'name')->get();
        $professionalbodies = array();
        foreach ($pdatas as $pdata)
        {
            $professionalbodies[$pdata->id] = $pdata->name;
        }

        $vdatas = Version::select('id', 'name')->get();
        $versions = array();
        foreach ($vdatas as $vdata)
        {
            $versions[$vdata->id] = $vdata->name;
        }

        return view('courses.create')->with(compact('professionalbodies', 'versions'));
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
          'professionalbody' => 'required',
          'version' => 'required',
          'image' => 'required|image|max:2000',
          'description' => 'required',

      ]);
      //Handle Course Image Upload
      //Get Image name with extension
      $filenameWithExt = $request->file('image')->getClientOriginalName();
      //Get just Image name
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      //Get Image extension
      $extension = $request->file('image')->getClientOriginalExtension();
      //Image name to store
      $imageNameToStore = $filename.'_'.time().'.'.$extension;
      //Upload Image
      $path = $request->file('image')->storeAs('public/courseimages', $imageNameToStore);

      //create product table input
      $course = new Course;
      $course->name = $request->input('name');
      $course->professional_body_id = $request->input('professionalbody');
      $course->version_id = $request->input('version');
      $course->image = $imageNameToStore;
      $course->description = $request->input('description');
      $course->status = 1;
      $course->save();

      return redirect('/courses')->with('success', 'Course Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $units = Course::find($id)->units()->orderBy('order','asc')->paginate(10);

        $addunitdatas = Unit::select('id', 'name')->get();
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
        
        // Check for correct user
            if(auth()->user()->permission !== 2){
                $user_id = auth()->user()->id;                
                $usercheck = UserCourse::where('user_id', '=' , $user_id)->where('course_id', '=' , $id)->count();
                if($usercheck == 0){
                    return redirect('/users')->with('error', 'Unauthorised Page');
                }
            
            }

        return view('courses.show')->with(compact('course', 'units', 'addunits'));
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

        $pdatas = ProfessionalBody::select('id', 'name')->get();
        $professionalbodies = array();
        foreach ($pdatas as $pdata)
        {
            $professionalbodies[$pdata->id] = $pdata->name;
        }

        $vdatas = Version::select('id', 'name')->get();
        $versions = array();
        foreach ($vdatas as $vdata)
        {
            $versions[$vdata->id] = $vdata->name;
        }
        
        $course = Course::find($id);

        return view('courses.edit')->with(compact('course', 'professionalbodies', 'versions'));
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
        'professionalbody' => 'required',
        'version' => 'required',
        'description' => 'required',

      ]);
      $course = Course::find($id);
      //Handle Product Image Upload
        if($request->hasFile('image')){

            //validate data
            $this->validate($request,[
                'image' => 'required|image|max:2000',
            ]);
      
            //Get Image name with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //Get just Image name
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Image extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Image name to store
            $imageNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('image')->storeAs('public/courseimages', $imageNameToStore);
            //Delete previous file
            Storage::delete('public/courseimages/'.$course->image);

            }

      //create product table input
      $course->name = $request->input('name');
      $course->professional_body_id = $request->input('professionalbody');
      $course->version_id = $request->input('version');
      if($request->hasFile('image')){
          $course->image = $imageNameToStore;
      }
      $course->description = $request->input('description');
      $course->save();

      return redirect('/courses/'.$course->id)->with('success', 'Course Updated');
    }

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $courseupdate = Course::find($id);
        if($courseupdate->status == 1){
        $courseupdate->status = 2;
        $courseupdate->save();
        } 
        else
        {
        $courseupdate->status = 1;
        $courseupdate->save();
        }
        return redirect('/courses')->with('success', 'Course Updated');
    }

    public static function unitinfo($id)
    {
        $unitinfo = Unit::find($id);

        return $unitinfo;
    }

    public static function showname($id)
    {
        $course = Course::find($id);

        return $course->name;
    }

    public static function findunits($id)
    {
        $units = Course::find($id)->units;

        return $units;
    }


}
