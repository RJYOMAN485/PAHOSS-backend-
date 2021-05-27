<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        $data = array('name' => "Virat Gandhi");

        Mail::send(['text' => 'mail'], $data, function ($message) {
            $message->to('ujjali485@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from('pahosscenter@gmail.com', 'Pahoss Aizawl');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
}
