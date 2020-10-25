<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ExploreController extends Controller
{

    public function index()
    {
        $categories = Category::has('images')->with(['images' => function ($query) {
            $query->whereStatus('1')->orderBy('rate', 'desc')->with(['user','comments'=>function ($q) {
                $q->count();
            }]);
        }])->whereStatus('1')->get();
//dd($categories);
        return view('front.explore.index', compact('categories'));
    }
}
