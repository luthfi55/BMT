<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanBills;
use Illuminate\Http\Request;

class LoanBillsController extends Controller
{
    public function create(Request $request)
    {
        $installment = session('installment');
            $installmentAmount = session('installment_amount');

            // $request->validate([
            //     'loan_fund_id' => 'required',
            //     'goods_loan_id' => 'required',
            //     'month' => 'required',
            //     'date' => 'required',
            //     'status' => 'required',
            // ]);

            $loanBill = new LoanBills();
            // $loanBill->loan_fund_id = $request->input('loan_fund_id');
            // $loanBill->goods_loan_id = $request->input('goods_loan_id');
            $loanBill->month = 1;
            $loanBill->installment = $installment;
            $loanBill->installment_amount = $installmentAmount;
            $loanBill->date = now();
            $loanBill->status = false;
            $loanBill->save();

            return redirect()->route('loan_bills.index')->with('success', 'Loan bill created successfully');
    
}

}
