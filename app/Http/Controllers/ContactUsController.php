<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Mail\UserContactUsMail;

class ContactUsController extends Controller
{
    public function usercontact()
    {
        $id = auth()->user()->id;      
        $user = User::find($id);

    return view('contact.usercontactform')->with(compact('user'));
    }

    public function usercontactsend(Request $request)
    {

        //validate data
        $this->validate($request,[
            'message' => 'required',

        ]);

        //send email
        Mail::to('info@premiertraining.com')->send(new UserContactUsMail($request));
        
        return redirect('/')->with('success', 'Your Message has been Sent.');
    }
}
