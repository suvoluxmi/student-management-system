<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_name',
        'fee_type',
        'amount',
        'payment_date',
        'method',
        'status',
    ];
}
