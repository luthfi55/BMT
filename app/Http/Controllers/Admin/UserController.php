<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        return view('user/user-form');
    }

    public function list()
    {
        $users = User::all();
        return view('user.list-user', ['users' => $users]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'birth_date' => 'required',
            'phone_number' => 'required',
            'job' => 'required',
            'mandatory_savings' => 'required',
            'pin' => 'required',
        ]);  

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->birth_date = $request->input('birth_date');
        $user->phone_number = $request->input('phone_number');
        $user->job = $request->input('job');
        $user->mandatory_savings = $request->input('mandatory_savings');
        $user->mandatory_savings_status = false;
        $user->voluntary_savings = 0;
        $user->pin = $request->input('pin');        
        $user->save();
        // dd($user);  
        Session::flash('success', 'Successfully created a user account');
        // Tambahkan logika tambahan jika diperlukan            
        return redirect()->route('admin.user-form');

    }
}
