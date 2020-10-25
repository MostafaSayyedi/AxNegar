<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialNetworkController extends Controller
{
    public function socialNetwork()
    {
        $socials= SocialAccount::all();
        return view('user.social.index', compact('socials'));
    }
    public function socialAdd()
    {
        return view('user.social.create');
    }
    public function socialStore(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:8'],
            'src' => ['required', 'string', 'min:8'],
            'photo' => ['required'],
        ]);

// upload social icon
        $imagePath = $request->file('photo');
        $imageName = time() . '.' . $imagePath ->getClientOriginalExtension();
        $imageDir= Auth::id().'/';
        $dir='social/icon/'.$imageDir;
        $imagePath ->move($dir, $imageName );
//save data
        $social= new SocialAccount();
        $social->name=$request->name;
        $social->src=$request->src;
        $social->icon= $imageDir.$imageName;
        $social->user_id = auth()->user()->id;

        if($social->save())
            alert()->success('شبکه اجتماعی شما با موفقیت ذخیره شد', 'success');
        else
            alert()->error('خطایی به وجود آمده', 'error');
        return view('user.social.create');
    }

    public function destroy($id)
    {
//        dd('j');
        $social = SocialAccount::findOrFail($id);
        if ($social->delete())
            alert()->success('شبکه اجتماعی با موفقیت حذف یافت', 'success');
        else
            alert()->error('مشکلی بوجود آمده است!', 'error');
        return redirect()->route('admin.social');
    }
}

