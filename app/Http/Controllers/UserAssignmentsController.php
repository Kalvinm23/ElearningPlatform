<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAssignment;
use App\ResultType;

class UserAssignmentsController extends Controller
{    
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request, $aid, $uid)
   {
       //validate data
       $this->validate($request,[
           'result' => 'required',
       ]); 

       //create Assignment table input
       $assignment = new UserAssignment;
       $assignment->user_id = $uid;
       $assignment->assignment_id = $aid;
       $assignment->result_type_id = $request->input('result');
       $assignment->save();     
 
       return redirect('/users/'.$uid)->with('success', 'Timetable Updated');
   }
    
   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //validate data
      $this->validate($request,[
          'result' => 'required',
      ]); 

      //create Assignment table input
      $assignment = UserAssignment::find($id);
      $assignment->result_type_id = $request->input('result');
      $assignment->save();     

      return redirect('/users/'.$assignment->user_id)->with('success', 'Timetable Updated');
  }

   public static function results($uid, $aid)
   {
       $result = UserAssignment::where('user_id', '=' , $uid)->where('assignment_id', '=' , $aid)->get()->first();

       return $result;
   }

   public static function previousresult($uid, $aid)
   {
       $result = UserAssignment::where('user_id', '=' , $uid)->where('assignment_id', '=' , $aid)->where('result_type_id', '!=' , 4)->get()->first();

       return $result;
   }

   public static function showresulttype($id)
   {
       $result = ResultType::find($id);

       return $result->name;
   }
}
