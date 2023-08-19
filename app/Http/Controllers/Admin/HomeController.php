<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\GoodsLoan;
use App\Models\LoanFund;
use App\Models\User;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $balance = Balance::first();
        $userCount = User::count();
        $loanFundCount = LoanFund::where('status', 0)->count();
        $goodsLoanCount = GoodsLoan::where('status', 0)->count();
        $users = User::latest()->paginate(5);   
        $loanFunds = LoanFund::latest()->paginate(5);
        $goodsLoans = GoodsLoan::latest()->paginate(5);
        $balanceHistories = BalanceHistory::latest()->paginate(5);
        // $loanBill = User::latest()->where('name', 'LIKE', "%$search%")
        //         ->orWhere('email', 'LIKE', "%$search%")
        //         ->orWhere('address', 'LIKE', "%$search%")
        //         ->orWhere('birth_date', 'LIKE', "%$search%")
        //         ->orWhere('phone_number', 'LIKE', "%$search%")
        //         ->orWhere('job', 'LIKE', "%$search%")
        //         ->orWhere('mandatory_savings', 'LIKE', "%$search%")
        //         ->orWhere('pin', 'LIKE', "%$search%")
        //         ->paginate(10);             
    
        return view('admin.dashboard', compact('balance', 'userCount', 'loanFundCount', 'goodsLoanCount', 'users', 'loanFunds', 'goodsLoans', 'balanceHistories'));
    }
}
