<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function viewCategory()
    {
        $categories = Category::orderBy('name', 'ASC')->with('article.header')->paginate(10);
        return view('category', compact('categories'));
    }
    public function postViewCategory(Request $request)
    {
        $request->validate([
            "search" => "required",
        ]);
        $categories = Category::orderBy('name', 'ASC')->with('article.header')->where("name", "like", "%$request->search%")->paginate(10);
        return view('category', compact('categories'));
    }
}
