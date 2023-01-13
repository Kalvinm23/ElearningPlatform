<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;

class UnitsController extends Controller
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
        $aunits = Unit::where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $iunits = Unit::where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('units.index')->with(compact('aunits', 'iunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::find($id);
        $assignments = Unit::find($id)->assignments()->orderBy('order','asc')->get();

        return view('units.show')->with(compact('unit', 'assignments'));
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
        
        $unit = Unit::find($id);

        return view('units.edit')->with(compact('unit'));
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
        'description' => 'required',

      ]);
      $unit = Unit::find($id);
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
            Storage::delete('public/unitimages/'.$unit->image);

            }

      //create product table input
      $unit->name = $request->input('name');
      if($request->hasFile('image')){
          $unit->image = $imageNameToStore;
      }
      $unit->description = $request->input('description');
      $unit->save();

      return redirect('/units/'.$unit->id)->with('success', 'Unit Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $unitupdate = Unit::find($id);
        if($unitupdate->status == 1){
        $unitupdate->status = 2;
        $unitupdate->save();
        } 
        else
        {
        $unitupdate->status = 1;
        $unitupdate->save();
        }
        return redirect('/units/'.$id)->with('success', 'Unit Updated');
    }

    public static function showname($id)
    {
        $unit = Unit::find($id);

        return $unit->name;
    }

    public static function findassignments($id)
    {
        $assignments = Unit::find($id)->assignments()->orderBy('order','asc')->get();

        return $assignments;
    }
}
