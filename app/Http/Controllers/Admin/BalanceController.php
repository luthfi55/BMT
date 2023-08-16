<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\User; 
use App\Models\LoanFund; 
use App\Models\GoodsLoan;
use App\Models\Operational;
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
                
        if ($balance) {
            $balance->nominal = $balance->nominal + $balanceHistory->nominal;
            $balance->save();
        }
        Session::flash('success', 'Add balance successfully');
        
        return redirect()->route('admin.balance-form');
    }

    public function subtract(Request $request)
    {      
        $request->validate([
            'nominal' => 'required',
            'description' => 'required',            
        ]);  
        
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');

        $balance = Balance::first();
        $balanceHistory = new BalanceHistory();        
        $balance->nominal = $balance->nominal - $balanceHistory->nominal;
        if ($balance->nominal < 0){
            return false;
        } else {
            $balanceHistory = new BalanceHistory();        
        }
        
        $balanceHistory->nominal = $request->input('nominal');
        $balanceHistory->description = $request->input('description');
        $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');
        $balanceHistory->save();                          

        Session::flash('success', 'Subtract balance successfully');
        
        return redirect()->route('admin.balance-form');
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
                $this->matchPattern($query, $search, 'LF-', 'loan_fund_id');
            })
            ->orWhere(function ($query) use ($search) {
                $this->matchPattern($query, $search, 'GL-', 'goods_loan_id');
            })
            ->orWhere(function ($query) use ($search) {
                $this->matchPattern($query, $search, 'OP-', 'operational_id');
            })
            ->orWhere(function ($query) use ($search) {
                $this->matchPattern($query, $search, 'LB-', 'loan_bills_id');
            })
            ->orWhere(function ($query) use ($search) {
                $this->matchPattern($query, $search, 'SV-', 'savings_id');
            })
            ->latest()
            ->paginate(10);

        return view('balance.list-balancehistory', compact('balance', 'balanceHistories'));
    }

    private function matchPattern($query, $search, $prefix, $column)
    {
        if (preg_match('/^' . $prefix . '(\d+)/', $search, $matches)) {
            $query->where($column, 'LIKE', "%$matches[1]%");
        }
    }


    public function detail($id)
    {
        $balance = Balance::first();
        $balanceHistories = BalanceHistory::find($id);
        if (!$balanceHistories) {
            return redirect()->route('admin.list-balancehistory')->with('error', 'Data not found.');
        }

        return view('balance.detail-balancehistory', ['balanceHistories' => $balanceHistories],compact('balance'));
    }

}