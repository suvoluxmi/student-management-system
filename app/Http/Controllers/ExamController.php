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
                        ->latest()
                        ->paginate(10);
   return response()->json([
        'data' => $exams
    ]);
}
public function show(Exam $exam)
    {
        return response()->json($exam);
    }
    public function update(Request $request, Exam $exam)
    {
        $exam->update($request->all());
        return response()->json($exam);
    }

public function store(Request $request)
{


    $payment = Exam::create($request->all());
    return response()->json($payment, 201);
}
public function destroy(Exam $exam)
    {
        $exam->delete();
        return response()->json(['message' => 'Exam deleted successfully'], 200);
    }
}
