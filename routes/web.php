<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/student-management', function () {
    return view('student_management');
});
Route::get('/course-management', function () {
    return view('course.course-management');
});

Route::resource('/courses', CourseController::class);

Route::resource('students', StudentController::class);
