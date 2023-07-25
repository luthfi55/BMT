<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\BalanceHistory;
use App\Models\Savings;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $balance = Balance::first(); 
        return view('user/user-form',compact('balance'));
    }

    public function list(Request $request)
    {        
        $balance = Balance::first();        
        $users = User::latest();        
        $search = $request->input('search');
    
        $users = User::latest()->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('address', 'LIKE', "%$search%")
                ->orWhere('birth_date', 'LIKE', "%$search%")
                ->orWhere('phone_number', 'LIKE', "%$search%")
                ->orWhere('job', 'LIKE', "%$search%")
                ->orWhere('mandatory_savings', 'LIKE', "%$search%")
                ->orWhere('pin', 'LIKE', "%$search%")
                ->paginate(10);
    
        return view('user.list-user', ['users' => $users],compact('balance'));        
    }

    public function detail($id)
    {
        $balance = Balance::first();   
        $users = User::find($id);
        if (!$users) {
            return redirect()->route('admin.list-user')->with('error', 'User not found.');
        }

        $savings = Savings::where('user_id', $users->id)->get();

        return view('user.detail-user', ['users' => $users, 'savings' => $savings],compact('balance'));
    }

    public function detailSavings($id)
    {
        $balance = Balance::first();
    
        $saving = Savings::find($id);
        if (!$saving) {
            return redirect()->route('admin.detail-user')->with('error', 'Savings not found.');
        }
    
        return view('user.detail-savings', compact('saving', 'balance'));
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
        
        // Generate unique 4-digit pin
        $uniquePin = false;
        while (!$uniquePin) {
            $pin = mt_rand(1000, 9999);
            $existingUser = User::where('pin', $pin)->first();
            if (!$existingUser) {
                $uniquePin = true;
            }
        }
        
        $user->pin = $pin;
        $user->save(); 

        //Create savings data

        $startDate = Carbon::now()->timezone('Asia/Jakarta');
        $endtDate = Carbon::now()->timezone('Asia/Jakarta')->addMinutes(1);
        // ->addMonth()
        $saving = new Savings();
        $saving->user_id = $user->id;
        $saving->type = 'Mandatory';
        $saving->nominal = $user->mandatory_savings;
        $saving->start_date = $startDate;        
        $saving->end_date = $endtDate;
        $saving->status = false;
        $saving->payment_status = false; 
        $saving->payment_type = 'Cash'; 
        $saving->payment_date = $startDate; 
        $saving->save();

        //Create History Balance
        $balanceHistory = new BalanceHistory();
        $balanceHistory->savings_id = $saving->id;
        $balanceHistory->nominal = $saving->nominal;
        $balanceHistory->description = 'Mandatory Savings';
        $balanceHistory->date = $saving->payment_date;
        $balanceHistory->save(); 

        //balance count
        $balance = Balance::first();
        $balance->nominal = $balance->nominal + $balanceHistory->nominal;
        $balance->save();
        
        Session::flash('success', 'Successfully created a user account');
          
        return redirect()->route('admin.list-user');

    }

    public function edit($id)
    {
        $balance = Balance::first();        
        $users = User::find($id);
        if (!$users) {
            return redirect()->route('admin.user-form')->with('error', 'User not found.');
        }        
        return view('user.user-edit', ['users' => $users],compact('balance'));
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

        Session::flash('updateSuccess');

        return redirect()->route('admin.list-user');
    }

    public function updateSavings(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',
            'payment_type' => 'required'
        ]);
    
        $saving = Savings::findOrFail($id);
        if (!$saving) {
            return redirect()->route('admin.detail-user', ['id' => $id])->with('error', 'Savings not found.');
        }
    
        $saving->status =  $request->input('status');
        $saving->payment_status = $request->input('payment_status');
        $saving->payment_type = $request->input('payment_type');
        $saving->save();
    
        Session::flash('updateSuccess');
    
        return redirect()->route('admin.detail-user', ['id' => $saving->user_id]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Session::flash('deleteSuccess');

        return redirect()->route('admin.list-user');
    }

}
