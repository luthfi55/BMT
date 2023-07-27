<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\BalanceHistory;
use App\Models\LoanBills;
use App\Models\Savings;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Payment;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // $client_key = config('midtrans.client_key');
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bills_id' => 'required',
            'description' => 'required|string',
            'nominal' => 'required|integer',
            'status' => 'required|in:Unpaid,Paid',
        ]);

        $payment = $this->createPayment($validatedData);

        $snapToken = $this->generateSnapToken($payment);

        return response()->json([
            'message' => 'Payment created successfully',
            'data' => [
                'payment' => $payment,
                'snap_token' => $snapToken,
                'client_key' => 'SB-Mid-client-T9jrTX0BmSV206rm',
            ],
        ], 201);
    }

    private function createPayment(array $data)
    {
        return Payment::create([
            'user_id' => $data['user_id'],
            'bills_id' => $data['bills_id'],
            'description' => $data['description'],
            'nominal' => $data['nominal'],
            'status' => $data['status'],
        ]);
    }

    private function generateSnapToken(Payment $payment)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $user = User::findOrFail($payment->user_id);

        $params = [
            'transaction_details' => [
                'order_id' => $payment->id,
                'gross_amount' => $payment->nominal,
                'description_payment' => $payment->description,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'last_name' => '',
                'email' => $user->email,
            ],
        ];

        return Snap::getSnapToken($params);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
                $order = Payment::find($request->order_id);
                $order->update(['status' => 'Paid']);        
                $paymentData = [];

                if ($order->description === 'Mandatory Savings') {
                    $savings = Savings::find($order->bills_id);
                    $savings->status = 0;
                    $savings->payment_status = 1;
                    $savings->payment_type = $request->payment_type;
                    $savings->payment_date = $request->transaction_time;
                    $savings->save();
                    $paymentData = $savings;
                    $this->saveBalanceHistorySavings($order->bills_id, $request->gross_amount, $order->description, $request->transaction_time);        
                } else {                    
                    $bills = LoanBills::find($order->bills_id);
                    $bills->status = 0;
                    $bills->payment_status = 1;
                    $bills->payment_type = $request->payment_type;
                    $bills->payment_date = $request->transaction_time;
                    $bills->save();
                    $paymentData = $bills;
                    $this->saveBalanceHistoryLoanBills($order->bills_id, $request->gross_amount, $order->description, $request->transaction_time);        
                }

                $this->updateBalance($request->gross_amount);

                return response()->json([
                    'message' => 'Payment successfully',
                    'data' => [$paymentData],
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Payment created failed',
                'data' => ['Null'],
            ], 201);
        }
    }

    private function saveBalanceHistoryLoanBills($billsId, $nominal, $description, $date)
    {
        $balanceHistory = new BalanceHistory();
        $balanceHistory->loan_bills_id = $billsId;
        $balanceHistory->nominal = $nominal;
        $balanceHistory->description = $description;
        $balanceHistory->date = $date;
        $balanceHistory->save();
    }

    private function saveBalanceHistorySavings($billsId, $nominal, $description, $date)
    {
        $balanceHistory = new BalanceHistory();
        $balanceHistory->savings_id = $billsId;
        $balanceHistory->nominal = $nominal;
        $balanceHistory->description = $description;
        $balanceHistory->date = $date;
        $balanceHistory->save();
    }

    private function updateBalance($nominal)
    {
        $balance = Balance::first();
        $balance->nominal += $nominal;
        $balance->save();
    }

}
