<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\Test;

use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function index()
    {
        $content = [
            'subject' => 'This is the mail subject',
            'body' => 'This is the email body of how to send email from laravel 10 with mailtrap.'
        ];

        Mail::mailer('smtp')->to('dlbastille@alaska.edu')->send(new Test($content));

        return "Email has been sent.";
    }
}
