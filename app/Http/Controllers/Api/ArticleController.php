<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Models\Article;
use App\Models\Category;
use App\Models\Header;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use DateTime;

class ArticleController extends Controller
{
    public function getArticle(Request $request)
    {
        $articles = Article::with('header', 'category', 'user');

        if ($search = $request->search) {
            $articles->where("name", "like", "%$search%");
        }

        if ($category_id = $request->category) {
            $findCategory = Category::where('id', $category_id)->first();
            if ($findCategory) {
                $articles->whereHas('category', function ($q) use ($findCategory) {
                    $q->where('article_category.category_id', $findCategory->id);
                });
            }
        }

        if ($date = $request->date) {
            if ($date !== "undefined" && $date !== "") {
                $articles->whereDate('created_at', '=', $date);
            }
        }

        if ($authorOption = $request->authorOption) {
            if ($authorOption == "me") {
                $articles->where("user_id", $request->user_id);
            }
            if ($authorOption == "others") {
                $articles->where("user_id", "!=", $request->user_id);
            }
        }

        if ($sort_view = $request->sort_view) {
            if ($sort_view == "true") {
                $articles->orderBy('v_count', 'desc');
            }else{
                $articles->latest();
            }
        }

        $articles = $articles->paginate(8);


        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $articles,
            "timestamp" => $date,
        ]);
    }

    public function createArticle(Request $request)
    {
        $v = Validator::make($request->all(), [
            "name" => "required",
            "file" => "required|mimes:mp4,ogx,oga,ogv,ogg,webm,jpg,png,jpeg,gif,svg",
            "category" => "required",
            "description" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        if ($request->category == "[]") {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => (object)[
                    'category' => ["Category field is required!"],
                ],
            ]);
        }


        $user = User::where('id', $request->user_id)->first();

        $category = json_decode($request->category);

        $cat_array = [];
        foreach ($category as $cat) {
            $cat_array[] = $cat->value;
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'image/svg'];
        $fileType = $request->file("file")->getClientMimeType();
        // $image = false;

        if (in_array($fileType, $allowed_types)) {
            $image = $request->file("file");
            $image_name = uniqid() . $image->getClientOriginalName();
            $image_path = "/images/" . $image_name;
            $type = 'image';
            $image->move(public_path('/images'), $image_name);
        } else {
            $video = $request->file("file");
            $video_name = uniqid() . $video->getClientOriginalName();
            $image_path = "/videos/" . $video_name;
            $type = 'video';
            $video->move(public_path('/videos'), $video_name);
        }

        $header = Header::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "user_id" => $request->user_id,
            "file_path" => $image_path,
            "file" => $type,
        ]);

        // add style in article description
        // $des = $request->description;
        // $pattern = "/<img/";
        // $newdes = preg_replace($pattern, '<img style="width:500px;height:250px"', $des);

        $article = Article::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "user_id" => $request->user_id,
            "header_id" => $header->id,
            "description" => $request->description,
        ]);

        $article->category()->sync($cat_array);

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => null,
        ]);
    }

    public function deleteArticle(Request $request)
    {

        $article = Article::where('slug', $request->slug)->first();
        $article_name = $article->name;
        $header = Header::where('id', $article->header_id)->first();

        // delete the files
        if (File::exists(public_path($header->file_path))) {
            File::delete(public_path($header->file_path));
        }

        // delete header
        $header->delete();

        // delete the multiple rs records of article
        $article->category()->detach();

        // delete the multiple rs records of view
        $article->view()->detach();

        // delete the multiple rs reacords of fav
        $article->fav()->detach();

        // delete article
        $article->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $article_name . " has been deleted!",
        ]);
    }

    public function getUpdateArticle(Request $request)
    {
        $article = Article::where('slug', $request->slug)->with('user', 'category')->first();
        $a_category = $article->category;
        $category = [];
        foreach ($a_category as $c) {
            $category[] = (object)[
                'value' => $c->id,
                'label' => $c->name
            ];
        }
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "category" => $category,
                "article" => $article,
            ],
        ]);
    }

    public function postUpdateArticle(Request $request)
    {
        $v = Validator::make($request->all(), [
            "name" => "required",
            "category" => "required",
            "description" => "required",
            "slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        // check if category is empty
        if ($request->category == "[]") {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => (object)[
                    'category' => ["Category field is required!"],
                ],
            ]);
        }

        $article = Article::where('slug', $request->slug)->first();
        $header = Header::where('id', $article->header_id)->first();

        // validate file extension if the file is in request
        if ($request->file("file")) {
            $v = Validator::make($request->all(), [
                "file" => "mimes:mp4,ogx,oga,ogv,ogg,webm,jpg,png,jpeg,gif,svg",
            ]);
            if ($v->fails()) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => $v->errors(),
                ]);
            }

            // delete the previous file
            if (File::exists(public_path($header->file_path))) {
                File::delete(public_path($header->file_path));
            }

            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'image/svg'];
            $fileType = $request->file("file")->getClientMimeType();

            if (in_array($fileType, $allowed_types)) {
                $image = $request->file("file");
                $image_name = uniqid() . $image->getClientOriginalName();
                $image_path = "/images/" . $image_name;
                $type = 'image';
                $image->move(public_path('/images'), $image_name);
            } else {
                $video = $request->file("file");
                $video_name = uniqid() . $video->getClientOriginalName();
                $image_path = "/videos/" . $video_name;
                $type = 'video';
                $video->move(public_path('/videos'), $video_name);
            }
        } else {
            $image_path = $header->file_path;
            $type = $header->file;
        }

        // getting categories
        $category = json_decode($request->category);

        $cat_array = [];
        foreach ($category as $cat) {
            $cat_array[] = $cat->value;
        }

        // update header
        Header::where('id', $header->id)->update([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "user_id" => $request->user_id,
            "file_path" => $image_path,
            "file" => $type,
        ]);

        // // add style in article description
        // $des = $request->description;
        // $pattern = "/<img/";
        // $newdes = preg_replace($pattern, '<img style="width:500px;height:250px"', $des);

        // update article
        Article::where('id', $article->id)->update([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "user_id" => $request->user_id,
            "header_id" => $header->id,
            "description" => $request->description,
        ]);

        // update many to many rs with category
        $article->category()->sync($cat_array);

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => null,
        ]);
    }

    public function featured(Request $request)
    {
        $request->validate([
            "slug" => "required",
        ]);
        $searchFeaturedArticle = Article::where('featured', 'true')->first();
        if ($searchFeaturedArticle) {
            Article::where('id', $searchFeaturedArticle->id)->update([
                "featured" => "false"
            ]);
        }
        $article = Article::where('slug', $request->slug)->first();
        if ($article) {
            Article::where('id', $article->id)->update([
                "featured" => "true",
            ]);

            return response()->json([
                "success" => true,
                "status" => 200,
                "data" => null,
            ]);
        }
    }

    public function like(Request $request)
    {
        $request->validate([
            "article_slug" => "required",
            "user_id" => "required",
        ]);

        $article = Article::where("slug", $request->article_slug)->first();
        $user_id = $request->user_id;

        // check if user already liked the article
        $des = false;
        foreach ($article->fav as $f) {
            if ($f->pivot->user_id == $user_id) {
                $des = true;
            }
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $des,
        ]);
    }

    public function clickLike(Request $request)
    {
        $request->validate([
            "article_slug" => "required",
            "user_id" => "required",
        ]);

        $article = Article::where("slug", $request->article_slug)->first();
        $user_id = $request->user_id;

        $des = false;
        foreach ($article->fav as $f) {
            if ($f->pivot->user_id == $user_id) {
                $des = true;
            }
        }

        if (!$des) {
            $article->fav()->attach($user_id);
            return response()->json([
                "success" => true,
                "status" => 200,
                "data" => true,
            ]);
        } else {
            $article->fav()->detach($user_id);
            return response()->json([
                "success" => true,
                "status" => 200,
                "data" => false,
            ]);
        }
    }
}
