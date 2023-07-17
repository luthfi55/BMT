<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\GoodsLoan;
use App\Models\LoanBills;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;

class GoodsLoanController extends Controller
{
    public function index(Request $request)
    {
        $balance = Balance::first();
        $search = $request->input('search');
        $users = User::latest();
    
        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%")
                    ->orWhere('birth_date', 'LIKE', "%$search%")
                    ->orWhere('phone_number', 'LIKE', "%$search%")
                    ->orWhere('job', 'LIKE', "%$search%")
                    ->orWhere('mandatory_savings', 'LIKE', "%$search%")
                    ->orWhere('pin', 'LIKE', "%$search%");
            });
        } else {
            $users = $users->whereRaw('1 = 0');
        }
    
        $users = $users->paginate(10);
    
        return view('goods_loan/goodsloan-form', ['users' => $users],compact('balance'));
    }

    public function list(Request $request)
    {
        $balance = Balance::first();
        $search = $request->input('search');        

        $goodsLoans = GoodsLoan::latest()            
            ->with('user')
            ->where('status', false) 
            ->where(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('goods', 'LIKE', "%$search%")
                        ->orwhere('nominal', 'LIKE', "%$search%")
                        ->orWhere('infaq', 'LIKE', "%$search%")
                        ->orWhere('infaq_type', 'LIKE', "%$search%")            
                        ->orWhere('infaq_status', 'LIKE', "%$search%")
                        ->orWhere('installment', 'LIKE', "%$search%")
                        ->orWhere('month', 'LIKE', "%$search%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                });
            })
            ->paginate(10);

        $goodsLoans->appends(['search' => $search]); // Preserve the search term in pagination links

        return view('goods_loan.list-goodsloan', ['goodsLoans' => $goodsLoans, 'search' => $search],compact('balance'));
    }

    public function listHistory(Request $request)
    {
        $balance = Balance::first();
        $search = $request->input('search');        

        $goodsLoans = GoodsLoan::latest()            
            ->with('user')
            ->where('status', true) 
            ->where(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('goods', 'LIKE', "%$search%")
                        ->orwhere('nominal', 'LIKE', "%$search%")
                        ->orWhere('infaq', 'LIKE', "%$search%")
                        ->orWhere('infaq_type', 'LIKE', "%$search%")            
                        ->orWhere('infaq_status', 'LIKE', "%$search%")
                        ->orWhere('installment', 'LIKE', "%$search%")
                        ->orWhere('month', 'LIKE', "%$search%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                });
            })
            ->paginate(10);

        $goodsLoans->appends(['search' => $search]); // Preserve the search term in pagination links

        return view('goods_loan.list-historygoodsloan', ['goodsLoans' => $goodsLoans, 'search' => $search],compact('balance'));
    }
    

    public function detail($id)
    {
        $balance = Balance::first();
        $goodsLoan = GoodsLoan::find($id);
        if (!$goodsLoan) {
            return redirect()->route('admin/list-loanfund')->with('error', 'Loan bill not found.');
        }

        $loanBills = LoanBills::where('goods_loan_id', $goodsLoan->id)->get();

        return view('goods_loan.detail-goodsloan', ['goodsLoan' => $goodsLoan, 'loanBills' => $loanBills],compact('balance'));
    }

    public function create(Request $request)
    {        
        try {
        // Validasi request
        $request->validate([
            'pin' => 'required',
            'goods' => 'required',
            'nominal' => 'required',
            'infaq' => 'required',
            'infaq_type' => 'required',            
            'installment' => 'required',                    
        ]); 
        if (!$request->has('infaq_type')) {
            return redirect()->route('admin.loanfund-form')->withErrors(['infaq_type' => 'Infaq Type harus dipilih.'])->withInput();
        }     
        $pin = $request->input('pin');
        $user = User::where('pin', $pin)->first();

        if (!$user) {
            Session::flash('userNotFound', 'Successfully created a user account');
            return redirect()->route('admin.loanfund-form');
        }

        // Generate GoodsLoan Data
        $goodsLoan = new GoodsLoan();
        $goodsLoan->user_id = $user->id;     
        $goodsLoan->goods = $request->input('goods');        
        $goodsLoan->nominal = $request->input('nominal');
        $goodsLoan->infaq = $request->input('infaq');
        $goodsLoan->infaq_type = $request->input('infaq_type');

        if ($goodsLoan->infaq_type == 'first') {
            $goodsLoan->infaq_status = true;
        } else {
            $goodsLoan->infaq_status = false;
        }

        $goodsLoan->installment = $request->input('installment');
        $goodsLoan->installment_amount = 0;
        $goodsLoan->month = 1;
        $goodsLoan->status = false;
        $goodsLoan->save();

        if ($goodsLoan->infaq_type == 'first'){
            $nominalInfaq = 0;     
        } elseif ($goodsLoan->infaq_type == 'last'){
            $monthlength = $goodsLoan->installment;
            $currentMonth = Carbon::now()->timezone('Asia/Jakarta');
            for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {
                $currentMonth->addMonth();
            }
            
            $loanBill = new LoanBills();
            $loanBill->goods_loan_id = $goodsLoan->id;
            $loanBill->month = $goodsLoan->installment;
            $loanBill->installment = 0;
            $loanBill->installment_amount = $goodsLoan->nominal * $goodsLoan->infaq / 100;            
            $loanBill->date = $currentMonth;
            $loanBill->status = false;
            $loanBill->save();       
            $nominalInfaq = 0;     
        } else if ($goodsLoan->infaq_type == 'installment'){
            $nominalInfaq =  $goodsLoan->nominal * $goodsLoan->infaq / 100;
        } 

        //Generate loan bills

        $totalgoodsLoan = $goodsLoan->nominal + $nominalInfaq;

        $monthlength = $goodsLoan->installment;
        $installmentAmount = floor($totalgoodsLoan / $monthlength);
        $lastInstallmentAmount = $totalgoodsLoan - ($installmentAmount * ($monthlength - 1));

        $currentMonth = Carbon::now()->timezone('Asia/Jakarta');

        for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {            
            // $currentMonth->addMonth();
            $currentMonth->addMinutes(1);
            $loanBill = new LoanBills();
            $loanBill->goods_loan_id = $goodsLoan->id;            
            $loanBill->month = $monthnow;
            $loanBill->installment = 1;
            $loanBill->installment_amount = ($monthnow == $monthlength) ? $lastInstallmentAmount : $installmentAmount;
            $loanBill->date = $currentMonth->format('Y-m-d H:i');
            $loanBill->status = false;
            $loanBill->save();
        } 
        
        Session::flash('success');
        return redirect()->route('admin.list-goodsloan');
        } catch (ModelNotFoundException $e) {
            Session::flash('failed');
            return redirect()->route('admin.goodsloan-form');
        } catch (QueryException $e) {
            return redirect()->route('admin.goodsloan-form');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $goodsLoan = GoodsLoan::findOrFail($id);                          
        $goodsLoan->status =  $request->input('status');
        $goodsLoan->save();

        Session::flash('updateSuccess');

        return redirect()->route('admin.list-goodsloan');
    }

    public function updateStatusHistory(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $goodsLoan = GoodsLoan::findOrFail($id);                          
        $goodsLoan->status =  $request->input('status');
        $goodsLoan->save();

        Session::flash('updateSuccess');

        return redirect()->route('admin.list-historygoodsloan');
    }

    public function destroy($id)
    {
        try {            
            $goodsLoan = GoodsLoan::findOrFail($id);
            
            $loanBills = LoanBills::where('goods_loan_id', $id)->get();
        
            foreach ($loanBills as $loanBill) {
                $loanBill->delete();
            }
            
            $goodsLoan->delete();

            Session::flash('deleteSuccess');

            return redirect()->route('admin.list-goodsloan');
        } catch (ModelNotFoundException $e) {
            Session::flash('deleteFailed');

            return redirect()->route('admin.list-goodsloan');
        }
    }

    public function destroyHistory($id)
    {
        try {            
            $goodsLoan = GoodsLoan::findOrFail($id);
            
            $loanBills = LoanBills::where('goods_loan_id', $id)->get();
        
            foreach ($loanBills as $loanBill) {
                $loanBill->delete();
            }
            
            $goodsLoan->delete();

            Session::flash('deleteSuccess');

            return redirect()->route('admin.list-historygoodsloan');
        } catch (ModelNotFoundException $e) {
            Session::flash('deleteFailed');

            return redirect()->route('admin.list-historygoodsloan');
        }
    }
    
}
