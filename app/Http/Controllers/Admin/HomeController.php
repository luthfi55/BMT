<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // return redirect('/admin/dashboard');    
        return view('admin/dashboard');
    }
}
