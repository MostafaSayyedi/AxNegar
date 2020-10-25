<?php

namespace App\Http\Controllers\Backend\User;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;
use UxWeb\SweetAlert\SweetAlert;
use Intervention\Image\ImageManagerStatic as Images;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        return view('front.user.show_uploader');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        SweetAlert::success('Success Message', 'Optional Title....');
//        alert()->success('Success Message', 'Optional Title000');
        $user = Auth::user();
        $categories= Category::all();
        return view('user.uploader.create', compact(['user','categories']));
    }

    public function generateRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|min:1,max:100000',
            'title' => 'nullable',
            'category'=> 'required'
        ]);
//    make random hash
// make random key
        $rndKey = $this->generateRandomString(16);
        
        $exif = [];
        // for each pictures
        if ($image = $request->file('images')) {
            //die(public_path());
            foreach ($image as $file) {
//                make hash and check if image has uploaded in database
                $checkImg = \App\Image::where('f_hash', hash_file('sha256', $file))->first(); // check for uploaded photo
                $filedata = @exif_read_data($file, '', true);
                if ($checkImg || !isset($filedata['EXIF'])) {
                    continue; // if uploaded dont need to continue
                }
                // store image title in database
                $userId = Auth::id();
                $user = Auth::user();
                $image = new \App\Image();
                $image->user_id = $userId;
                $image->category_id = $request->category;
                $image->title = $request->title;
                $image->f_hash = hash_file('sha256', $file);
                $image->p_hash = $rndKey;

                //get filename with extension
                $filenamewithextension = $file->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $file->getClientOriginalExtension();

                //filename to store
                $uniqId=uniqid();
                $filenametostore = $filename . '_' . $uniqId . '.' . $extension;
                $newFilenametostore = $filename . '_' . $uniqId . '.png';
                $pathImage = $userId . '/' . $filenametostore;
                $newPathImage = $userId . '/changes/' . $newFilenametostore;
                $sliderPathPhoto = $userId . '/slider/' . $filenametostore;
                $galleryPathPhoto = $userId . '/gallery/' . $filenametostore;
                $basicDir= 'storage/photo/';


                if (! file_exists(storage_path('app/public/photo/'.$userId))){
                    mkdir(storage_path('app/public/photo/'.$userId),'0777', true);
                }
//                shell_exec('chown -R www-data:www-data /var/www/html/laravel/public/storage/photo/1');
                exec ("find /var/www/html/laravel/storage/app/public/photo/{$userId} -type d -exec chmod 0777 {} +");
                exec ("find /home2/axnegarc/laravel/storage/app/public/photo/{$userId} -type d -exec chmod 0777 {} +");

                Storage::put('public/photo/' . $pathImage, fopen($file, 'r+'));


                //Resize image for index slider
                if (! file_exists(storage_path('app/public/photo/'.$userId.'/slider/'))){
                    mkdir(storage_path('app/public/photo/'.$userId.'/slider'),'0777', true);
                }
//                exec ("find /var/www/html/laravel/public/storage/photo/{$userId}/slider -type d -exec chmod 0777 {} +");
                exec ("find /var/www/html/laravel/storage/app/public/photo/{$userId}/slider -type d -exec chmod 0777 {} +");
                exec ("find /home2/axnegarc/laravel/storage/app/public/photo/{$userId}/slider -type d -exec chmod 0777 {} +");

                Storage::put('public/photo/' . $sliderPathPhoto, fopen($file, 'r+'));
//local
                $sliderPhoto = public_path('storage/photo/' . $sliderPathPhoto);
       //online
//                $sliderPhoto = public_path('storage/public/photo/' . $sliderPathPhoto);
                $img = Images::make($sliderPhoto)->resize(1280, 720, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($sliderPhoto);


                //Resize image for galleries
                if (! file_exists(storage_path('app/public/photo/'.$userId.'/gallery/'))){
                    mkdir(storage_path('app/public/photo/'.$userId.'/gallery'),'0777', true);
                }
                exec ("find /var/www/html/laravel/storage/app/public/photo/{$userId}/gallery -type d -exec chmod 0777 {} +");
                exec ("find /home2/axnegarc/laravel/storage/app/public/photo/{$userId}/gallery -type d -exec chmod 0777 {} +");

                Storage::put('public/photo/' . $galleryPathPhoto, fopen($file, 'r+'));
//local
                $galleryPhoto = public_path('storage/photo/' . $galleryPathPhoto);
         //onlie
//                $galleryPhoto = public_path('storage/public/photo/' . $galleryPathPhoto);
                $img = Images::make($galleryPhoto)->resize(500, 300, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($galleryPhoto);


                //                path of new image
                if (! file_exists(storage_path('app/public/photo/'.$userId.'/changes/'))){
                    mkdir(storage_path('app/public/photo/'.$userId.'/changes'),'0777', true);
                }
                exec ("find /var/www/html/laravel/public/storage/photo/{$userId}/changes -type d -exec chmod 0777 {} +");
                exec ("find /home2/axnegarc/laravel/public/storage/photo/{$userId}/changes -type d -exec chmod 0777 {} +");
                //locale
                $img= public_path('storage/photo/' . $pathImage);
//online
//                $img= public_path('storage/public/photo/' . $pathImage);

//                dd($img);// image src for encryption steganography
                //locale
                $newImg= public_path('storage/photo/' . $newPathImage); // make new image src for encryption steganography
                //online
//                $newImg= public_path('storage/public/photo/' . $newPathImage); // make new image src for encryption steganography


//                    save images in database and get exif photo data
                foreach ($filedata as $key => $section) {
//                    $exif[$key]=$key;
                    foreach ($section as $name => $val) {
                        if ($name == 'UndefinedTag:0x9AAA') {
                            continue;
                        }
                        $exif[$key][$name] = $val;
                    }
                }
//                add some data to exif for example user full name
                $info=['info'=>['firstName'=>$user->name,'lastName'=>$user->f_name]];
                $exif=array_merge($exif,$info);
                $exif=array_reverse($exif);
//insert data
                $image->exif = json_encode($exif);
                $image->sources = $pathImage;
                $image->new_sources = $newPathImage;
                $image->slider_sources = $sliderPathPhoto;
                $image->gallery_sources = $galleryPathPhoto;
                $image->rndkey = $rndKey;

                //                make image with stenography with user name and family name
//                dd($newPathImage);
                $stegano = new SteganoController();
                $stegano->encryptions(json_encode($exif), $rndKey, $img,$newPathImage, $basicDir);
                //extract pic
                //$d = $stegano->decryptions($newImg);
                //dd($d);
                $image->s_hash = hash_file('sha256', $newImg);
//end of process and save photo data in table
                $ok = $image->save();
            }
        }
        if (!isset($filedata['EXIF'])) {
//            alert()->error('عکس تکراری میباشد','error');
            return back()->with('fail', 'عکس معتبر نمیباشد!');
        }
        if (!isset($ok)) {
//            alert()->error('عکس تکراری میباشد','error');
            return back()->with('fail', 'عکس تکراری میباشد');
        }
        if ($ok) {
//            alert()->success('عکس ها با موفقیت آپلود شدند','success');
            return back()->with('success', 'عکس ها با موفقیت آپلود شدند');
        } else {
//            alert()->error('خطا رخ داده است','error');
            return back()->with('fail', 'خطا رخ داده است');
        }

    }



    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
