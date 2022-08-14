<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function statistics(Request $request)
    {
        $articles = Article::latest()->select('name', 'id', 'v_count');
        if ($request->year !== "undefined") {
            if ($year = $request->year) {
                $articles->whereYear('created_at', $year);
            }
        } else {
            $year = date('Y');
            $articles->whereYear('created_at', $year);
        }

        // calculate monthly view data
        $data = [];
        $view_counts = [];
        for ($i = 0; $i < 12; $i++) {
            $total_count = 0;

            $article_cal = Article::whereYear('created_at', $year)
                ->whereMonth('created_at', $i + 1)
                ->get();

            if ($article_cal) {
                foreach ($article_cal as $ac) {
                    $total_count = $total_count + $ac->v_count;
                }
            }

            $month = "";
            switch ($i + 1) {
                case 1:
                    $month = "Jan";
                    break;
                case 2:
                    $month = "Feb";
                    break;
                case 3:
                    $month = "Mar";
                    break;
                case 4:
                    $month = "Apr";
                    break;
                case 5:
                    $month = "May";
                    break;
                case 6:
                    $month = "June";
                    break;
                case 7:
                    $month = "July";
                    break;
                case 8:
                    $month = "Aug";
                    break;
                case 9:
                    $month = "Sept";
                    break;
                case 10:
                    $month = "Oct";
                    break;
                case 11:
                    $month = "Nov";
                    break;
                case 12:
                    $month = "Dec";
                    break;
            }

            $data[] = (object) [
                "quarter" => $month,
                "earnings" => $total_count,
            ];
            $view_counts[] = strval($total_count);
        }


        $articles = $articles->get();

        // pie chart data calculation
        $category = Category::all();
        $cat_pie = [];
        $cat_label = [];

        foreach($category as $c) {
            $total_count = 0;
            $cat_article = Article::select('id', 'name', 'v_count')->whereHas('category', function ($query) use ($c) {
                $query->where('article_category.category_id', $c->id);
            })->get();
            foreach($cat_article as $a){
                $total_count = $total_count + $a->v_count;
            }
            $cat_pie[] = (object) [
                "x" => $c->name,
                "y" => $total_count,
            ];
            $cat_label[] = $c->name . ": " . strval($total_count);
        }

       

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $data,
            "year" => $year,
            "view_counts" => $view_counts,
            "cat_pie" => $cat_pie,
            "cat_label" => $cat_label,
        ]);
    }
}
