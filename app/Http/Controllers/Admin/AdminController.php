<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\Admin\Hash;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    public function index()
    {
        $balance = Balance::first();
        return view('admin/admin-form', compact('balance'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);  
        
        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->username = $request->input('username');
        $admin->email = $request->input('email');
        $admin->password = \Hash::make($request->input('password'));
        $admin->save();
        
        Session::flash('success', 'Admin created successfully');
        
        return redirect()->route('admin.admin-form');

    }
}
