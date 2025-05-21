<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Exam;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_students' => Student::count(),
            'total_faculty' => Faculty::count(),
            'total_exams' => Exam::count(),
            'total_payment_amount' => Payment::sum('amount'),
            'total_feedback' => Feedback::count(),
            'total_courses' => Course::count(),
        ];

        return response()->json($data);
    }
}
