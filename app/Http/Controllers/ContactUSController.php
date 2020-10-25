<?php

namespace App\Http\Controllers;

use App\AboutUs;
use App\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUSController extends Controller
{

    public function aboutUs()
    {
        $about= AboutUs::first();
        return view('about-us', compact('about'));
    }
    public function contactUS()
    {
        return view('contact-us');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactSaveData(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        ContactUS::create($request->all());
        Mail::send('emails.contactus',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'subject' => $request->get('subject'),
                'user_message' => $request->get('message')
            ), function($message) use ($request)
            {
                $message->from($request->get('email'));
                $message->to('kashefymajid1992@gmail.com', 'Admin')->subject($request->get('subject'));
            });
        alert()->success('پیام با موفقیت ارسال شد','success');
        return back()->with('success', 'Thanks for contacting us!');
    }
}
