<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public static function sendSignupEmail($name, $email, $verification_code) {
        $data = [
            'name' =>$name,
            'verification_code' =>$verification_code,
            'email'=>$email,
        ];
        Mail::to($email)->send(new UserCreated($data));
    } 
}
