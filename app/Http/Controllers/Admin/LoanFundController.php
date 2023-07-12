<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanBills;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\LoanFund;
use App\Models\User;

class LoanFundController extends Controller
{

    public function index()
    {
        return view('loan_fund/loanfund-form');
    }
    public function create(Request $request)
    {        
        try {
        // Validasi request
        $request->validate([
            'pin' => 'required',
            'nominal' => 'required',
            'infaq' => 'required',
            'infaq_type' => 'required',            
            'installment' => 'required',
            'installment_amount' => 'required',            
        ]); 

        $pin = $request->input('pin');
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            return response()->json(['message' => 'Failed to create LoanFund. User not found or invalid PIN.'], 422);
        }

        // Buat data LoanFund
        $loanFund = new LoanFund();
        $loanFund->user_id = $user->id;             
        $loanFund->nominal = $request->input('nominal');
        $loanFund->infaq = $request->input('infaq');
        $loanFund->infaq_type = $request->input('infaq_type');

        if ($loanFund->infaq_type == 'awal') {
            $loanFund->infaq_status = true;
        } else {
            $loanFund->infaq_status = false;
        }

        $loanFund->installment = $request->input('installment');
        $loanFund->installment_amount = 0;
        $loanFund->month = 1;
        $loanFund->status = false;
        $loanFund->save();

        //Generate loan bills

        $monthlength = $loanFund->installment;
        for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {            
            $loanBill = new LoanBills();
            $loanBill->loan_fund_id = $loanFund->id;
            // $loanBill->goods_loan_id = $request->input('goods_loan_id');
            $loanBill->month = $monthnow;
            $loanBill->installment = $loanFund->installment;
            $loanBill->installment_amount = '100000';
            $loanBill->date = now();
            $loanBill->status = false;
            $loanBill->save();
        }        

        // Kirim respon berhasil
        return response()->json(['message' => 'LoanFund created successfully', 'data' => $loanFund], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Failed to create LoanFund. User not found.'], 422);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create LoanFund.'], 500);
        }
    }
}
