<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $fillable = ['user_id', 'bills_id', 'description', 'nominal', 'status'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function loan_bills(){
        return $this->belongsTo(LoanBills::class, 'bills_id');
    }
}
