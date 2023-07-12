<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanBills extends Model
{
    use HasFactory;
    protected $table = 'loan_bills';

    protected $fillable = [
        'loan_fund_id',
        'goods_loan_id',
        'month',
        'installment',
        'installment_amount',
        'date',
        'status',
    ];
}
