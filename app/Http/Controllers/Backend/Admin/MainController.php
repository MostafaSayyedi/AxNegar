<?php

namespace App\Http\Controllers\Backend\Admin;

use App\AboutUs;
use App\ContactUs;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
//manage contact us messages
    public function contactUs()
    {
        $contacts = ContactUs::all();
        return view('admin.contactus.index', compact('contacts'));
    }

    public function contactUsDestroy($id)
    {
        $contact = ContactUs::findOrFail($id);

        if ($contact->delete())
            return back()->with('success', 'عملیات حذف با موفقیت انجام شد');

        return back()->with('error', 'مشکلی رخ داده است !لطفا مجددا تلاش کنید');
    }


    public function mainPage()
    {
        return view('admin.main.index');
    }

//create about us page
    public function aboutUsCreate()
    {
        $about = AboutUs::first();
        if (!$about) {
            $about = new AboutUs();
            $about->description = '';
            $about->save();
        }
        return view('admin.aboutus.create', compact('about'));
    }

    public function aboutUsStore(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        $about = AboutUs::first();
        $about->description = $request->description;
        if ($about->update()) {
            return back()->with('success', 'صفحه در باره ما اضافه شد');
        }
        return back()->with('error', 'خطا! لظفا مددا تلاش کنید');
    }


}
