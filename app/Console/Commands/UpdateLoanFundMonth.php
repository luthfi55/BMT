<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\LoanFund;

class UpdateLoanFundMonth extends Command
{
    protected $signature = 'loanfund:update-month';

    protected $description = 'Update the month property of loan funds';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // $loanFunds = LoanFund::all();

        // foreach ($loanFunds as $loanFund) {
        //     $currentMonth = Carbon::now()->timezone('Asia/Jakarta')->startOfMonth();

        //     $loanBill = $loanFund->loanBills()->orderBy('month', 'desc')->first();
        //     if ($loanBill && $currentMonth->isAfter($loanBill->date)) {
        //         $loanFund->month = $loanBill->month + 1;
        //     } else {
        //         $loanFund->month = 1;
        //     }

        //     $loanFund->save();
        // }

        // $this->info('Loan fund months updated successfully.');
    }
}
