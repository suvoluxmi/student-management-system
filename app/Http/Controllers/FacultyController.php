<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $faculties = Faculty::where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);
        return response()->json(['data' => $faculties]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:faculties,email',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:100',
            'designation' => 'required|string|max:100',
            'status' => 'boolean',
        ]);

        $faculty = Faculty::create($request->only('name', 'email', 'phone', 'department', 'designation', 'status'));
        return response()->json(['message' => 'Faculty added successfully', 'faculty' => $faculty], 201);
    }

    public function show($id)
    {
        $faculty = Faculty::findOrFail($id);
        return response()->json($faculty);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:faculties,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:100',
            'designation' => 'required|string|max:100',
            'status' => 'boolean',
        ]);

        $faculty = Faculty::findOrFail($id);
        $faculty->update($request->only('name', 'email', 'phone', 'department', 'designation', 'status'));
        return response()->json(['message' => 'Faculty updated successfully', 'faculty' => $faculty]);
    }

    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();
        return response()->json(['message' => 'Faculty deleted successfully']);
    }
}