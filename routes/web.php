<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/student-management', function () {
    return view('student_management');
});
Route::get('/course-management', function () {
    return view('course.course-management');
});
