<?php

namespace App\Http\Controllers\Backend\Admin;

use App\AboutUs;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'message' => 'nullable|max:255',
            'status' => 'nullable',
        ]);

        $category= new Category();
        $category->title=$request->title;
        $category->description= $request->message;
        $category->status = $request->status;

        if($category->save()) {
            return back()->with('success', 'دسته بندی مورد نظر اضافه شد');
        }
        return back()->with('error', 'مشکلی بوجود آمده است !مجددا تلاش کنید');
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
        $category= Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable|max:255',
            'status' => 'nullable',
        ]);

        $category= Category::findOrFail($id);
        $category->title=$request->title;
        $category->description= $request->description;
        $category->status = $request->status;

        if($category->update()) {
            return back()->with('success', 'دسته بندی مورد نظر بروز شد');
        }
        return back()->with('error', 'مشکلی بوجود آمده است !مجددا تلاش کنید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->delete())
            return back()->with('success', 'دسته بندی مورد نظر حذف شد');

        return back()->with('error', 'مشکلی رخ داده است !لطفا مجددا تلاش کنید');
    }
}
