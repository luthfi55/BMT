<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoodsLoan;
use App\Models\LoanFund;
use App\Models\User;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $loanFunds = $user->loanFunds;

        return response()->json([
            'message' => 'Loan funds data retrieved successfully',
            'loan_funds' => $loanFunds,
        ]);
    }

    public function getUserData($id)
    {
        // Cari pengguna (user) berdasarkan ID yang diberikan
        $loanFund = LoanFund::where('user_id', $id)->get();
        $goodsLoan = GoodsLoan::where('user_id', $id)->get();

        if (!$loanFund) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        }

        if (!$loanFund) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        }

        // Jika pengguna ditemukan, kembalikan data pengguna dalam bentuk JSON
        return response()->json([
            'message' => 'User data retrieved successfully',
            'LoanFund' => $loanFund,
            'GoodsLoan' => $goodsLoan,
        ]);
    }
}
