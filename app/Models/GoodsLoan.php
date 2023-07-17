<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsLoan extends Model
{
    use HasFactory;
    protected $table = 'goods_loan';

    protected $fillable = [
        'user_id',
        'goods',
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
}
