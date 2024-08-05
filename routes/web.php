<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/register', [StudentController::class, 'showRegistration'])->name('register');
    Route::post('/register', [StudentController::class, 'register']);

    Route::get('/login', [StudentController::class, 'showLogin'])->name('login');
    Route::post('/login', [StudentController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('student')->group(function () {
    Route::view('/dashboard', 'student.ui.dashboard')->name('dashboard');
    Route::view('/course', 'student.ui.course')->name('course');
    Route::view('/test', 'student.ui.test')->name('test');
    Route::view('/profile', 'student.ui.profile')->name('profile');
});

// Admin
Route::get('/admin-login', [AdminController::class, 'showLogin'])->name('admin-login');
Route::post('/admin-login', [AdminController::class, 'login']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'showDashboard'])->name('admin-dashboard');
    Route::get('/admin-course', [CourseController::class, 'showCourse'])->name('admin-course');
    Route::post('/admin-course/add', [CourseController::class, 'addCourse'])->name('add-course');
    Route::get('/admin-course/{course_id}', [CourseController::class, 'showCourseDetail'])->name('admin-course-detail');
    Route::post('/admin-course/pdf/upload', [PdfController::class, 'uploadPdf'])->name('upload-pdf');
    Route::delete('/admin-course/pdf/delete/{id}', [PdfController::class, 'deletePdf'])->name('delete-pdf');
    Route::get('/admin-question-bank', [AdminController::class, 'showQuestionBank'])->name('admin-question-bank');
});
