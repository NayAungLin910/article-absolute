<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $category = Category::all();
        $options = [];
        foreach($category as $c){
            $options[] = (object)[
                'value' => $c->id,
                'label' => $c->name
            ];
        }
        if ($category) {
            return response()->json([
                "success" => true,
                "data" => [
                    "category" => $category,
                    "options" => $options,
                ],
                "status" => 200,
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => "No categories",
            "status" => 500,
        ]);
    }
}
