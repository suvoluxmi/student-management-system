<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected $fillable = [
        'title', 'subject', 'date', 'total_marks', 'passing_marks', 'status'
    ];


}
