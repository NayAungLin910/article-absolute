<?php

namespace App\Http\Controllers\ModAdmin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Str as Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $categories =  Category::latest()->withCount('article')->paginate('5');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
        ]);

        Category::create([
            "name" => $request->name,
            "user_id" => FacadesAuth::user()->id,
            "slug" =>  Str::slug(uniqid() . $request->name),
        ]);

        return redirect()->back()->with("success", $request->name . " category is created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            "name" => "required",
        ]);

        Category::where('slug', $slug)->update([
            "name" => $request->name,
            "user_id" => FacadesAuth::user()->id,
            "slug" =>  Str::slug(uniqid() . $request->name),
        ]);

        return redirect(route('category.index'))->with("success", $request->name . " category is edited!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $name = $category->name;
        if ($category) {
            $category->delete();
            return redirect(route('category.index'))->with("info", $name . " category deleted!");
        } else {
            return redirect(route('category.index'))->with("error", "Unable to delete!");
        }
    }

    public function search(Request $request){
        $request->validate([
            "search" => "required",
        ]);

        $categories =  Category::where('name', 'like', "%$request->search%")->paginate('5');
        return view('admin.category.index', compact('categories'));
    }
}
