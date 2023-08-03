<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\BalanceHistory;
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
                    ->orWhere('mandatory_savings', 'LIKE', "%$search%");
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
            return redirect()->route('admin.list-goodsloan')->with('error', 'Loan bill not found.');
        }

        $loanBills = LoanBills::where('goods_loan_id', $goodsLoan->id)->get();

        return view('goods_loan.detail-goodsloan', ['goodsLoan' => $goodsLoan, 'loanBills' => $loanBills],compact('balance'));
    }

    public function detailGoodsBills($id)
    {
        $balance = Balance::first();
    
        $loanBill = LoanBills::find($id);
        if (!$loanBill) {
            return redirect()->route('admin.detail-goodsloan')->with('error', 'Loan bill not found.');
        }
    
        return view('goods_loan.detail-goodsbills', compact('loanBill', 'balance'));
    }    

    public function create(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'goods' => 'required',
                'nominal' => 'required',
                'infaq' => 'required',
                'infaq_type' => 'required',            
                'installment' => 'required',                    
            ]); 

            if (!$request->has('infaq_type')) {
                return redirect()->route('admin.loanfund-form')->withErrors(['infaq_type' => 'Infaq Type harus dipilih.'])->withInput();
            }     

            $user = $this->getUserByEmail($request->input('email'));

            if (!$user) {
                return $this->handleUserNotFound();
            }

            $goodsLoan = $this->createGoodsLoan($request, $user);

            if (!$goodsLoan) {                
                Session::flash('failed-balance');
                return redirect()->route('admin.goodsloan-form');
            }

            $nominalInfaq = $this->calculateNominalInfaq($goodsLoan);

            $this->generateLoanBills($goodsLoan, $nominalInfaq);

            $this->addHistoryBills($goodsLoan);            

            Session::flash('success');
            return redirect()->route('admin.list-goodsloan');
        } catch (ModelNotFoundException $e) {
            Session::flash('failed');
            return redirect()->route('admin.goodsloan-form');
        } catch (QueryException $e) {
            return redirect()->route('admin.goodsloan-form');
        }
    }

    private function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    private function handleUserNotFound()
    {
        Session::flash('userNotFound', 'Successfully created a user account');
        return redirect()->route('admin.loanfund-form');
    }

    private function createGoodsLoan(Request $request, User $user)
    {
        $goodsLoan = new GoodsLoan();
        $goodsLoan->user_id = $user->id;     
        $goodsLoan->goods = $request->input('goods');        
        $goodsLoan->nominal = $request->input('nominal');
        $goodsLoan->infaq = $request->input('infaq');
        $goodsLoan->infaq_type = $request->input('infaq_type');
        $goodsLoan->infaq_status = $goodsLoan->infaq_type == 'first';
        $goodsLoan->installment = $request->input('installment');
        $goodsLoan->installment_amount = 0;
        $goodsLoan->month = 1;
        $goodsLoan->status = false;

        if (!$this->updateBalance($goodsLoan->nominal)) {            
            return false;
        }

        $goodsLoan->save();

        return $goodsLoan;
    }

    private function calculateNominalInfaq(GoodsLoan $goodsLoan)
    {
        if ($goodsLoan->infaq_type == 'first') {
            $startMonth = Carbon::now()->timezone('Asia/Jakarta');

            $loanBill = new LoanBills();
            $loanBill->goods_loan_id = $goodsLoan->id;
            $loanBill->month = 1;
            $loanBill->installment = $goodsLoan->installment;
            $loanBill->installment_amount = $goodsLoan->nominal * $goodsLoan->infaq / 100;            
            $loanBill->start_date = $startMonth;
            $loanBill->end_date = $startMonth;
            $loanBill->status = true;
            $loanBill->payment_status = true; 
            $loanBill->save();
            
            $currentTime = Carbon::now()->timezone('Asia/Jakarta');
            $balanceHistory = new BalanceHistory();
            $balanceHistory->loan_bills_id = $loanBill->id;
            $balanceHistory->nominal = $loanBill->installment_amount;
            $balanceHistory->description = "Infaq";
            $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');
            $balanceHistory->save();

            $balance = Balance::first();
            $result = $balance->nominal + $loanBill->installment_amount;
            
            $balance->nominal = $result;
            $balance->save();
            return true;
        } elseif ($goodsLoan->infaq_type == 'last') {
            $monthlength = $goodsLoan->installment;
            $startMonth = Carbon::now()->timezone('Asia/Jakarta');
            $endMonth = Carbon::now()->timezone('Asia/Jakarta');

            for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {
                $startMonth->addMinutes(1);
            }

            for ($monthnow = 1; $monthnow < $monthlength; $monthnow++) {
                $endMonth->addMinutes(1);
            }

            $loanBill = new LoanBills();
            $loanBill->goods_loan_id = $goodsLoan->id;
            $loanBill->month = $goodsLoan->installment;
            $loanBill->installment = 0;
            $loanBill->installment_amount = $goodsLoan->nominal * $goodsLoan->infaq / 100;            
            $loanBill->start_date = $startMonth;
            $loanBill->end_date = $endMonth;
            $loanBill->status = false;
            $loanBill->payment_status = false; 
            $loanBill->save();       
            return 0;
        } else if ($goodsLoan->infaq_type == 'installment') {
            return $goodsLoan->nominal * $goodsLoan->infaq / 100;
        } 
    }

    private function generateLoanBills(GoodsLoan $goodsLoan, $nominalInfaq)
    {
        $totalgoodsLoan = $goodsLoan->nominal + $nominalInfaq;
        $monthlength = $goodsLoan->installment;
        $installmentAmount = floor($totalgoodsLoan / $monthlength);
        $lastInstallmentAmount = $totalgoodsLoan - ($installmentAmount * ($monthlength - 1));
        $currentMonth = Carbon::now()->timezone('Asia/Jakarta');
        $firstStatus = true;

        for ($monthnow = 1; $monthnow <= $monthlength; $monthnow++) {            
            $loanBill = new LoanBills();
            $loanBill->goods_loan_id = $goodsLoan->id;            
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

    private function addHistoryBills(GoodsLoan $goodsLoan)
    {
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');
        $balanceHistory = new BalanceHistory();
        $balanceHistory->goods_loan_id = $goodsLoan->id;
        $balanceHistory->nominal = $goodsLoan->nominal;
        $balanceHistory->description = "Goods Loan";
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

    public function updateGoodsBills(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',            
        ]);
    
        $loanBill = LoanBills::findOrFail($id);
        if (!$loanBill) {
            return redirect()->route('admin.detail-goodsloan', ['id' => $id])->with('error', 'Loan bill not found.');
        }

        $currentTime = Carbon::now()->timezone('Asia/Jakarta');
    
        $loanBill->status =  $request->input('status');
        $loanBill->payment_status = $request->input('payment_status');
        $loanBill->payment_type = $request->input('payment_type');
        $loanBill->payment_date = $currentTime;
        $loanBill->save();

        if ($loanBill->payment_status == 1) {            
            $checkHistory = BalanceHistory::where('loan_bills_id',$loanBill->id)->first();
            if(!$checkHistory){                
                $balance = Balance::all()->first();
                $balance->nominal = $balance->nominal + $loanBill->installment_amount;
                $balance->save() ;

                $balanceHistory = new BalanceHistory();
                $balanceHistory->loan_bills_id = $loanBill->id;
                $balanceHistory->nominal = $loanBill->installment_amount;
                $balanceHistory->description = "Loan Bills";
                $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');
                $balanceHistory->save();
            }            
        } elseif ($loanBill->payment_status == 0){
            $balance = Balance::all()->first();
            $balance->nominal = $balance->nominal - $loanBill->installment_amount;
            $balance->save();

            $balanceHistory = BalanceHistory::where('loan_bills_id',$loanBill->id)->first();
            if ($balanceHistory){
                $balanceHistory->delete();
            }            
        }        
        
        $goodsLoan = GoodsLoan::find($loanBill->goods_loan_id);
        if ($goodsLoan) {
            $billsChecker = LoanBills::where('goods_loan_id', $goodsLoan->id)
                                    ->where('payment_status', 0)
                                    ->get();
    
            if ($billsChecker->isEmpty()) {                                
                $goodsLoan->infaq_status = 1;
                $goodsLoan->status = 1;
                $goodsLoan->save();
            } else {
                $goodsLoan->status = 0;
                $goodsLoan->save();
            }
        }        
    
        Session::flash('updateSuccess');
    
        return redirect()->route('admin.detail-goodsloan', ['id' => $loanBill->goods_loan_id]);
    }
    

    public function destroy($id)
    {
        try {            
            $goodsLoan = GoodsLoan::findOrFail($id);
            
            $loanBills = LoanBills::where('goods_loan_id', $id)->get();
        
            foreach ($loanBills as $loanBill) {
                $loanBill->delete();
            }

            $balance = Balance::first();            
            $balance->nominal = $balance->nominal + $goodsLoan->nominal;
            $balance->save();
            
            $balanceHistory = BalanceHistory::where('goods_loan_id', $id)->first();            
            $balanceHistory->delete();
            
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
