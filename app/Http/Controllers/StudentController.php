<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $students = Student::where('name', 'like', "%{$search}%")
            ->orWhere('id_card_number', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);
        return response()->json(['data' => $students]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_card_number' => 'required|string|max:50|unique:students,id_card_number',
            'semester' => 'required|string|max:50',
            'faculty' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'status' => 'boolean',
        ]);

        $student = Student::create($request->only('name', 'id_card_number', 'semester', 'faculty', 'phone_number', 'status'));
        return response()->json(['message' => 'Student added successfully', 'student' => $student], 201);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_card_number' => 'required|string|max:50|unique:students,id_card_number,' . $id,
            'semester' => 'required|string|max:50',
            'faculty' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'status' => 'boolean',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->only('name', 'id_card_number', 'semester', 'faculty', 'phone_number', 'status'));
        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}