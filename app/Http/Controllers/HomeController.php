<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Course;
use App\User;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $permission = auth()->user()->permission;
        if($permission == 1){
            $id = auth()->user()->id;
            $user = User::find($id);
            $courses = User::find($id)->courses;

            return view('home.home')->with(compact('user', 'courses'));
        }else{
            return redirect('/users');
        }
    }

    public static function courseinfo($id)
    {
        $courseinfo = Course::find($id);

        return $courseinfo;
    }
}
