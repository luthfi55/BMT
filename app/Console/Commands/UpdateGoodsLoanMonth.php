<?php

namespace App\Console\Commands;

use App\Models\GoodsLoan;
use App\Models\LoanBills;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateGoodsLoanMonth extends Command
{
    protected $signature = 'goodsloan:update-month';

    protected $description = 'Update the month property of goods loan';

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
                
            if ($currentDateTime->format('H:i') == Carbon::parse($loanBill->start_date)->timezone('Asia/Jakarta')->format('H:i')) {                
                //ubah status
                $loanBill->status = true;
                $loanBill->save();
                
                //ubah month            
                $goodsLoan = GoodsLoan::find($loanBill->goods_loan_id);                     
                
                if ($goodsLoan && $goodsLoan->month < $goodsLoan->installment) {                    
                    $goodsLoan->month += 1;
                    $goodsLoan->save();

                    $this->info("Updated month for LoanFund ID: {$goodsLoan->id}");
                }        
            }
            
            $this->info('Loan bills checked.');
        }
    }
}
