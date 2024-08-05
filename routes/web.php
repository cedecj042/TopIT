<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReviewerController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



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
    Route::view('/reviewer', 'student.ui.reviewer')->name('reviewer');
    Route::view('/test', 'student.ui.test')->name('test');
    Route::view('/profile', 'student.ui.profile')->name('profile');
});

// Admin
Route::get('/admin-login', [AdminController::class, 'showLogin'])->name('admin-login');
Route::post('/admin-login', [AdminController::class, 'login']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'showDashboard'])->name('admin-dashboard');
    Route::get('/admin-reviewer', [ReviewerController::class, 'showReviewer'])->name('admin-reviewer');
    Route::post('/admin-reviewer', [ReviewerController::class, 'uploadReviewer'])->name('upload-reviewer');
    Route::get('/admin-question-bank', [AdminController::class, 'showQuestionBank'])->name('admin-question-bank');
    Route::get('/admin-users', [AdminController::class, 'showUsers'])->name('admin-users');
    Route::delete('/admin-users/{user}', [AdminController::class, 'destroy'])->name('admin-users.destroy');
    Route::post('/admin/add-coordinator', [AdminController::class, 'addCoordinator'])->name('admin.add-coordinator');
    Route::get('/admin-profile', [AdminController::class, 'showProfile'])->name('admin-profile');
    Route::get('/admin-studentprofile/{student_id}', [AdminController::class, 'showStudentProfile'])->name('admin-studentprofile');


});
