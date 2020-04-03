<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $emailFrom = $request->input("email");
        $message = $request->input("message");

        $data = array('name' => "Virat Gandhi");

        Mail::send(['text' => 'mail'], $emailFrom, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject
                ('Task management system support');
            $message->from($emailFrom);
        });
    }

}
