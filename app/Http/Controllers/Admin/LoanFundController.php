<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\BalanceHistory;
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
            $users = $users->whereRaw('1 = 0'); // No users should be found when no search term is provided
        }
    
        $users = $users->paginate(10);
    
        return view('loan_fund/loanfund-form', ['users' => $users],compact('balance'));
    }

    public function list(Request $request)
    {
        $balance = Balance::first();
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

        return view('loan_fund.list-loanfund', ['loanFunds' => $loanFunds, 'search' => $search],compact('balance'));
    }

    public function listHistory(Request $request)
    {
        $balance = Balance::first();
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

        return view('loan_fund.list-historyloanfund', ['loanFunds' => $loanFunds, 'search' => $search],compact('balance'));
    }

    public function detail($id)
    {
        $balance = Balance::first();
    
        $loanFund = LoanFund::find($id);
        if (!$loanFund) {
            return redirect()->route('admin.list-loanfund')->with('error', 'Loan fund not found.');
        }
    
        $loanBills = LoanBills::where('loan_fund_id', $loanFund->id)->get();
    
        return view('loan_fund.detail-loanfund', compact('loanFund', 'loanBills', 'balance'));
    }
    
    public function detailFundBills($id)
    {
        $balance = Balance::first();
    
        $loanBill = LoanBills::find($id);
        if (!$loanBill) {
            return redirect()->route('admin.detail-loanfund')->with('error', 'Loan bill not found.');
        }
    
        return view('loan_fund.detail-fundbills', compact('loanBill', 'balance'));
    }
        

    public function create(Request $request)
    {
        try {
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

            $user = $this->getUserByPin($request->input('pin'));

            if (!$user) {
                return $this->handleUserNotFound();
            }

            $loanFund = $this->createLoanFund($request, $user);

            if (!$loanFund) {                
                Session::flash('failed-balance');
                return redirect()->route('admin.loanfund-form');
            }

            $nominalInfaq = $this->calculateNominalInfaq($loanFund);

            $this->generateLoanBills($loanFund, $nominalInfaq);

            $this->addHistoryBills($loanFund);

            $this->updateBalance($loanFund->nominal);

            Session::flash('success');
            return redirect()->route('admin.list-loanfund');
        } catch (ModelNotFoundException $e) {
            Session::flash('failed');
            return redirect()->route('admin.loanfund-form');
        } catch (QueryException $e) {
            return redirect()->route('admin.loanfund-form');
        }
    }

    private function getUserByPin($pin)
    {
        return User::where('pin', $pin)->first();
    }

    private function handleUserNotFound()
    {
        Session::flash('userNotFound', 'Successfully created a user account');
        return redirect()->route('admin.loanfund-form');
    }

    private function createLoanFund(Request $request, User $user)
    {
        $loanFund = new LoanFund();
        $loanFund->user_id = $user->id;             
        $loanFund->nominal = $request->input('nominal');
        $loanFund->infaq = $request->input('infaq');
        $loanFund->infaq_type = $request->input('infaq_type');
        $loanFund->infaq_status = $loanFund->infaq_type == 'first';
        $loanFund->installment = $request->input('installment');
        $loanFund->installment_amount = 0;
        $loanFund->month = 1;
        $loanFund->status = false;

        if (!$this->updateBalance($loanFund->nominal)) {            
            return false;
        }

        $loanFund->save();

        return $loanFund;
    }

    private function calculateNominalInfaq(LoanFund $loanFund)
    {
        if ($loanFund->infaq_type == 'first') {
            return 0;
        } elseif ($loanFund->infaq_type == 'last') {
            $monthlength = $loanFund->installment;
            $startMonth = Carbon::now()->timezone('Asia/Jakarta');
            $endMonth = Carbon::now()->timezone('Asia/Jakarta');

            for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {
                $startMonth->addMinutes(1);
            }

            for ($monthnow = 1; $monthnow < $monthlength; $monthnow++) {
                $endMonth->addMinutes(1);
            }

            $loanBill = new LoanBills();
            $loanBill->loan_fund_id = $loanFund->id;
            $loanBill->month = $loanFund->installment;
            $loanBill->installment = 0;
            $loanBill->installment_amount = $loanFund->nominal * $loanFund->infaq / 100;            
            $loanBill->start_date = $startMonth;
            $loanBill->end_date = $endMonth;
            $loanBill->status = false;
            $loanBill->payment_status = false; 
            $loanBill->save();       
            return 0;
        } else if ($loanFund->infaq_type == 'installment') {
            return $loanFund->nominal * $loanFund->infaq / 100;
        } 
    }

    private function generateLoanBills(LoanFund $loanFund, $nominalInfaq)
    {
        $totalLoanFund = $loanFund->nominal + $nominalInfaq;
        $monthlength = $loanFund->installment;
        $installmentAmount = floor($totalLoanFund / $monthlength);
        $lastInstallmentAmount = $totalLoanFund - ($installmentAmount * ($monthlength - 1));
        $currentMonth = Carbon::now()->timezone('Asia/Jakarta');
        $firstStatus = true;

        for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {            
            $loanBill = new LoanBills();
            $loanBill->loan_fund_id = $loanFund->id;            
            $loanBill->month = $monthnow;
            $loanBill->installment = 1;
            $loanBill->installment_amount = ($monthnow == $monthlength) ? $lastInstallmentAmount : $installmentAmount;
            $loanBill->start_date = $currentMonth->format('Y-m-d H:i');
            $currentMonth->addMinutes(1);
            $loanBill->end_date = $currentMonth->format('Y-m-d H:i');
            $loanBill->status = $firstStatus;
            $loanBill->payment_status = false; 
            $loanBill->save();
            $firstStatus = false;
        }
    }

    private function addHistoryBills(LoanFund $loanFund)
    {
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');
        $balanceHistory = new BalanceHistory();
        $balanceHistory->loan_fund_id = $loanFund->id;
        $balanceHistory->nominal = $loanFund->nominal;
        $balanceHistory->description = "Loan Fund";
        $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');
        $balanceHistory->save();
    }

    private function updateBalance($nominal)
    {
        $balance = Balance::first();
        $result = $balance->nominal - $nominal;

        if ($result < 0) {
            return false;
        }

        $balance->nominal = $result;
        $balance->save();
        return true;
    }


    public function edit($id)
    {
        $loanFunds = LoanFund::find($id);
        if (!$loanFunds) {
            return redirect()->route('admin.user-form')->with('error', 'User not found.');
        }
        return view('loan_fund.loanfund-edit', ['loanFunds' => $loanFunds]);
    }

    public function editFundBill($id)
    {
        $loanBills = LoanBills::find($id);
        if (!$loanBills) {
            return redirect()->route('admin.loanfund-form')->with('error', 'Loan Bills not found.');
        }
        return view('loan_fund.fundBills-edit', ['loanBills' => $loanBills]);
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

    public function updateFundBills(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',
            'payment_type' => 'required'
        ]);
    
        $loanBill = LoanBills::findOrFail($id);
        if (!$loanBill) {
            return redirect()->route('admin.detail-loanfund', ['id' => $id])->with('error', 'Loan bill not found.');
        }
    
        $loanBill->status =  $request->input('status');
        $loanBill->payment_status = $request->input('payment_status');
        $loanBill->payment_type = $request->input('payment_type');
        $loanBill->save();
    
        Session::flash('updateSuccess');
    
        return redirect()->route('admin.detail-loanfund', ['id' => $loanBill->loan_fund_id]);
    }
    
    
    public function destroy($id)
    {
        try {
            $loanFund = LoanFund::findOrFail($id);

            $loanBills = LoanBills::where('loan_fund_id', $id)->get();

            foreach ($loanBills as $loanBill) {
                $loanBill->delete();
            }

            
            $balance = Balance::first();            
            $balance->nominal = $balance->nominal + $loanFund->nominal;
            $balance->save();
            
            $balanceHistory = BalanceHistory::where('loan_fund_id', $id)->first();
            $balanceHistory->delete();
    
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
