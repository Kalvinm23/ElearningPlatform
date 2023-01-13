<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpsheet;

class HelpsheetsController extends Controller
{
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
        $ahelpsheets = Helpsheet::where('status', '=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'active');
        $ihelpsheets = Helpsheet::where('status', '!=' , 1)->orderBy('name','asc')->paginate(9, ['*'], 'inactive');

        return view('helpsheets.index')->with(compact('ahelpsheets', 'ihelpsheets'));
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

        return view('helpsheets.create');
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

      return redirect('/helpsheets/'.$helpsheet->id)->with('success', 'Helpsheet Created');
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
        $helpsheet = Helpsheet::find($id);
        $relationships = Helpsheet::find($id)->assignments()->paginate(9);

        return view('helpsheets.show')->with(compact('helpsheet', 'relationships'));
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
        $helpsheet = Helpsheet::find($id);

        return view('helpsheets.edit')->with(compact('helpsheet'));
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
        ]);
        $helpsheet = Helpsheet::find($id);

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
        $path = $request->file('pdf')->storeAs('public/helpsheets', $imageNameToStore);
        //Delete previous file
        Storage::delete('public/helpsheets/'.$helpsheet->link);

        }

      //create Unit table input
        $helpsheet->name = $request->input('name');
        if($request->hasFile('pdf')){
            $helpsheet->link = $imageNameToStore;
        }
        $helpsheet->save();     

      return redirect('/helpsheets/'.$helpsheet->id)->with('success', 'Helpsheet Updated');
    }

    public function status($id)
    {
        // Check for correct user
        if(auth()->user()->permission !== 2){
            return redirect('/')->with('error', 'Unauthorised Page');
        }
        $helpsheetupdate = Helpsheet::find($id);
        if($helpsheetupdate->status == 1){
        $helpsheetupdate->status = 2;
        $helpsheetupdate->save();
        } 
        else
        {
        $helpsheetupdate->status = 1;
        $helpsheetupdate->save();
        }
        return redirect('/helpsheets/'.$id)->with('success', 'Helpsheet Updated');
    }

    public static function helpsheetinfo($id)
    {
        $helpsheetinfo = Helpsheet::find($id);

        return $helpsheetinfo;
    }
}
