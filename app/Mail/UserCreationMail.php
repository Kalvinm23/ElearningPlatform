<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Course;
use App\User;

class UserCreationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailuser;
    public $emailcourse;
    public $emailpassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userid, $courseid, $password)
    {
        $this->emailuser = User::find($userid);
        $this->emailcourse = Course::find($courseid);
        $this->emailpassword = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.usercreationmail');
    }
}
