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
        $balance = Balance::first();
        return view('balance/balancehistory-form' ,compact('balance'));
    }

    public function create(Request $request)
{      
    $request->validate([
        'nominal' => 'required',
        'description' => 'required',            
    ]);  
    
    $currentTime = Carbon::now()->timezone('Asia/Jakarta');

    $balanceHistory = new BalanceHistory();
    $balance = Balance::first();
    $balanceHistory->nominal = $request->input('nominal');
    $balanceHistory->description = $request->input('description');
    $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');

    $balanceHistory->save();  
    
    // Update the 'Balance' table, assuming you want to add the 'nominal' value to the existing balance.
    // Again, you may need to modify this part based on your application's requirements.
    if ($balance) {
        $balance->nominal = $balance->nominal + $balanceHistory->nominal;
        $balance->save();
    }

    public function listHistory(Request $request)
    {
        $balance = Balance::first();           
        $balanceHistories = BalanceHistory::latest();        
        $search = $request->input('search');
    
        $balanceHistories = BalanceHistory::where(function ($query) use ($search) {
            $query->where('loan_fund_id', 'LIKE', "%$search%")
                ->orWhere('goods_loan_id', 'LIKE', "%$search%")
                ->orWhere('operational_id', 'LIKE', "%$search%")
                ->orWhere('loan_bills_id', 'LIKE', "%$search%")
                ->orWhere('savings_id', 'LIKE', "%$search%");
        })
        ->orWhere('description', 'LIKE', "%$search%")
        ->orWhere('date', 'LIKE', "%$search%")
        ->orWhere(function ($query) use ($search) {            
            if (preg_match('/^LF-(\d+)/', $search, $matches)) {
                $query->where('loan_fund_id', 'LIKE', "%$matches[1]%");
            }
        })
        ->orWhere(function ($query) use ($search) {            
            if (preg_match('/^GL-(\d+)/', $search, $matches)) {
                $query->where('goods_loan_id', 'LIKE', "%$matches[1]%");
            } 
        })
        ->orWhere(function ($query) use ($search) {            
            if (preg_match('/^OP-(\d+)/', $search, $matches)) {
                $query->where('operational_id', 'LIKE', "%$matches[1]%");
            }
        })
        ->orWhere(function ($query) use ($search) {            
            if (preg_match('/^LB-(\d+)/', $search, $matches)) {
                $query->where('loan_bills_id', 'LIKE', "%$matches[1]%");
            }
        })
        ->orWhere(function ($query) use ($search) {            
            if (preg_match('/^SV-(\d+)/', $search, $matches)) {
                $query->where('savings_id', 'LIKE', "%$matches[1]%");
            }
        })
        ->latest()
        ->paginate(10);
        
        return view('balance.list-balancehistory', ['balanceHistories' => $balanceHistories],compact('balance'));        
    }
}