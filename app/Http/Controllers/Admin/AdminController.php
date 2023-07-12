<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\Admin\Hash;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin/admin-form');
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
        // dd($admin);  
        Session::flash('success', 'Admin created successfully');
        // Tambahkan logika tambahan jika diperlukan            
        return redirect()->route('admin.admin-form');

    }
}
