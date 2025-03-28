<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/test', function () {
    return view('test');
});
Route::get('/course-management', function () {
    return view('course.course-management');
});
