<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/student-management', function () {
    return view('student_management');
});
Route::get('/faculty-management', function () {
    return view('faculty.faculty-management');
});


Route::resource('faculties', FacultyController::class);