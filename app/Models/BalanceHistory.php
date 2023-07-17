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
        'goods_loan_id',    
        'operational_id',
        'loan_bills_id',
        'savings_id',
        'nominal',
        'description',
        'date',
    ];
    
}
