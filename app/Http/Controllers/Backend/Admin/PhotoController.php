<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\User;
use Illuminate\Http\Request;

class PhotoController extends Controller
{


    public function index()
    {
        $photos= Image::with('user','category')->get();
//        dd($photos);
        return view('admin.photo.index', compact('photos'));
    }
    public function changeStatus($id, $status)
    {
        if ($status == 1)
            $status = '0';
        elseif ($status == 0)
            $status = '1';
        $user = Image::findorfail($id);
        $user->status = $status;
        $user->update();
        return back()->with('success','تغییر وضعیت انجام شد');
    }
}
