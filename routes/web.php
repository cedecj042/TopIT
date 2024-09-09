<?php

use App\Http\Controllers\Admin\ProcessedPdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\PretestController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/register', [StudentController::class, 'showStudentRegistration'])->name('register');
    Route::post('/register', [StudentController::class, 'registerStudent']);

    Route::get('/login', [StudentController::class, 'showLoginStudent'])->name('login');
    Route::post('/login', [StudentController::class, 'loginStudent']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('student')->group(function () {
    Route::view('/welcomepage', 'student.ui.welcomepage')->name('welcomepage');
    Route::view('/postpretest', 'student.ui.postpretest')->name('postpretest');

    Route::view('/dashboard', 'student.ui.dashboard')->name('dashboard');
    Route::view('/course', 'student.ui.course')->name('course');
    Route::view('/test', 'student.ui.test')->name('test');
    Route::view('/profile', 'student.ui.profile')->name('profile');

    Route::get('/pretest/{number}', [PretestController::class, 'showQuestion'])->name('pretest.question');

});

// Admin
Route::get('/admin-login', [AdminController::class, 'showLogin'])->name('admin-login');
Route::post('/admin-login', [AdminController::class, 'login']);
Route::post('/admin/store-processed-pdf/',[ProcessedPdfController::class,'store'])->name('store-pdf');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'showDashboard'])->name('admin-dashboard');
    Route::get('/admin-course', [CourseController::class, 'showCourse'])->name('admin-course');
    Route::post('/admin-course/add', [CourseController::class, 'addCourse'])->name('add-course');
    Route::get('/admin-course/{course_id}', [CourseController::class, 'showCourseDetail'])->name('admin-course-detail');
    Route::post('/admin-course/pdf/upload', [PdfController::class, 'uploadPdf'])->name('upload-pdf');
    Route::delete('/admin-course/pdf/delete/{id}', [PdfController::class, 'deletePdf'])->name('delete-pdf');
    // Route::get('/admin-question-bank', [AdminController::class, 'showQuestionBank'])->name('admin-question-bank');
    Route::get('/admin-question-bank-list', [QuestionsController::class, 'showQuestionBank'])->name('admin-question-bank-list');
    Route::get('/admin-question-bank-manage', [QuestionsController::class, 'showQuestionBankManage'])->name('admin-question-bank-manage');

    Route::get('/admin-users', [AdminController::class, 'showUsers'])->name('admin-users');
    Route::delete('/admin-users/{user}', [AdminController::class, 'destroy'])->name('admin-users.destroy');
    Route::post('/admin/add-coordinator', [AdminController::class, 'addCoordinator'])->name('admin.add-coordinator');
    Route::get('/admin-profile', [AdminController::class, 'showProfile'])->name('admin-profile');
    Route::get('/admin-studentprofile/{student_id}', [AdminController::class, 'showStudentProfile'])->name('admin-studentprofile');
    Route::get('/admin-reports', [AdminController::class, 'showReports'])->name('admin-reports');

});
