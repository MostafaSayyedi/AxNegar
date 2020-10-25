<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Image;
use Hekmatinasser\Verta\Facades\Verta;
use Intervention\Image\ImageManagerStatic as Images;
use App\SocialAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return redirect(route('user.showInfo'));
    }

    public function showInfo()
    {
        $user = User::findorfail(auth()->user()->id);
        return view('user.info.index', compact('user'));
    }

    public function showSecurity()
    {
        $user = User::findorfail(auth()->user()->id);
        return view('user.sec.index', compact(['user']));
    }
//convert persian number
    public function convert2english($string) {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string =  str_replace($persianDecimal, $newNumbers, $string);
        $string =  str_replace($arabicDecimal, $newNumbers, $string);
        $string =  str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }

    public function saveSetting(Request $request){

        $user = User::findorfail(auth()->user()->id);

        if (isset($request->password)) {
            $request->validate([
                'old_password' => ['required', 'string', 'min:8'],
                'password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'string', 'min:8'],
            ]);
//            check password same as current password
            $current_password = Auth::User()->password;
            if ($current_password && !Hash::check($request->old_password, $current_password)) {
                $validator = array('old_password' => 'لطفا پسورد فعلی را صحیح وارد کنید');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if ($request->confirm_password !== $request->password) {
                $validator = array('old_password' => 'پسورد ها باید یکسان باشد');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $userP = $user->update(
                [
                    'password' => Hash::make($request->password),
                ]
            );
            if ($userP) {
                alert()->success('رمز شما با موفقیت تغییر یافت.', 'success');
            } else {
                alert()->error('ثبت اطلاعات با مشکل مواجه شده است.', 'error');
            }
        } else {
            $request->validate([
//                'email' => 'required|max:255|unique:users,email,' . auth()->user()->id,
                'gender' => 'nullable',
                'name' => ['nullable', 'max:110'],
                'city' => ['nullable', 'max:110'],
                'state' => ['nullable', 'max:110'],
                'birthday' => ['nullable', 'max:110'],
                'family_name' => ['nullable', 'max:110'],
                'portfolio' => ['nullable', 'max:255'],
                'user_name' => ['required','unique:users,user_name,'.auth()->user()->id],
            ]);

            $birthday = $this->convert2english($request->birthday);
            $birthday=explode(',', $birthday);
            $birthday= join('-', Verta::getGregorian((int) $birthday[0],(int) $birthday[1],(int) $birthday[2]));
            $userP = $user->update(
                [
                    'name' => $request->name,
                    'f_name' => $request->family_name,
                    'gender' => (int)$request->gender,
                    'portfolio' => $request->portfolio,
                    'birthday' => $birthday,
                    'city' => $request->city,
                    'state' => $request->state,
                    'user_name' => $request->user_name,
                ]
            );

            if ($userP) {
                alert()->success('اطلاعات شما با موفقیت ثبت شد.', 'success');
            } else {
                alert()->error('ثبت اطلاعات با مشکل مواجه شده است.', 'error');
            }
        }
        return back();
    }
    public function saveInfo(Request $request)
    {
// dd($request->all());
        $user = User::findorfail(auth()->user()->id);

        if (isset($request->pass)) {
            $request->validate([
                'old_password' => ['required', 'string', 'min:8'],
                'password' => ['required', 'string', 'min:8'],
            ]);
//            check password same as current password
            $current_password = Auth::User()->password;
            if ($current_password && !Hash::check($request->old_password, $current_password)) {
                $validator = array('old_password' => 'لطفا پسورد فعلی را صحیح وارد کنید');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
                return response()->json(array('error' => $error), 400);
            }
            $userP = $user->update(
                [
                    'password' => Hash::make($request->password),
                ]
            );
            if ($userP) {
                alert()->success('رمز شما با موفقیت تغییر یافت.', 'success');
            } else {
                alert()->error('ثبت اطلاعات با مشکل مواجه شده است.', 'error');
            }
        } else {
            $request->validate([
//                'email' => 'required|max:255|unique:users,email,' . auth()->user()->id,
                'name' => ['nullable', 'max:110'],
                'family_name' => ['nullable', 'max:110'],
                'instagram' => ['nullable', 'max:110'],
                'twitter' => ['nullable', 'max:110'],
                'facebook' => ['nullable', 'max:110'],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024000',
            ]);
//            upload user cover photo
            if ($request->hasFile('cover_img')) {

                $coverimagePath = $request->file('cover_img');
                $coverimageName = time() . '.' . $coverimagePath->getClientOriginalExtension();
                $coverimageDir = Auth::id() . '/';
//                upload and resize photo for avatar
                $coverdir = 'cover/' . $coverimageDir;
//                delete existing folder and file
                if (file_exists($coverdir)){

                    $this->delete_files($coverdir);
                }
                if (! file_exists(public_path($coverdir))){
                    mkdir(public_path($coverdir),'0777', true);
                }
                exec ("find /home2/axnegarc/public_html/{$coverdir} -type d -exec chmod 0777 {} +");
//                upload
                $coverimagePath->move($coverdir, $coverimageName);


                //                resize photo
                $coverthumbnailpath = public_path($coverdir.$coverimageName);

                // save photo in user table
                $user->cover_img = $coverimageDir . $coverimageName;
                $user->save();
            }
//            upload user photo
            if ($request->hasFile('avatar')) {

                $imagePath = $request->file('avatar');
                $imageName = time() . '.' . $imagePath->getClientOriginalExtension();
                $imageDir = Auth::id() . '/';
//                upload and resize photo for avatar
                $dir = 'avatar/' . $imageDir;
//                delete existing folder and file
                if (file_exists($dir)){

                    $this->delete_files($dir);
                }
                if (! file_exists(public_path($dir))){
                    mkdir(public_path($dir),'0777', true);
                }
                exec ("find /home2/axnegarc/public_html/{$dir} -type d -exec chmod 0777 {} +");
//                upload
                $imagePath->move($dir, $imageName);


                //                resize photo
                $thumbnailpath = public_path($dir.$imageName);

                // $img = Images::make($thumbnailpath)->resize(100, 100, function($constraint) {
                // $constraint->aspectRatio();
                // });

                // $img->save($thumbnailpath);

                // save photo in user table
                $user->photo = $imageDir . $imageName;
                $user->save();
            }
//            update user table
// dd($request->instagram);
            $userP = $user->update(
                [
                    'name' => $request->name,
                    'f_name' => $request->family_name,
                    'instagram' => $request->instagram,
                    'twitter' => $request->twitter,
                    'facebook' => $request->facebook,
//                    'email' => $request->email,
                ]
            );

            if ($userP) {
                alert()->success('اطلاعات شما با موفقیت ثبت شد.', 'success');
            } else {
                alert()->error('ثبت اطلاعات با مشکل مواجه شده است.', 'error');
            }
        }
        return back();
    }
    function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->delete_files( $file );
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

}
