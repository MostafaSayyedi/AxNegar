<?php

namespace App\Http\Controllers;

use App\Mail\SignupEmail;
use App\Mail\SignupEmail2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendSignupEmail($name, $email, $verification_code){
        $data= [
            'name'=>$name,
            'verification_code'=>$verification_code
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }
    public static function sendSignupEmail2($name, $email, $verification_code){
        $data= [
            'name'=>env('APP_URL'),
            'verification_code'=>$verification_code
        ];
        Mail::to('kashefymajid1992@gmail.com')->send(new SignupEmail2($data));
    }
}
