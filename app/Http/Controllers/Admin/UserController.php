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

    public function list(Request $request)
    {
        $users = User::all();
        $users = User::paginate(10);
        $search = $request->input('search');
    
        // Fetch users based on the search query
        $users = User::where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('address', 'LIKE', "%$search%")
                ->orWhere('birth_date', 'LIKE', "%$search%")
                ->orWhere('phone_number', 'LIKE', "%$search%")
                ->orWhere('job', 'LIKE', "%$search%")
                ->orWhere('mandatory_savings', 'LIKE', "%$search%")
                ->orWhere('pin', 'LIKE', "%$search%")
                ->paginate(11);
    
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

    public function edit($id)
    {
        $users = User::find($id);
        if (!$users) {
            return redirect()->route('admin.user-form')->with('error', 'User not found.');
        }
        return view('user.user-edit', ['users' => $users]);
    }

    public function update(Request $request, $id)
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

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->birth_date = $request->input('birth_date');
        $user->phone_number = $request->input('phone_number');
        $user->job = $request->input('job');
        $user->mandatory_savings = $request->input('mandatory_savings');
        $user->pin = $request->input('pin');
        $user->save();

        Session::flash('success', 'Successfully updated the user account');

        return redirect()->route('admin.list-user');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Session::flash('success', 'Successfully deleted the user account');

        return redirect()->route('admin.list-user');
    }

}
