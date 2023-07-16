<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Models\BalanceHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class BalanceController extends Controller
{
    public function index()
    {
        return view('balance/balancehistory-form');
    }

    public function create(Request $request)
    {      
        $request->validate([
            'nominal' => 'required',
            'description' => 'required',            
        ]);  
        
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');

        $balanceHistory = new BalanceHistory();
        $balanceHistory->nominal = $request->input('nominal');
        $balanceHistory->description = $request->input('description');
        $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');
        $balanceHistory->save();        
        
        $balance = Balance::first();
        $balance->nominal = $balance->nominal + $balanceHistory->nominal;
        $balance->save();

        Session::flash('success', 'Admin created successfully');
        
        return redirect()->route('admin.balance-form');
    }

    public function listHistory()
    {
        $balanceHistories = BalanceHistory::all();
        return view('balance.list-balancehistory', compact('balanceHistories'));
    }
}