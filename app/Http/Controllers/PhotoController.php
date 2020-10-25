<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
//    view images by categories

       public function view($username, $catId, $p_hash)
    {
        $user = Auth::user();

        $photoss = Image::where('category_id', $catId)->with('user')->whereStatus('1')->orderBy('p_hash')->get();

        $photo = Image::where('p_hash', $p_hash)->first();
        $comments = Comment::where('image_id', $photo->id)->where('parent_id', '0')->with(['childrens', 'image', 'user'])->orderBy('created_at', 'desc')->get();
        $countComments = Comment::where('image_id', $photo->id)->get()->count();
        $diff = $photo->created_at->diffForHumans(null, true, true, 2);

        $userUpload = User::where('id', $photo->user_id)->first();
        $category = Category::where('id', $catId)->first();
        $exif = json_decode($photo->exif);
//        dd($exif);

        return view('front.photo.view2', compact(['user', 'diff', 'countComments', 'comments', 'photoss', 'photo', 'userUpload', 'exif', 'category']));
    }

//    view single image
    public function preview($username, $p_hash)
    {
        $user = Auth::user();
        //deactivate picture
        if (\auth()->check()){
//            check if user is owner
            $photo = Image::where('p_hash', $p_hash)->with('user', 'category')->first();
        }else{
//             show image for somebody else
            $photo = Image::whereStatus('1')->where('p_hash', $p_hash)->with('user', 'category')->first();
        }
// return false if photo not exist
        if (! $photo){
            return redirect('/');
        }
        $comments= Comment::where('image_id', $photo->id)->where('parent_id', '0')->with(['childrens','image','user'])->orderBy('created_at', 'desc')->get();
        $countComments=Comment::where('image_id', $photo->id)->get()->count();
//                dd($countComments);

        $diff = $photo->created_at->diffForHumans(null, true, true, 2);
        $userUpload = User::where('id', $photo->user_id)->first();
        $exif = json_decode($photo->exif);
//dd($exif);
        return view('front.photo.single', compact(['user', 'diff','photo', 'userUpload', 'exif','comments','countComments']));
    }

//    for rating photo
    public function rate(Request $request)
    {
        if(!Auth::check()){
//           return ['success'=>false, 'message'=>'شما باید لاگین کنید'];
           return 'شما باید لاگین کنید';
        }
        $image = Image::findOrFail($request->id);
        if ($request->val == 0) {
            $image->rate = $image->rate - 1;
        } else {
            $image->rate = $image->rate + 1;
        }
        if ($image->update()) {
            return $image->rate;
        }
        return false;
    }

//    for comment photo
    public function comment(Request $request)
    {
//        return $request->all();
        $image = Image::findOrFail($request->image_id);
        if (!$image) {
            return false;
        }

        $comment= new Comment();
        $comment->image_id=$request->image_id;
        $comment->user_id=Auth::id();
        $comment->parent_id=$request->parent_id;
        $comment->description=$request->comment;

        if ($comment->save()) {
            return $comment;
        }
        return false;
    }
    //safhe copyright
    
  public function copyRightIndex()
    {
        return view('front.copyright.index');
    }
     public function copyRightSearch(Request $request)
    {
        $exifs = Image::where('f_hash', $request->hash)->select(['exif','sources'])->first();
        if (!$exifs)
            return redirect()->route('user.copyright.index')->with('fail', 'اطاعات عکس یافت نشد');

//        dd($exifs);
        $pic = $exifs->sources;
        $exifs = json_decode($exifs->exif);
        return view('front.copyright.index', compact(['exifs','pic']));
    }



////
    public function get(Request $request)
    {
        $user = Auth::user();
        $image = Image::findOrFail($request->id)->with(['user', 'comments', 'category'])->first();
        $comments = Comment::where('image_id', $request->id)->where('parent_id', '0')->with(['childrens', 'image', 'user'])->orderBy('created_at', 'desc')->get();
//        return $comments;
        $diff = $image->created_at->diffForHumans(null, true, true, 2);
        $userUpload = User::where('id', $image->user_id)->first();
        $category = Category::where('id', $image)->first();
        $exif = json_decode($image->exif);


        $countComments = Comment::where('image_id', $request->id)->get()->count();
        $image->count_comment= $countComments;
        $image->user= $user;
        $image->comments= $comments;
        $image->diff= $diff;
        $image->userUpload= $userUpload;
        $image->category= $category;
        $image->exif= $exif;
        return $image->toJson();
    }


}
