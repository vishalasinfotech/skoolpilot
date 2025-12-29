<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchoolAdmin\AcademicClassController;
use App\Http\Controllers\SchoolAdmin\AcademicSessionController;
use App\Http\Controllers\SchoolAdmin\AssignmentController;
use App\Http\Controllers\SchoolAdmin\AttendanceController;
use App\Http\Controllers\SchoolAdmin\CalendarController;
use App\Http\Controllers\SchoolAdmin\EventController;
use App\Http\Controllers\SchoolAdmin\ExamController;
use App\Http\Controllers\SchoolAdmin\ExamScheduleController;
use App\Http\Controllers\SchoolAdmin\FeeCollectionController;
use App\Http\Controllers\SchoolAdmin\FeedbackController as SchoolAdminFeedbackController;
use App\Http\Controllers\SchoolAdmin\FeeStructureController;
use App\Http\Controllers\SchoolAdmin\HolidayController;
use App\Http\Controllers\SchoolAdmin\LeaveApplicationController;
use App\Http\Controllers\SchoolAdmin\LibraryController;
use App\Http\Controllers\SchoolAdmin\NotificationController as SchoolAdminNotificationController;
use App\Http\Controllers\SchoolAdmin\NotificationTemplateController;
use App\Http\Controllers\SchoolAdmin\PromotionController;
use App\Http\Controllers\SchoolAdmin\ResultController;
use App\Http\Controllers\SchoolAdmin\SectionController;
use App\Http\Controllers\SchoolAdmin\StaffController;
use App\Http\Controllers\SchoolAdmin\StudentController;
use App\Http\Controllers\SchoolAdmin\SubjectController;
use App\Http\Controllers\SchoolAdmin\TeacherController;
use App\Http\Controllers\SchoolAdmin\TransportationController;
use App\Http\Controllers\SchoolController as PublicSchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdmin\FeedbackController as SuperAdminFeedbackController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\SubscriptionPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Language Switching Route (available to all users)
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');

// Auth Routes
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/school/register', [PublicSchoolController::class, 'create'])->name('school.register');
    Route::post('/school/register', [PublicSchoolController::class, 'store'])->name('school.register.store');
});

