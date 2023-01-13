<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Version;

class VersionsController extends Controller
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
        $aversions = Version::where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $iversions = Version::where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('versions.index')->with(compact('aversions', 'iversions'));
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
        return view('versions.create');
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
            'name' => 'required|unique:versions,name',
        ]);
        
        //create brand
        $version = new Version;
        $version->name = $request->input('name');
        $version->status = '1';
        $version->save();

        return redirect('/versions')->with('success', 'Version Created');
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
        $version = Version::find($id);

        $acourses = Version::find($id)->courses()->where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $icourses = Version::find($id)->courses()->where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('versions.show')->with(compact('version', 'acourses', 'icourses'));
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
        
        $version = Version::find($id);

        return view('versions.edit')->with('version', $version);
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

        $version = Version::find($id);
        //validate data
        $this->validate($request,[
            'name' => 'required|unique:versions,name,'.$version->id,
        ]);
        
        //create brand
        $version->name = $request->input('name');
        $version->save();

        return redirect('/versions')->with('success', 'Version Updated');
    }

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $versionupdate = Version::find($id);
        if($versionupdate->status == 1){
        $versionupdate->status = 2;
        $versionupdate->save();
        } 
        else
        {
        $versionupdate->status = 1;
        $versionupdate->save();
        }
        return redirect('/versions')->with('success', 'Version Updated');
    }

    public static function showname($id)
    {
        $version = Version::find($id);

        return $version->name;
    }
}
