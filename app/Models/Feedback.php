<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    protected $fillable = [
        'student_name',
        'student_email',
        'issue_type',
        'message',
        'status',
    ];
}
