<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('student_name', 'like', "%$search%")
                  ->orWhere('fee_type', 'like', "%$search%");
        }

        $payments = $query->orderBy('id', 'desc')->paginate(10);
        return response()->json(['data' => $payments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string',
            'fee_type' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'method' => 'required|string',
            'status' => 'required|boolean',
        ]);

        Payment::create($request->all());
        return response()->json(['message' => 'Payment created successfully']);
    }
}
