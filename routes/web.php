<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'student.dashboard')->name('dashboard');

Route::view('/reviewer', 'student.reviewer')->name('reviewer');
Route::view('/test', 'student.test')->name('test');

Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



# Admin
Route::get('/admin-login', [AdminController::class, 'showLogin'])->name('admin-login');
Route::get('/admin-reviewer', [AdminController::class, 'showReviewer'])->name('admin-reviewer');
