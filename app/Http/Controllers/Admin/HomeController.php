<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // home
    public function show() {
        // dd(auth()->user());
        return view('admin.home');
    }
}
