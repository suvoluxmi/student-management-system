<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'department', 'designation', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];
}
