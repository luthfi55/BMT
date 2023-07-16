<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanBills;
use App\Models\LoanFund;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class LoanFundController extends Controller
{
    public function index(Request $request)
    {
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
            $users = $users->whereRaw('1 = 0'); // No users should be found when no search term is provided
        }
    
        $users = $users->paginate(10);
    
        return view('loan_fund/loanfund-form', ['users' => $users]);
    }

    public function list(Request $request)
    {
        $search = $request->input('search');        

        $loanFunds = LoanFund::latest()            
            ->with('user')
            ->where('status', false) // Filter based on status
            ->where(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nominal', 'LIKE', "%$search%")
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

        $loanFunds->appends(['search' => $search]); // Preserve the search term in pagination links

        return view('loan_fund.list-loanfund', ['loanFunds' => $loanFunds, 'search' => $search]);
    }

    public function listHistory(Request $request)
    {
        $search = $request->input('search');        

        $loanFunds = LoanFund::latest()            
            ->with('user')
            ->where('status', true) // Filter based on status
            ->where(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nominal', 'LIKE', "%$search%")
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

        $loanFunds->appends(['search' => $search]); // Preserve the search term in pagination links

        return view('loan_fund.list-historyloanfund', ['loanFunds' => $loanFunds, 'search' => $search]);
    }

    public function detail($id)
    {
        $loanFunds = LoanFund::find($id);
        if (!$loanFunds) {
            return redirect()->route('admin/list-loanfund')->with('error', 'Loan bill not found.');
        }

        $loanBills = LoanBills::where('loan_fund_id', $loanFunds->id)->get();

        return view('loan_fund.detail-loanfund', ['loanFund' => $loanFunds, 'loanBills' => $loanBills]);
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

        // Generate LoanFund Data
        $loanFund = new LoanFund();
        $loanFund->user_id = $user->id;             
        $loanFund->nominal = $request->input('nominal');
        $loanFund->infaq = $request->input('infaq');
        $loanFund->infaq_type = $request->input('infaq_type');

        if ($loanFund->infaq_type == 'first') {
            $loanFund->infaq_status = true;
        } else {
            $loanFund->infaq_status = false;
        }

        $loanFund->installment = $request->input('installment');
        $loanFund->installment_amount = 0;
        $loanFund->month = 1;
        $loanFund->status = false;
        $loanFund->save();

        if ($loanFund->infaq_type == 'first'){
            $nominalInfaq = 0;     
        } elseif ($loanFund->infaq_type == 'last'){
            $monthlength = $loanFund->installment;
            $currentMonth = Carbon::now()->timezone('Asia/Jakarta');
            for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {
                $currentMonth->addMonth();
            }
            
            $loanBill = new LoanBills();
            $loanBill->loan_fund_id = $loanFund->id;
            $loanBill->month = $loanFund->installment;
            $loanBill->installment = 0;
            $loanBill->installment_amount = $loanFund->nominal * $loanFund->infaq / 100;            
            $loanBill->date = $currentMonth;
            $loanBill->status = false;
            $loanBill->save();       
            $nominalInfaq = 0;     
        } else if ($loanFund->infaq_type == 'installment'){
            $nominalInfaq =  $loanFund->nominal * $loanFund->infaq / 100;
        } 

        //Generate loan bills

        $totalLoanFund = $loanFund->nominal + $nominalInfaq;

        $monthlength = $loanFund->installment;
        $installmentAmount = floor($totalLoanFund / $monthlength);
        $lastInstallmentAmount = $totalLoanFund - ($installmentAmount * ($monthlength - 1));

        $currentMonth = Carbon::now()->timezone('Asia/Jakarta');

        for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {            
            // $currentMonth->addMonth();
            $currentMonth->addMinutes(1);
            $loanBill = new LoanBills();
            $loanBill->loan_fund_id = $loanFund->id;            
            $loanBill->month = $monthnow;
            $loanBill->installment = 1;
            $loanBill->installment_amount = ($monthnow == $monthlength) ? $lastInstallmentAmount : $installmentAmount;
            $loanBill->date = $currentMonth->format('Y-m-d H:i');
            $loanBill->status = false;
            $loanBill->save();
        } 
        
        Session::flash('success');
        return redirect()->route('admin.list-loanfund');
        } catch (ModelNotFoundException $e) {
            Session::flash('failed');
            return redirect()->route('admin.loanfund-form');
        } catch (QueryException $e) {
            return redirect()->route('admin.loanfund-form');
        }
    }    

    public function edit($id)
    {
        $loanFunds = LoanFund::find($id);
        if (!$loanFunds) {
            return redirect()->route('admin.user-form')->with('error', 'User not found.');
        }
        return view('loan_fund.loanfund-edit', ['loanFunds' => $loanFunds]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $loanFund = LoanFund::findOrFail($id);                          
        $loanFund->status =  $request->input('status');
        $loanFund->save();

        Session::flash('updateSuccess');

        return redirect()->route('admin.list-loanfund');
    }

    public function updateStatusHistory(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $loanFund = LoanFund::findOrFail($id);                          
        $loanFund->status =  $request->input('status');
        $loanFund->save();

        Session::flash('updateSuccess');

        return redirect()->route('admin.list-historyloanfund');
    }
    
    public function destroy($id)
    {
        try {
            // Cari data loan_fund berdasarkan ID
            $loanFund = LoanFund::findOrFail($id);

            // Cari data loan_bills yang memiliki loan_fund_id yang sama dengan $id
            $loanBills = LoanBills::where('loan_fund_id', $id)->get();

            // Hapus data loan_bills yang terkait dengan loan_fund_id
            foreach ($loanBills as $loanBill) {
                $loanBill->delete();
            }

            // Hapus data loan_fund
            $loanFund->delete();

            Session::flash('deleteSuccess');

            return redirect()->route('admin.list-loanfund');
        } catch (ModelNotFoundException $e) {
            Session::flash('deleteFailed');

            return redirect()->route('admin.list-loanfund');
        }
    }
    public function destroyHistory($id)
    {
        try {
            // Cari data loan_fund berdasarkan ID
            $loanFund = LoanFund::findOrFail($id);

            // Cari data loan_bills yang memiliki loan_fund_id yang sama dengan $id
            $loanBills = LoanBills::where('loan_fund_id', $id)->get();

            // Hapus data loan_bills yang terkait dengan loan_fund_id
            foreach ($loanBills as $loanBill) {
                $loanBill->delete();
            }

            // Hapus data loan_fund
            $loanFund->delete();

            Session::flash('deleteSuccess');

            return redirect()->route('admin.list-historyloanfund');
        } catch (ModelNotFoundException $e) {
            Session::flash('deleteFailed');

            return redirect()->route('admin.list-historyloanfund');
        }
    }
}
