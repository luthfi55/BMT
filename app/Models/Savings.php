<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    use HasFactory;
    protected $table = 'savings';

    protected $fillable = [
        'user_id',
        'type',
        'nominal',
        'date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
