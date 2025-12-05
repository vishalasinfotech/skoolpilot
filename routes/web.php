<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolAdmin\StaffController;
use App\Http\Controllers\SchoolAdmin\StudentController;
use App\Http\Controllers\SchoolAdmin\TeacherController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\SubscriptionPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth', 'prevent-back-history')->group(function () {

    // Dashboard Routes
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::resource('super-admin/school', SchoolController::class)->names('super-admin.school');
    Route::resource('super-admin/subscription-plan', SubscriptionPlanController::class)->names('super-admin.subscription-plan');

    Route::resource('school-admin/teacher', TeacherController::class)->names('school-admin.teacher');
    Route::get('school-admin/teacher-bulk-import', [TeacherController::class, 'bulkImport'])->name('school-admin.teacher.bulk-import');
    Route::post('school-admin/teacher-bulk-import', [TeacherController::class, 'processBulkImport'])->name('school-admin.teacher.process-bulk-import');

    Route::resource('school-admin/student', StudentController::class)->names('school-admin.student');
    Route::get('school-admin/student-bulk-import', [StudentController::class, 'bulkImport'])->name('school-admin.student.bulk-import');
    Route::post('school-admin/student-bulk-import', [StudentController::class, 'processBulkImport'])->name('school-admin.student.process-bulk-import');

    Route::resource('school-admin/staff', StaffController::class)->names('school-admin.staff');
    Route::get('school-admin/staff-bulk-import', [StaffController::class, 'bulkImport'])->name('school-admin.staff.bulk-import');
    Route::post('school-admin/staff-bulk-import', [StaffController::class, 'processBulkImport'])->name('school-admin.staff.process-bulk-import');

});
