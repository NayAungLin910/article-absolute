<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        $featured_article = Article::where('featured', "true")->with('header')->first();
        if (!$featured_article) {
            $featured_article = "";
        }
        $latest_news = Header::with('article')->latest()->take(3)->get();
        $inter = Category::where('name', 'international')->with('article.header')->first();
        $myan = Category::where('name', 'myanmar')->with('article.header')->first();
        $sports = Category::where('name', 'sports')->with('article.header')->first();
        return view('home', compact('latest_news', 'inter', 'myan', 'sports', 'featured_article'));
    }
    public function viewArticle(Request $request, $slug)
    {
        $article = Article::where("slug", $slug)->with("header", "user", "category")->first();
        $latest_article = Article::latest()->with("header:id,file_path,file")->select('id', 'slug', 'name', 'header_id')->take(5)->get();
        if ($article) {
            Article::where('slug', $slug)
                ->update([
                    "v_count" => DB::raw('v_count + 1'),
                ]);
        }
        if (Auth::check()) {
            $des = true;
            foreach ($article->view as $view) {
                if ($view->pivot->user_id == Auth::user()->id) {
                    $des = false;
                }
            }
            if ($des) {
                $article->view()->attach(Auth::user()->id);
            }
        }
        return view('article-view', compact('article', 'latest_article'));
    }
    public function viewArticleByCategory(Request $request, $slug)
    {
        $category = Category::where("slug", $slug)->with('user')->first();
        if (!$category) {
            return redirect()->back()->with("error", "Category not found!");
        }
        $articles = Article::latest()->whereHas('category', function ($q) use ($category) {
            $q->where('article_category.category_id', $category->id);
        })->with('header')->paginate(9);

        return view('article-view-by-category', compact('category', 'articles'));
    }

    public function terms()
    {
        return view('terms-conditions');
    }
    public function cookiePolicy()
    {
        return view('cookie-policy');
    }
    public function disclaimer()
    {
        return view('disclaimer');
    }
}
