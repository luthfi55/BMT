<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoodsLoan;
use App\Models\LoanBills;
use App\Models\LoanFund;
use App\Models\Savings;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Snap;

class DataController extends Controller
{
    public function getUserData($userId)
    {
        $loanFundBills = $this->getLoanFundBills($userId);
        $goodsLoanBills = $this->getGoodsLoanBills($userId);
        $savingsBills = $this->getSavingsBills($userId);

        if ($loanFundBills->isEmpty() && $goodsLoanBills->isEmpty() & $savingsBills->isEmpty()) {
            return response()->json([
                'message' => 'Null',
                'Data' => ['Null'],                
            ], 200);
        }

        return response()->json([
            'message' => 'Successfully',
            'Data' => [
                'savings' => $savingsBills,
                'LoanFundsBills' => $loanFundBills,
                'GoodsLoanBills' => $goodsLoanBills,
            ],            
        ], 200);
    }

    private function getLoanFundBills($userId)
    {
        return LoanBills::whereHas('loanFund', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', true)->get();
    }

    private function getGoodsLoanBills($userId)
    {
        return LoanBills::whereHas('goodsLoan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', true)->get();
    }

    private function getSavingsBills($userId)
    {
        return Savings::where('user_id', $userId)->where('status', true)->get();
    }

    public function checkout(Request $request)
    {        
        $request->validate([
            'bill_id' => 'required|integer',
        ]);
        
        $billId = $request->input('bill_id');
        
        return "Selected Bill ID: " . $billId;
    }
}
