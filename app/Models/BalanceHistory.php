<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $table = 'balance_history';

    protected $fillable = [
        'loan_fund_id',
        'godds_loan_id',    
        'operational_id',
        'loan_bils_id',
        'savings_id',
        'nominal',
        'date',
    ];
    
}
