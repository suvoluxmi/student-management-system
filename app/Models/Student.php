<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'id_card_number', 'semester', 'faculty', 'phone_number', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];
}
