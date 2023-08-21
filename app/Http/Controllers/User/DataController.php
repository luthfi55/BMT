<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoodsLoan;
use App\Models\LoanBills;
use App\Models\LoanFund;
use App\Models\Savings;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Snap;


class DataController extends Controller
{

    public function getProfileData(Request $request){
        if ($request == null){
            return response()->json([
                'message' => 'Failed',
                  
            ], 400);
        } else {
            $data = $request->user();
            $userId = $data->id; 
            $user = User::where('id', $userId)->first();

            return response()->json([
                'message' => 'Successfully',
                'Data' => [
                    'User' => $user,                    
                ],            
            ], 200);
        }
    }

    //testing payment
    // public function getUserData($userId)
    // {
    //     $loanFundBills = $this->getLoanFundBills($userId);
    //     $goodsLoanBills = $this->getGoodsLoanBills($userId);
    //     $savingsBills = $this->getSavingsBills($userId);
    
    //         $loanFundBills = $this->getLoanFundBills($userId);
    //         $goodsLoanBills = $this->getGoodsLoanBills($userId);
    //         $savingsBills = $this->getSavingsBills($userId);
    
    //         if ($loanFundBills->isEmpty() && $goodsLoanBills->isEmpty() && $savingsBills->isEmpty()) {
    //             return response()->json([
    //                 'message' => Null,
    //                 'Data' => [Null],                
    //             ], 200);
    //         }
    
    //         return response()->json([
    //             'message' => 'Successfully',
    //             'Data' => [
    //                 'savings' => $savingsBills,
    //                 'LoanFundsBills' => $loanFundBills,
    //                 'GoodsLoanBills' => $goodsLoanBills,
    //             ],            
    //         ], 200);
    //     }

    public function getUserData(Request $request)
    
    {
        if ($request == null){
            return response()->json([
                'message' => 'Failed',
                  
            ], 400);
        } else {
            $user = $request->user(); 
            $userId = $user->id; 
    
            $loanFundBills = $this->getLoanFundBills($userId);
            $goodsLoanBills = $this->getGoodsLoanBills($userId);
            $savingsBills = $this->getSavingsBills($userId);
    
            if ($loanFundBills->isEmpty() && $goodsLoanBills->isEmpty() && $savingsBills->isEmpty()) {
                return response()->json([
                    'message' => Null,
                    'Data' => [Null],                
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
    }    

    private function getLoanFundBills($userId)
    {
        return LoanBills::whereHas('loanFund', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'Active')->get();
    }

    private function getGoodsLoanBills($userId)
    {
        return LoanBills::whereHas('goodsLoan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'Active')->get();
    }

    private function getSavingsBills($userId)
    {
        return Savings::where('user_id', $userId)->where('status', 'Active')->get();
    }

    public function checkout(Request $request)
    {        
        $request->validate([
            'bill_id' => 'required|integer',
        ]);
        
        $billId = $request->input('bill_id');
        
        return "Selected Bill ID: " . $billId;
    }

    public function checkoutData(Request $request)
    {        
        if ($request == null){
            return response()->json([
                'message' => 'Failed',
                  
            ], 400);
        } else {
            $data = $request->user();
            $userId = $data->id; 
            $checkoutData = Payment::where('user_id', $userId)
            ->latest('created_at')
            ->first();

            if ($checkoutData->created_at != $checkoutData->updated_at){
                return response()->json([
                    'message' => 'Failed',
                      
                ], 400);
            } else {
                return response()->json([
                    'message' => 'Successfully',
                    'Data' => [
                        'Data' => $checkoutData,                    
                    ],            
                ], 200);
            }
        }
    }
}

