<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolAdmin\AcademicClassController;
use App\Http\Controllers\SchoolAdmin\AcademicSessionController;
use App\Http\Controllers\SchoolAdmin\AttendanceController;
use App\Http\Controllers\SchoolAdmin\CalendarController;
use App\Http\Controllers\SchoolAdmin\EventController;
use App\Http\Controllers\SchoolAdmin\ExamController;
use App\Http\Controllers\SchoolAdmin\ExamScheduleController;
use App\Http\Controllers\SchoolAdmin\FeeStructureController;
use App\Http\Controllers\SchoolAdmin\HolidayController;
use App\Http\Controllers\SchoolAdmin\LibraryController;
use App\Http\Controllers\SchoolAdmin\ResultController;
use App\Http\Controllers\SchoolAdmin\SectionController;
use App\Http\Controllers\SchoolAdmin\SettingController;
use App\Http\Controllers\SchoolAdmin\StaffController;
use App\Http\Controllers\SchoolAdmin\StudentController;
use App\Http\Controllers\SchoolAdmin\SubjectController;
use App\Http\Controllers\SchoolAdmin\TeacherController;
use App\Http\Controllers\SchoolAdmin\TransportationController;
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

    Route::resource('school-admin/section', SectionController::class)->names('school-admin.section');
    Route::resource('school-admin/academic-class', AcademicClassController::class)->names('school-admin.academic-class');
    Route::resource('school-admin/academic-session', AcademicSessionController::class)->names('school-admin.academic-session');
    Route::resource('school-admin/subject', SubjectController::class)->names('school-admin.subject');
    Route::resource('school-admin/fee-structure', FeeStructureController::class)->names('school-admin.fee-structure');
    Route::resource('school-admin/event', EventController::class)->names('school-admin.event');
    Route::resource('school-admin/holiday', HolidayController::class)->names('school-admin.holiday');

    // Exams & Results Routes
    Route::resource('school-admin/exam', ExamController::class)->names('school-admin.exam');
    Route::resource('school-admin/exam-schedule', ExamScheduleController::class)->names('school-admin.exam-schedule');
    Route::resource('school-admin/result', ResultController::class)->names('school-admin.result');

    Route::get('school-admin/calendar', [CalendarController::class, 'index'])->name('school-admin.calendar.index');
    Route::get('school-admin/calendar/events', [CalendarController::class, 'getEvents'])->name('school-admin.calendar.events');

    Route::get('school-admin/setting', [SettingController::class, 'index'])->name('school-admin.setting.index');
    Route::put('school-admin/setting', [SettingController::class, 'update'])->name('school-admin.setting.update');

    Route::get('school-admin/attendance', [AttendanceController::class, 'index'])->name('school-admin.attendance.index');
    Route::post('school-admin/attendance', [AttendanceController::class, 'store'])->name('school-admin.attendance.store');
    Route::get('school-admin/attendance/show', [AttendanceController::class, 'show'])->name('school-admin.attendance.show');
    Route::put('school-admin/attendance/{attendance}', [AttendanceController::class, 'update'])->name('school-admin.attendance.update');
    Route::delete('school-admin/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('school-admin.attendance.destroy');

    // Library & Transportation Routes
    Route::resource('school-admin/library', LibraryController::class)->names('school-admin.library');
    Route::resource('school-admin/transportation', TransportationController::class)->names('school-admin.transportation');

});
