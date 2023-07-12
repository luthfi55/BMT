<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\LoanFund;

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
            'user_id' => 'required',
            'nominal' => 'required',
            'infaq' => 'required',
            'infaq_type' => 'required',            
            'installment' => 'required',
            'installment_amount' => 'required',            
        ]); 

        // Buat data LoanFund
        $loanFund = new LoanFund();
        $loanFund->user_id = $request->input('user_id');                
        $loanFund->nominal = $request->input('nominal');
        $loanFund->infaq = $request->input('infaq');
        $loanFund->infaq_type = $request->input('infaq_type');

        if ($loanFund->infaq_type == 'awal') {
            $loanFund->infaq_status = true;
        } else {
            $loanFund->infaq_status = false;
        }

        $loanFund->installment = $request->input('installment');
        $loanFund->installment_amount = $request->input('installment_amount');
        $loanFund->month = 1;
        $loanFund->status = false;
        $loanFund->save();

        // Kirim respon berhasil
        return response()->json(['message' => 'LoanFund created successfully', 'data' => $loanFund], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Failed to create LoanFund. User not found.'], 422);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create LoanFund.'], 500);
        }
    }
}
