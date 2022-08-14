<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Article
Route::post('/article-create', [\App\Http\Controllers\Api\ArticleController::class, "createArticle"]);
Route::get('/article-get', [\App\Http\Controllers\Api\ArticleController::class, "getArticle"]);
Route::post('/article-delete', [\App\Http\Controllers\Api\ArticleController::class, "deleteArticle"]);
Route::get('/article-update-get', [\App\Http\Controllers\Api\ArticleController::class, "getUpdateArticle"]);
Route::post('/article-update-post', [\App\Http\Controllers\Api\ArticleController::class, "postUpdateArticle"]);
Route::post('/article-featured', [\App\Http\Controllers\Api\ArticleController::class, "featured"]);
Route::post('/article-like', [\App\Http\Controllers\Api\ArticleController::class, "like"]);
Route::post('/article-like-click', [\App\Http\Controllers\Api\ArticleController::class, "clickLike"]);
// Category
Route::get('/category-get', [\App\Http\Controllers\Api\CategoryController::class, "category"]);
// Statistics
Route::get('/get-statistics', [\App\Http\Controllers\Api\StatisticsController::class, "statistics"]);
