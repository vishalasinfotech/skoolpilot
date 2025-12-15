<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolAdmin\AcademicClassController;
use App\Http\Controllers\SchoolAdmin\AcademicSessionController;
use App\Http\Controllers\SchoolAdmin\AttendanceController;
use App\Http\Controllers\SchoolAdmin\CalendarController;
use App\Http\Controllers\SchoolAdmin\EventController;
use App\Http\Controllers\SchoolAdmin\ExamController;
use App\Http\Controllers\SchoolAdmin\ExamScheduleController;
use App\Http\Controllers\SchoolAdmin\FeeCollectionController;
use App\Http\Controllers\SchoolAdmin\FeedbackController as SchoolAdminFeedbackController;
use App\Http\Controllers\SchoolAdmin\FeeStructureController;
use App\Http\Controllers\SchoolAdmin\HolidayController;
use App\Http\Controllers\SchoolAdmin\LibraryController;
use App\Http\Controllers\SchoolAdmin\ResultController;
use App\Http\Controllers\SchoolAdmin\SectionController;
use App\Http\Controllers\SchoolAdmin\StaffController;
use App\Http\Controllers\SchoolAdmin\StudentController;
use App\Http\Controllers\SchoolAdmin\SubjectController;
use App\Http\Controllers\SchoolAdmin\TeacherController;
use App\Http\Controllers\SchoolAdmin\TransportationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdmin\FeedbackController as SuperAdminFeedbackController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('subscription-plan/plans', [SubscriptionPlanController::class, 'plans'])->name('subscription-plan.plans');

    // Payment Routes
    Route::get('payment/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
    Route::post('payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('payment/success-page', [PaymentController::class, 'successPage'])->name('payment.success-page');
    Route::get('payment/failed-page', [PaymentController::class, 'failedPage'])->name('payment.failed-page');
    Route::get('payment/transaction-history', [PaymentController::class, 'transactionHistory'])->name('payment.transaction-history');
    Route::get('payment/transaction/{transaction}', [PaymentController::class, 'show'])->name('payment.transaction.show');

    Route::resource('super-admin/school', SchoolController::class)->names('super-admin.school');
    Route::resource('super-admin/subscription-plan', SubscriptionPlanController::class)->names('super-admin.subscription-plan');

    // Super Admin Settings Routes
    Route::get('super-admin/setting/general', [SettingController::class, 'general'])->name('super-admin.setting.general');
    Route::put('super-admin/setting/general', [SettingController::class, 'updateGeneral'])->name('super-admin.setting.update-general');
    Route::get('super-admin/setting/payment', [SettingController::class, 'payment'])->name('super-admin.setting.payment');
    Route::put('super-admin/setting/payment', [SettingController::class, 'updatePayment'])->name('super-admin.setting.update-payment');

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
    Route::resource('school-admin/fee-collection', FeeCollectionController::class)->names('school-admin.fee-collection');
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

    // Feedback Routes
    Route::get('super-admin/feedback', [SuperAdminFeedbackController::class, 'index'])->name('super-admin.feedback.index');
    Route::get('super-admin/feedback/{feedback}', [SuperAdminFeedbackController::class, 'show'])->name('super-admin.feedback.show');
    Route::put('super-admin/feedback/{feedback}', [SuperAdminFeedbackController::class, 'update'])->name('super-admin.feedback.update');
    Route::get('school-admin/feedback', [SchoolAdminFeedbackController::class, 'index'])->name('school-admin.feedback.index');
    Route::get('school-admin/feedback/create', [SchoolAdminFeedbackController::class, 'create'])->name('school-admin.feedback.create');
    Route::post('school-admin/feedback', [SchoolAdminFeedbackController::class, 'store'])->name('school-admin.feedback.store');

    // Library & Transportation Routes
    // Custom library routes must be defined BEFORE resource route to avoid route conflicts
    Route::get('school-admin/library/issue', [LibraryController::class, 'issue'])->name('school-admin.library.issue');
    Route::post('school-admin/library/issue', [LibraryController::class, 'issueBook'])->name('school-admin.library.issue-book');
    Route::get('school-admin/library/issued-books', [LibraryController::class, 'issuedBooks'])->name('school-admin.library.issued-books');
    Route::post('school-admin/library/return/{bookIssue}', [LibraryController::class, 'returnBook'])->name('school-admin.library.return-book');
    Route::resource('school-admin/library', LibraryController::class)->names('school-admin.library');
    Route::resource('school-admin/transportation', TransportationController::class)->names('school-admin.transportation');

    // Reports Routes
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Super Admin Reports
    Route::get('reports/super-admin/revenue', [ReportController::class, 'revenue'])->name('reports.super-admin.revenue');
    Route::get('reports/super-admin/schools', [ReportController::class, 'schools'])->name('reports.super-admin.schools');
    Route::get('reports/super-admin/transactions', [ReportController::class, 'transactions'])->name('reports.super-admin.transactions');

    // School Admin Reports
    Route::get('reports/school-admin/students', [ReportController::class, 'students'])->name('reports.school-admin.students');
    Route::get('reports/school-admin/teachers', [ReportController::class, 'teachers'])->name('reports.school-admin.teachers');
    Route::get('reports/school-admin/staff', [ReportController::class, 'staff'])->name('reports.school-admin.staff');
    Route::get('reports/school-admin/attendance', [ReportController::class, 'attendance'])->name('reports.school-admin.attendance');
    Route::get('reports/school-admin/fees', [ReportController::class, 'fees'])->name('reports.school-admin.fees');
    Route::get('reports/school-admin/exam-results', [ReportController::class, 'examResults'])->name('reports.school-admin.exam-results');
    Route::get('reports/school-admin/library', [ReportController::class, 'library'])->name('reports.school-admin.library');

    // Teacher Reports
    Route::get('reports/teacher/class-students', [ReportController::class, 'classStudents'])->name('reports.teacher.class-students');
    Route::get('reports/teacher/attendance', [ReportController::class, 'teacherAttendance'])->name('reports.teacher.attendance');
    Route::get('reports/teacher/results', [ReportController::class, 'teacherResults'])->name('reports.teacher.results');

});
