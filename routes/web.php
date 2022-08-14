<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// login routes
Route::get('/login/google', [\App\Http\Controllers\AuthController::class, "redirect"])->name('login.google-redirect');
Route::get('/login/google/callback', [\App\Http\Controllers\AuthController::class, "callback"])->name('login.google-callback');

// for everyone
Route::get('/', [\App\Http\Controllers\PageController::class, "home"]);
Route::get('/article-view/{slug}', [\App\Http\Controllers\PageController::class, "viewArticle"]);
Route::get('/article-view-by-category/{slug}', [\App\Http\Controllers\PageController::class, "viewArticleByCategory"]);
Route::get('/category', [\App\Http\Controllers\CategoryController::class, "viewCategory"]);
Route::post('/category', [\App\Http\Controllers\CategoryController::class, "postViewCategory"]);
// footer 
Route::get('/terms-and-conditions', [\App\Http\Controllers\PageController::class, "terms"]);
Route::get('/cookie-policy', [\App\Http\Controllers\PageController::class, "cookiePolicy"]);
Route::get('/disclaimer', [\App\Http\Controllers\PageController::class, "disclaimer"]);

// logined
Route::middleware(['Auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\AuthController::class, "profile"]);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, "logout"]);
});

// admin or mod routes
Route::prefix('mod-admin')->middleware(['ModAdmin'])->group(function () {
    // statistics
    Route::get('/statistics', [\App\Http\Controllers\ModAdmin\PageController::class, "statistics"]);
    // category
    Route::resource('category', '\App\Http\Controllers\ModAdmin\CategoryController');
    Route::post('/category/search', [\App\Http\Controllers\ModAdmin\CategoryController::class, "search"]);
    // article
    Route::resource('article', '\App\Http\Controllers\ModAdmin\ArticleController');
});

// only for admin
Route::prefix('admin')->middleware(['AdminRoute'])->group(function () {
    // role management
    Route::get('/role-manage', [\App\Http\Controllers\Admin\RoleChageController::class, "roleManage"]);
    Route::post('/role-manage', [\App\Http\Controllers\Admin\RoleChageController::class, "postRoleManage"]);
    Route::get("/change-role/{id}", [\App\Http\Controllers\Admin\RoleChageController::class, "chageRole"]);
});