Route::middleware('auth', 'prevent-back-history')->group(function () {

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Notification Routes
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/notification/{notificationRecipient}', [NotificationController::class, 'show'])->name('notification.show')->where('notificationRecipient', '[0-9]+');
    Route::post('/notification/{notificationRecipient}/read', [NotificationController::class, 'markAsRead'])->name('notification.mark-read')->where('notificationRecipient', '[0-9]+');

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');

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

    // Language Management Routes (Super Admin Only)
    Route::resource('super-admin/language', LanguageController::class)->names('super-admin.language');
    Route::post('super-admin/language/{language}/toggle-status', [LanguageController::class, 'toggleStatus'])->name('super-admin.language.toggle-status');
    Route::post('super-admin/language/{language}/set-default', [LanguageController::class, 'setAsDefault'])->name('super-admin.language.set-default');

    // Permission Management Routes (Super Admin only)
    Route::resource('roles', RoleController::class)
        ->except(['show'])
        ->names('roles');

    Route::middleware('active-subscription')
        ->prefix('school-admin')
        ->group(function () {
            Route::resource('teacher', TeacherController::class)->names('school-admin.teacher');
            Route::get('teacher-bulk-import', [TeacherController::class, 'bulkImport'])->name('school-admin.teacher.bulk-import');
            Route::post('teacher-bulk-import', [TeacherController::class, 'processBulkImport'])->name('school-admin.teacher.process-bulk-import');

            Route::resource('student', StudentController::class)->names('school-admin.student');
            Route::get('student-bulk-import', [StudentController::class, 'bulkImport'])->name('school-admin.student.bulk-import');
            Route::post('student-bulk-import', [StudentController::class, 'processBulkImport'])->name('school-admin.student.process-bulk-import');

            Route::get('promotions', [PromotionController::class, 'index'])->name('school-admin.promotions.index');
            Route::post('promotions', [PromotionController::class, 'store'])->name('school-admin.promotions.store');

            Route::resource('staff', StaffController::class)->names('school-admin.staff');
            Route::get('staff-bulk-import', [StaffController::class, 'bulkImport'])->name('school-admin.staff.bulk-import');
            Route::post('staff-bulk-import', [StaffController::class, 'processBulkImport'])->name('school-admin.staff.process-bulk-import');

            Route::resource('section', SectionController::class)->names('school-admin.section');
            Route::resource('academic-class', AcademicClassController::class)->names('school-admin.academic-class');
            Route::resource('academic-session', AcademicSessionController::class)->names('school-admin.academic-session');
            Route::resource('subject', SubjectController::class)->names('school-admin.subject');
            Route::resource('fee-structure', FeeStructureController::class)->names('school-admin.fee-structure');
            Route::resource('fee-collection', FeeCollectionController::class)->names('school-admin.fee-collection');
            Route::resource('event', EventController::class)->names('school-admin.event');
            Route::resource('holiday', HolidayController::class)->names('school-admin.holiday');

            // Exams & Results Routes
            Route::resource('exam', ExamController::class)->names('school-admin.exam');
            Route::resource('exam-schedule', ExamScheduleController::class)->names('school-admin.exam-schedule');
            Route::resource('result', ResultController::class)->names('school-admin.result');

            Route::get('calendar', [CalendarController::class, 'index'])->name('school-admin.calendar.index');
            Route::get('calendar/events', [CalendarController::class, 'getEvents'])->name('school-admin.calendar.events');

            Route::get('setting', [SettingController::class, 'index'])->name('school-admin.setting.index');
            Route::put('setting', [SettingController::class, 'update'])->name('school-admin.setting.update');

            Route::get('attendance', [AttendanceController::class, 'index'])->name('school-admin.attendance.index');
            Route::post('attendance', [AttendanceController::class, 'store'])->name('school-admin.attendance.store');
            Route::get('attendance/show', [AttendanceController::class, 'show'])->name('school-admin.attendance.show');
            Route::put('attendance/{attendance}', [AttendanceController::class, 'update'])->name('school-admin.attendance.update');
            Route::delete('attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('school-admin.attendance.destroy');

            // Leave Application Routes
            Route::get('/leave-application', [LeaveApplicationController::class, 'index'])->name('school-admin.leave-application.index');
            Route::get('teacher/leave-application/create', [LeaveApplicationController::class, 'create'])->name('teacher.leave-application.create');
            Route::post('teacher/leave-application', [LeaveApplicationController::class, 'store'])->name('teacher.leave-application.store');
            Route::delete('teacher/leave-application/{leaveApplication}', [LeaveApplicationController::class, 'destroy'])->name('teacher.leave-application.destroy');
            Route::get('teacher/leave-application/{leaveApplication}', [LeaveApplicationController::class, 'show'])->name('teacher.leave-application.show');

            // Feedback Routes (School Admin)
            Route::get('feedback', [SchoolAdminFeedbackController::class, 'index'])->name('school-admin.feedback.index');
            Route::get('feedback/create', [SchoolAdminFeedbackController::class, 'create'])->name('school-admin.feedback.create');
            Route::post('feedback', [SchoolAdminFeedbackController::class, 'store'])->name('school-admin.feedback.store');

            // Notification Routes
            Route::get('notification', [SchoolAdminNotificationController::class, 'index'])->name('school-admin.notification.index');
            Route::get('notification/create', [SchoolAdminNotificationController::class, 'create'])->name('school-admin.notification.create');
            Route::post('notification', [SchoolAdminNotificationController::class, 'store'])->name('school-admin.notification.store');
            Route::get('notification/{notification}', [SchoolAdminNotificationController::class, 'show'])->name('school-admin.notification.show');
            Route::get('notification/users/search', [SchoolAdminNotificationController::class, 'getUsers'])->name('school-admin.notification.get-users');

            // Notification Template Routes
            Route::resource('notification-template', NotificationTemplateController::class)->names('school-admin.notification-template');

            // Library & Transportation Routes
            // Custom library routes must be defined BEFORE resource route to avoid route conflicts
            Route::get('library/issue', [LibraryController::class, 'issue'])->name('school-admin.library.issue');
            Route::post('library/issue', [LibraryController::class, 'issueBook'])->name('school-admin.library.issue-book');
            Route::get('library/issued-books', [LibraryController::class, 'issuedBooks'])->name('school-admin.library.issued-books');
            Route::post('library/return/{bookIssue}', [LibraryController::class, 'returnBook'])->name('school-admin.library.return-book');
            Route::resource('library', LibraryController::class)->names('school-admin.library');
            Route::resource('transportation', TransportationController::class)->names('school-admin.transportation');
        });

    // Feedback Routes
    Route::get('super-admin/feedback', [SuperAdminFeedbackController::class, 'index'])->name('super-admin.feedback.index');
    Route::get('super-admin/feedback/{feedback}', [SuperAdminFeedbackController::class, 'show'])->name('super-admin.feedback.show');
    Route::put('super-admin/feedback/{feedback}', [SuperAdminFeedbackController::class, 'update'])->name('super-admin.feedback.update');

    // Reports Routes
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Super Admin Reports
    Route::get('reports/super-admin/revenue', [ReportController::class, 'revenue'])->name('reports.super-admin.revenue');
    Route::get('reports/super-admin/schools', [ReportController::class, 'schools'])->name('reports.super-admin.schools');
    Route::get('reports/super-admin/transactions', [ReportController::class, 'transactions'])->name('reports.super-admin.transactions');

    // School Admin Reports
    Route::middleware('active-subscription')
        ->prefix('reports/school-admin')
        ->group(function () {
            Route::get('students', [ReportController::class, 'students'])->name('reports.school-admin.students');
            Route::get('teachers', [ReportController::class, 'teachers'])->name('reports.school-admin.teachers');
            Route::get('staff', [ReportController::class, 'staff'])->name('reports.school-admin.staff');
            Route::get('attendance', [ReportController::class, 'attendance'])->name('reports.school-admin.attendance');
            Route::get('fees', [ReportController::class, 'fees'])->name('reports.school-admin.fees');
            Route::get('exam-results', [ReportController::class, 'examResults'])->name('reports.school-admin.exam-results');
            Route::get('library', [ReportController::class, 'library'])->name('reports.school-admin.library');
        });

    // Teacher Reports
    Route::get('reports/teacher/class-students', [ReportController::class, 'classStudents'])->name('reports.teacher.class-students');
    Route::get('reports/teacher/attendance', [ReportController::class, 'teacherAttendance'])->name('reports.teacher.attendance');
    Route::get('reports/teacher/results', [ReportController::class, 'teacherResults'])->name('reports.teacher.results');

    // Complaint Routes
    Route::get('teacher/complaint', [ComplaintController::class, 'teacherIndex'])->name('teacher.complaint.index');
    Route::get('parent/complaint', [ComplaintController::class, 'parentIndex'])->name('parent.complaint.index');

    // Student Routes
    Route::get('student/exam-schedule-results', [ExamScheduleController::class, 'studentIndex'])->name('student.exam-schedule-results');
    Route::get('student/fee', [FeeCollectionController::class, 'studentIndex'])->name('student.fee');
    Route::get('student/reports', [ReportController::class, 'studentReports'])->name('student.reports');

    // Parent Routes
    Route::get('parent/my-children', [StudentController::class, 'myChildren'])->name('parent.my-children');
    Route::get('parent/student-reports', [ReportController::class, 'parentStudentReports'])->name('parent.student-reports');

    Route::get('teacher/leave-application', [LeaveApplicationController::class, 'teacherIndex'])->name('teacher.leave-application.index');
    // Assignment Routes
    Route::get('teacher/assignment', [AssignmentController::class, 'teacherIndex'])->name('teacher.assignment.index');
    Route::get('teacher/assignment/create', [AssignmentController::class, 'create'])->name('teacher.assignment.create');
    Route::post('teacher/assignment', [AssignmentController::class, 'store'])->name('teacher.assignment.store');
    Route::get('teacher/assignment/{assignment}', [AssignmentController::class, 'show'])->name('teacher.assignment.show');
    Route::get('teacher/assignment/{assignment}/edit', [AssignmentController::class, 'edit'])->name('teacher.assignment.edit');
    Route::put('teacher/assignment/{assignment}', [AssignmentController::class, 'update'])->name('teacher.assignment.update');
    Route::delete('teacher/assignment/{assignment}', [AssignmentController::class, 'destroy'])->name('teacher.assignment.destroy');

});
