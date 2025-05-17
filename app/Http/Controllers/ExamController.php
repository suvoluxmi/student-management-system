<?php

namespace App\Http\Controllers;
use App\Models\Exam;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    
    public function index(Request $request)
{
    $search = $request->get('search', '');
    $exams = Exam::where('title', 'like', "%$search%")
                        ->orWhere('subject', 'like', "%$search%")
                        ->paginate(10);
   return response()->json([
        'data' => $exams
    ]);
}

public function store(Request $request)
{


    $payment = Exam::create($request->all());
    return response()->json($payment, 201);
}
}
