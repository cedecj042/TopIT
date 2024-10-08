<?php

use App\Http\Controllers\Admin\ProcessedPdfController;
use App\Http\Controllers\Admin\ProcessQuestionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\VectorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\PretestController;
use App\Livewire\PretestAdd;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/register', [StudentController::class, 'showStudentRegistration'])->name('register');
    Route::post('/register', [StudentController::class, 'registerStudent']);

    Route::get('/login', [StudentController::class, 'showLoginStudent'])->name('login');
    Route::post('/login', [StudentController::class, 'loginStudent'])->name('student.login');

    Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login']);

});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware('student')->group(function () {

    Route::view('/dashboard', 'student.ui.dashboard')->name('dashboard');
    Route::get('/course', [StudentCourseController::class, 'showStudentCourse'])->name('student-course');
    Route::get('/course/{id}/', [StudentCourseController::class, 'showStudentCourseDetail'])->name('student-course-detail');
    Route::get('/course/module/{id}', [StudentCourseController::class, 'showModuleDetail'])->name('student-module-detail');
    Route::view('/test', 'student.ui.test')->name('test');
    Route::view('/profile', 'student.ui.profile')->name('profile');

    Route::view('/welcomepage', 'student.ui.welcomepage')->name('welcomepage');

    Route::prefix('pretest')->group(function () {
        Route::get('/start', [PretestController::class, 'startPretest'])->name('pretest.start');
        Route::get('/questions/{courseIndex?}', [PretestController::class, 'showQuestions'])->name('pretest.questions');
        Route::post('/submit', [PretestController::class, 'submitAnswers'])->name('pretest.submit');
        Route::get('/finish/{pretestId}', action: [PretestController::class, 'showFinishAttempt'])->name('pretest.finish');
        Route::get('/review/{pretestId}', [PretestController::class, 'reviewPretest'])->name('pretest.review');
    });

});


// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/store-processed-pdf', [ProcessedPdfController::class, 'store'])->name('store-pdf');
    Route::post('/store-questions', [ProcessQuestionController::class, 'storeQuestions'])->name('store-questions');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
   
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');

    // Courses
    Route::prefix('course')->name('course.')->group(function () {
        Route::get('/', [CourseController::class, 'showCourse'])->name('index');
        Route::post('/add', [CourseController::class, 'addCourse'])->name('add');
        Route::get('/{course_id}', [CourseController::class, 'showCourseDetail'])->name('detail');
        Route::post('/pdf/upload', [PdfController::class, 'uploadPdf'])->name('pdf.upload');
        Route::delete('/pdf/delete/{id}', [PdfController::class, 'deletePdf'])->name('pdf.delete');
    });

    // Modules
    Route::prefix('modules')->name('modules.')->group(function () {
        // Route::view('/store','admin.ui.course.module.vectorize');
        Route::get('/vector', [ModuleController::class, 'vectorShow'])->name('vector.show');
        Route::post('/vector/upload', [ModuleController::class, 'vectorStore'])->name('vector.upload');
        Route::get('/', [ModuleController::class, 'showModules'])->name('index');
        Route::post('/update', [ModuleController::class, 'updateModule'])->name('update');
        Route::get('/{id}', [ModuleController::class, 'editModule'])->name('edit');

    });

    // Lessons
    Route::prefix('lessons')->name('lessons.')->group(function () {
        Route::view('/', 'admin.ui.course.')->name('index');
    });

    // Sections
    Route::prefix('sections')->name('sections.')->group(function () {
        Route::view('/', 'admin.ui.course.sections.index')->name('index');
        Route::get('/{id}', [SectionController::class, 'editSection'])->name('edit');
        Route::post('/update', [ModuleController::class, 'updateSection'])->name('update');

    });
    // Question Bank
    Route::prefix('questions')->name('questions.')->group(function () {
        Route::get('/', [QuestionController::class, 'showQuestions'])->name('index');
        Route::get('/generate', [QuestionController::class, 'viewGenerateQuestions'])->name('generate');
        Route::post('/send', [QuestionController::class, 'generateQuestions'])->name('send');
        Route::get('/pretest', [QuestionController::class, 'showPretestQuestions'])->name('pretest.index');
        Route::get('/pretest/add', PretestAdd::class)->name('pretest.add');
        Route::post('/pretest/store', [QuestionController::class, 'storePretest'])->name('pretest.store');
        Route::get('/pretest/delete/{id}', [QuestionController::class, 'deletePretestQuestions'])->name('pretest.delete');
        // Route::get('/bank/list', [QuestionController::class, 'showQuestionBank'])->name('admin-question-bank-list');
        // Route::get('/manage', [QuestionController::class, 'showQuestionManage'])->name('manage');
        Route::post('/update/{id}', [QuestionController::class, 'updateQuestion'])->name('update');
        Route::get('/edit/{id}', [QuestionController::class, 'editQuestion'])->name('edit');

    });


    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'showUsers'])->name('index');
        Route::delete('/{user}', [AdminController::class, 'destroy'])->name('destroy');
        Route::post('/add-coordinator', [AdminController::class, 'addCoordinator'])->name('add-coordinator');
    });

    // Profiles
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('profile');
    Route::get('/studentprofile/{student_id}', [AdminController::class, 'showStudentProfile'])->name('studentprofile');
    Route::get('/reports', [AdminController::class, 'showReports'])->name('reports');

});
