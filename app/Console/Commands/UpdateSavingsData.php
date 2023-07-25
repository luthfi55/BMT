<?php

namespace App\Console\Commands;

use App\Models\Savings;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateSavingsData extends Command
{
    protected $signature = 'savings:update-savings';

    protected $description = 'Update the savings data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {            
        $savings = Savings::all();

        foreach ($savings as $saving){
            $currentDateTime = Carbon::now()->timezone('Asia/Jakarta');
            if ($currentDateTime->format('H:i') == Carbon::parse($saving->end_date)->timezone('Asia/Jakarta')->format('H:i')) {               
                $startDate = Carbon::now()->timezone('Asia/Jakarta');
                $endtDate = Carbon::now()->timezone('Asia/Jakarta')->addMinutes(1);
                // ->addMonth()
                $newSaving = new Savings();
                $newSaving->user_id = $saving->user_id;
                $newSaving->type = 'mandatory';
                $newSaving->nominal = $saving->nominal;
                $newSaving->start_date = $startDate;        
                $newSaving->end_date = $endtDate;
                $newSaving->status = false;
                $newSaving->payment_status = false; 
                $newSaving->payment_type = 'cash'; 
                $newSaving->payment_date = $startDate; 
                $newSaving->save();

                $this->info("Create saving for user ID: {$newSaving->user_id}");
            }
            $this->info('Savings checked.');
        }

        // $loanBills = LoanBills::all();

        // foreach ($loanBills as $loanBill) {
        //     $currentDateTime = Carbon::now()->timezone('Asia/Jakarta');
            
        //     // pengkondisian menggunakan waktu harian
        //     // if ($currentDateTime->isSameDay(Carbon::parse($loanBill->date)->timezone('Asia/Jakarta'))) {
                
        //     if ($currentDateTime->format('H:i') == Carbon::parse($loanBill->start_date)->timezone('Asia/Jakarta')->format('H:i')) {                
        //         //ubah status
        //         $loanBill->status = true;
        //         $loanBill->save();

        //         //ubah month
        //         $loanFund = LoanFund::find($loanBill->loan_fund_id);                

        //         if ($loanFund && $loanFund->month < $loanFund->installment) {                    
        //             $loanFund->month += 1;
        //             $loanFund->save();

        //             $this->info("Updated month for LoanFund ID: {$loanFund->id}");
        //         }                        
        //     }
            
        //     $this->info('Loan bills checked.');
        // }
    }
}
