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

            $user = $this->getUserByPin($request->input('pin'));

            if (!$user) {
                return $this->handleUserNotFound();
            }

            $goodsLoan = $this->createGoodsLoan($request, $user);

            $nominalInfaq = $this->calculateNominalInfaq($goodsLoan);

            $this->generateLoanBills($goodsLoan, $nominalInfaq);

            $this->addHistoryBills($goodsLoan);

            $this->updateBalance($goodsLoan->nominal);

            Session::flash('success');
            return redirect()->route('admin.list-goodsloan');
        } catch (ModelNotFoundException $e) {
            Session::flash('failed');
            return redirect()->route('admin.goodsloan-form');
        } catch (QueryException $e) {
            return redirect()->route('admin.goodsloan-form');
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
        $goodsLoan->save();

        return $goodsLoan;
    }

    private function calculateNominalInfaq(GoodsLoan $goodsLoan)
    {
        if ($goodsLoan->infaq_type == 'first') {
            return 0;
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
        $balance->nominal = $balance->nominal - $nominal;
        $balance->save();
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
            'payment_type' => 'required'
        ]);
    
        $loanBill = LoanBills::findOrFail($id);
        if (!$loanBill) {
            return redirect()->route('admin.detail-goodsloan', ['id' => $id])->with('error', 'Loan bill not found.');
        }
    
        $loanBill->status =  $request->input('status');
        $loanBill->payment_status = $request->input('payment_status');
        $loanBill->payment_type = $request->input('payment_type');
        $loanBill->save();
    
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
