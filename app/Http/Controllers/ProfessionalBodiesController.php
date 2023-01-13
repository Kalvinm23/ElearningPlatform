<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProfessionalBody;

class ProfessionalBodiesController extends Controller
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
        $aprofessionalbodies = ProfessionalBody::where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $iprofessionalbodies = ProfessionalBody::where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('professionalbodies.index')->with(compact('aprofessionalbodies', 'iprofessionalbodies'));
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
        return view('professionalbodies.create');
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
            'name' => 'required|unique:professional_bodies,name',
        ]);
        
        //create brand
        $professionalbody = new ProfessionalBody;
        $professionalbody->name = $request->input('name');
        $professionalbody->status = '1';
        $professionalbody->save();

        return redirect('/professionalbodies')->with('success', 'Professional Body Created');
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
        $professionalbody = ProfessionalBody::find($id);

        $acourses = ProfessionalBody::find($id)->courses()->where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $icourses = ProfessionalBody::find($id)->courses()->where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('professionalbodies.show')->with(compact('professionalbody', 'acourses', 'icourses'));
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
        
        $professionalbody = ProfessionalBody::find($id);

        return view('professionalbodies.edit')->with('professionalbody', $professionalbody);
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

        $professionalbody = ProfessionalBody::find($id);
        //validate data
        $this->validate($request,[
            'name' => 'required|unique:professional_bodies,name,'.$professionalbody->id,
        ]);
        
        //create brand
        $professionalbody->name = $request->input('name');
        $professionalbody->save();

        return redirect('/professionalbodies')->with('success', 'Professional Body Updated');
    }

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $professionalbodyupdate = ProfessionalBody::find($id);
        if($professionalbodyupdate->status == 1){
        $professionalbodyupdate->status = 2;
        $professionalbodyupdate->save();
        } 
        else
        {
        $professionalbodyupdate->status = 1;
        $professionalbodyupdate->save();
        }
        return redirect('/professionalbodies')->with('success', 'Professional Body Updated');
    }

    public static function showname($id)
    {
        $professionalbody = ProfessionalBody::find($id);

        return $professionalbody->name;
    }

}
