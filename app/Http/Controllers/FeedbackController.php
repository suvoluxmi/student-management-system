<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index(Request $request)
{
    $search = $request->get('search');
    $feedbacks = Feedback::where('student_name', 'like', "%$search%")
        ->orWhere('issue_type', 'like', "%$search%")
        ->paginate(10);

    return response()->json(['data' => $feedbacks]);
}

public function store(Request $request)
{
    Feedback::create($request->all());
    return response()->json(['message' => 'Feedback added successfully']);
}

public function show($id)
{
    return Feedback::findOrFail($id);
}

public function update(Request $request, $id)
{
    Feedback::findOrFail($id)->update($request->all());
    return response()->json(['message' => 'Feedback updated']);
}

public function destroy($id)
{
    Feedback::destroy($id);
    return response()->json(['message' => 'Deleted']);
}

}
