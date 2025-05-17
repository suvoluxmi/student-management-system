<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FeedbackController;

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
Route::get('/course-management', function () {
    return view('course.course-management');
});

Route::resource('/courses', CourseController::class);

Route::resource('students', StudentController::class);
Route::get('/student-feedback', function () {
    return view('student_feedback.student_feedback');
});

Route::get('/exam-management', function () {
    return view('exam.exam');
});
Route::get('/fee-payment', function () {
    return view('fee_payment.fee_payment');
});

Route::resource('exams', ExamController::class);
Route::resource('payments', PaymentController::class);
Route::resource('feedback', FeedbackController::class);


