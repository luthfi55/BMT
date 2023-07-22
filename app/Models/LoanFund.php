<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LoanFund extends Model
{
    use HasFactory;    

    protected $table = 'loan_fund';

    protected $fillable = [
        'user_id',
        'nominal',
        'infaq',
        'infaq_type',
        'infaq_status',
        'installment',
        'installment_amount',
        'month',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanBills()
    {
        return $this->hasMany(LoanBills::class);
    }

}
