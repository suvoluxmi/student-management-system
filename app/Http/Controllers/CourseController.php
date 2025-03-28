<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $courses = Course::where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);
        return response()->json(['data' => $courses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'type' => 'required|string|max:100',
            'credit' => 'required|string|max:10',
            'status' => 'boolean',
        ]);

        $course = Course::create($request->only('name', 'code', 'type', 'credit', 'status'));
        return response()->json(['message' => 'Course added successfully', 'course' => $course], 201);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $id,
            'type' => 'required|string|max:100',
            'credit' => 'required|string|max:10',
            'status' => 'boolean',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->only('name', 'code', 'type', 'credit', 'status'));
        return response()->json(['message' => 'Course updated successfully', 'course' => $course]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}