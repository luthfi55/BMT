<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\LoanFund;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $balance = Balance::first();
        $userCount = User::count();
        $loanFundCount = LoanFund::count();
        // $goodLoanCount = GoodsLoan::count();
    
        return view('admin.dashboard', compact('balance', 'userCount', 'loanFundCount'));
    }
}
