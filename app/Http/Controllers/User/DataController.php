<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoodsLoan;
use App\Models\LoanBills;
use App\Models\LoanFund;
use App\Models\User;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $loanFunds = $user->loanFunds;

        return response()->json([
            'message' => 'Loan funds data retrieved successfully',
            'loan_funds' => $loanFunds,
        ]);
    }

    public function getUserData($id)
    {
        $loanFundBills = LoanBills::whereHas('loanFund', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->where('status', true)->get();

        $goodsLoanBills = LoanBills::whereHas('goodsLoan', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->where('status', true)->get();

        if ($loanFundBills->isEmpty() && $goodsLoanBills->isEmpty()) {
            return response()->json([
                'message' => 'Null',
            ], 200);
        } 
        
        return response()->json([
            'message' => 'Succesfully',            
            'LoanFundsBills' => $loanFundBills,            
            'GoodsLoanBills' => $goodsLoanBills,            
        ], 200);
    }
}
