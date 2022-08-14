<?php

namespace App\Http\Controllers\ModAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function statistics(){
        return view('admin.statistics');
    }
}
