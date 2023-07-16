<?php

namespace App\Console\Commands;

use App\Models\LoanBills;
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
        $loanBills = LoanBills::all();

        foreach ($loanBills as $loanBill) {
            $currentDateTime = Carbon::now()->timezone('Asia/Jakarta');
            
            // pengkondisian menggunakan waktu harian
            // if ($currentDateTime->isSameDay(Carbon::parse($loanBill->date)->timezone('Asia/Jakarta'))) {
                
            if ($currentDateTime->format('H:i') == Carbon::parse($loanBill->date)->timezone('Asia/Jakarta')->format('H:i')) {                
                //ubah status
                $loanBill->status = true;
                $loanBill->save();
                //ubah month
                $loanFund = LoanFund::find($loanBill->loan_fund_id);

                if ($loanFund && $loanFund->month < $loanFund->installment) {                    
                    $loanFund->month += 1;
                    $loanFund->save();

                    $this->info("Updated month for LoanFund ID: {$loanFund->id}");
                }        
            }
            
            $this->info('Loan bills checked.');
        }
    }
}