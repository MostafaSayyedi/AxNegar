<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->type == 1) { // user or customer
            return redirect('/account/');
        } elseif (auth()->user()->type == 2) { // main admin
            return redirect('/administrator/');
        }
        return redirect('/');
    }

    public function username()
    {
//        dd(Auth::user()->user_name);
        return redirect('/'.Auth::user()->user_name);
    }

}
