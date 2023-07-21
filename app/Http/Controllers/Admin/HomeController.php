<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\GoodsLoan;
use App\Models\LoanFund;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $balance = Balance::first();
        $userCount = User::count();
        $loanFundCount = LoanFund::where('status', 0)->count();
        $goodsLoanCount = GoodsLoan::where('status', 0)->count();        
    
        return view('admin.dashboard', compact('balance', 'userCount', 'loanFundCount', 'goodsLoanCount'));
    }
}
