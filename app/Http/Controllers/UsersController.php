<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserCreationMail;
use Illuminate\Support\Facades\Mail;
use App\Course;
use App\User;
use App\UserCourse;
use App\ResultType;

class UsersController extends Controller
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
        return view('users.index');
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

        $cdatas = Course::select('id', 'name')->where('status',1)->get();
        $courses = array();
        foreach ($cdatas as $cdata)
        {
            $courses[$cdata->id] = $cdata->name;
        }

        return view('users.create')->with(compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }

        //validate data
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'course' => 'required',

        ]);
        $password = str_random(10);
        //create user
        $user = new User;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($password);
        $user->status = 1;
        $user->permission = 1;
        $user->save();

        //create user course relationship
        $usercourse = new UserCourse;
        $usercourse->user_id = $user->id;
        $usercourse->course_id = $request->input('course');
        $usercourse->save();

        //send email
        Mail::to($request->input('email'))->send(new UserCreationMail($user->id, $request->input('course'), $password));


        return redirect('/')->with('success', 'User Created');
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
        $user = User::find($id);
        $courses = User::find($id)->courses;

        $rdatas = ResultType::select('id', 'name')->get();
        $results = array();
        foreach ($rdatas as $rdata)
        {
            $results[$rdata->id] = $rdata->name;
        }

        return view('users.show')->with(compact('user', 'courses', 'results'));
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

        $user = User::find($id);        
        
        $addcoursedatas = Course::select('id', 'name')->where('status', 1)->orderBy('name','asc')->get();
        $addcourse = array();
        foreach ($addcoursedatas as $addcoursedata)
        {
            $usercourses = UserCourse::where('user_id', $id)->where('course_id', $addcoursedata->id)->count();
            if($usercourses == 0){
                $addcourse[$addcoursedata->id] = $addcoursedata->name;
            }
        }
        
        return view('users.edit')->with(compact('user', 'addcourse'));
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
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }

        //validate data
        $this->validate($request,[
            'course' => 'required',
        ]); 

        //create user course relationship
        $usercourse = new UserCourse;
        $usercourse->user_id = $id;
        $usercourse->course_id = $request->input('course');
        $usercourse->save();

        return redirect('/users/'.$id)->with('success', 'Course Added');

    }

    public function removecourse($id)
    {
        $course = UserCourse::find($id);
        $course->delete();
        return redirect('/users/'.$course->user_id)->with('success', 'Course Removed');
    }

    public function search(Request $request, $id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }

        if($id == 1){
            $user = User::find($request->input('userid'));
            if($user != null){
                return redirect('users/'.$user->id);
            }else{
                return redirect('users')->with('error', 'No User found with ID of: '.$request->input('userid'));
            }
        }elseif($id == 2){
            $user = User::where('email', $request->input('email'))->get()->first();
            if($user != null){
                return redirect('users/'.$user->id);
            }else{
                return redirect('users')->with('error', 'No User found with email of: '.$request->input('email'));
            }
        }elseif($id == 3){
            $names = explode(" ", $request->input('name'));
            $users = User::where('first_name', $names)->orWhere('last_name', $names)->get();
            $count = User::where('first_name', $names)->orWhere('last_name', $names)->count();
            if($count > 0){
                return view('users.search')->with('users', $users);
            }else{
                return redirect('users')->with('error', 'No User found with name of: '.$request->input('name'));
            }
        }else{
            return redirect('users')->with('error', 'Error');
        }
    }
    

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        
        $userupdate = user::find($id);
        if($userupdate->status == 1){
        $userupdate->status = 2;
        $userupdate->save();
        $success = 'Account Suspended';
        } 
        else
        {
        $userupdate->status = 1;
        $userupdate->save();
        $success = 'Account Reinstated';
        }
        return redirect('/users/'.$id)->with(compact('success'));
    }

}
