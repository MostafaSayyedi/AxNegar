<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use App\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //    get image sorted by rating for index page
    public function welcome(){
        $images= Image::OrderBy('rate')->whereStatus('1')->get();
//        dd($images);
        return view('welcome', compact('images'));
    }

    //for search iamges
     public function search(Request $request)
    {

        if (count($request->all()) > 0) {
            $search = $request->all();
            $photos = Image::with(['user','comments'=>function($q){
                $q->count();
            }])->search($search);
        }

        return view('search.index', compact('photos'));
    }


    public function account($username)
    {
        if(auth()->check() && auth()->user()->isAdmin()){
            return redirect()->route('home');
        }
        $user= User::where('user_name',$username)->first();
        // dd($user);
        $totalComment = Comment::where('user_id',$user->id)->get()->count();

        if ($user != null){
            $photos= Image::orderBy('id')->where('user_id',$user->id)->with('comments')->get();
//dd($photos);
            return view('user.main.index', compact(['user','photos','totalComment']));
        }
    }

}
