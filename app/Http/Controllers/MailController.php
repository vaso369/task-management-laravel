<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $email_from = $request->input("email");
        $message = $request->input("message");

        $to = 'vasilije.vasilijevic.11.17@ict.edu.rs';
        $email_subject = "Task management contact form";
        $email_body = "You have received a new message from your website contact form.Here are the details:\n\nEmail: $email_from\n\nMessage:\n$message";
        $headers = "$email_from\n";
        $headers .= "Reply-To: $email_from";
        mail($to, $email_subject, $email_body, $headers);

    }

}
