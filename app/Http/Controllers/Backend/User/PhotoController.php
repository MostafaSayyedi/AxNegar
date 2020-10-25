<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request;

class PhotoController extends Controller
{


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        if ($image->status == 'فعال') {
            $image->status = '0';
        } else {
            $image->status = '1';
        }

        if ($image->update())
            return back()->with('success', 'تغییر با موفقیت انجام شد');

        return back()->with('fail', 'خطا رخ داده است');

    }
}
