<!-- ========== App Menu (SRS-aligned) ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="#" class="logo logo-dark">
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="" height="22"></span>
            <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="" height="17"></span>
        </a>
        <a href="#" class="logo logo-light">
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="" height="22"></span>
            <span class="logo-lg"><img src="assets/images/logo-light.png" alt="" height="17"></span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">{{ __('common.menu') }}</span></li>

                <!-- Dashboards -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">{{ __('common.dashboards') }}</span>
                    </a>
                </li>

                <!-- Super Admin -->
                <li class="menu-title"><span data-key="t-menu">{{ __('common.super_admin') }}</span></li>

                <li class="nav-item" data-role="super_admin">
                    <a class="nav-link menu-link" href="#sidebarSuperAdmin" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarSuperAdmin">
                        <i class="ri-building-line"></i> <span>{{ __('common.school_management') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSuperAdmin">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('super-admin.school.index') }}" class="nav-link">{{ __('common.all_schools') }}</a></li>
                            <li class="nav-item"><a href="{{ route('super-admin.subscription-plan.index') }}"
                                    class="nav-link">{{ __('common.subscriptions_plans') }}</a></li>
                            <li class="nav-item"><a href="{{ route('payment.transaction-history') }}"
                                    class="nav-link">{{ __('common.transaction_history') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="super_admin">
                    <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarSettings">
                        <i class="ri-settings-3-line"></i> <span>{{ __('common.settings') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('super-admin.setting.general') }}"
                                    class="nav-link">{{ __('common.configuration') }}</a></li>
                            <li class="nav-item"><a href="{{ route('super-admin.setting.payment') }}"
                                    class="nav-link">{{ __('common.payment_gateway') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="super_admin">
                    <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                        <i class="ri-shield-user-line"></i> <span>{{ __('common.permission_management') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="super_admin">
                    <a class="nav-link menu-link" href="#sidebarReports" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarReports">
                        <i class="ri-bar-chart-line"></i> <span>{{ __('common.reports') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarReports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('reports.index') }}" class="nav-link">{{ __('common.all_reports') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.super-admin.revenue') }}" class="nav-link">{{ __('common.revenue_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.super-admin.schools') }}" class="nav-link">{{ __('common.schools_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.super-admin.transactions') }}" class="nav-link">{{ __('common.transactions_report') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="super_admin">
                    <a class="nav-link menu-link" href="{{ route('super-admin.feedback.index') }}">
                        <i class="ri-chat-3-line"></i> <span>{{ __('common.feedback') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="super_admin">
                    <a class="nav-link menu-link" href="{{ route('super-admin.language.index') }}">
                        <i class="ri-global-line"></i> <span>{{ __('common.language_management') }}</span>
                    </a>
                </li>

                <!-- School Admin -->
                <li class="menu-title"><span data-key="t-menu">{{ __('common.school_admin') }}</span></li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarUsers">
                        <i class="ri-group-line"></i> <span>{{ __('common.users_staff') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('school-admin.teacher.index') }}"
                                    class="nav-link">{{ __('common.teachers') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.student.index') }}"
                                    class="nav-link">{{ __('common.students') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.staff.index') }}"
                                    class="nav-link">{{ __('common.staff') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.promotions.index') }}" class="nav-link">{{ __('common.promotions') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="#sidebarAcademic" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAcademic">
                        <i class="ri-book-open-line"></i> <span>{{ __('common.academic') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAcademic">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('school-admin.academic-class.index') }}"
                                    class="nav-link">{{ __('common.classes') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.section.index') }}"
                                    class="nav-link">{{ __('common.sections') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.subject.index') }}"
                                    class="nav-link">{{ __('common.subjects') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.academic-session.index') }}"
                                    class="nav-link">{{ __('common.academic_sessions') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.attendance.index') }}"
                                    class="nav-link">{{ __('common.attendance') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.exam.index') }}"
                                    class="nav-link">{{ __('common.exams') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.exam-schedule.index') }}"
                                    class="nav-link">{{ __('common.exam_schedules') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.result.index') }}"
                                    class="nav-link">{{ __('common.results') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="#sidebarEvents" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarEvents">
                        <i class="ri-calendar-event-line"></i> <span>{{ __('common.events_calendar') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarEvents">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('school-admin.event.index') }}"
                                    class="nav-link">{{ __('common.events') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.holiday.index') }}"
                                    class="nav-link">{{ __('common.holidays') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.calendar.index') }}"
                                    class="nav-link">{{ __('common.calendar') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="#sidebarFees" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarFees">
                        <i class="ri-money-dollar-circle-line"></i> <span>{{ __('common.fees_finance') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarFees">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('school-admin.fee-structure.index') }}"
                                    class="nav-link">{{ __('common.fee_structure') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.fee-collection.index') }}"
                                    class="nav-link">{{ __('common.fee_collection') }}</a></li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="#sidebarLibrary" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarLibrary">
                        <i class="ri-book-open-line"></i> <span>{{ __('common.library') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLibrary">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('school-admin.library.index') }}"
                                    class="nav-link">{{ __('common.all_books') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.library.issued-books') }}"
                                    class="nav-link">{{ __('common.issued_books') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="{{ route('school-admin.setting.index') }}">
                        <i class="ri-paint-line"></i> <span>{{ __('common.white_label_customization') }}</span>
                    </a>
                </li>


                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="{{ route('school-admin.transportation.index') }}">
                        <i class="ri-bus-2-line"></i> <span>{{ __('common.transportation') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="{{ route('subscription-plan.plans') }}">
                        <i class="ri-price-tag-2-line"></i> <span>{{ __('common.current_plan') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="{{ route('school-admin.feedback.index') }}">
                        <i class="ri-feedback-line"></i> <span>{{ __('common.feedback') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="{{ route('school-admin.notification.index') }}">
                        <i class="ri-notification-line"></i> <span>{{ __('common.send_notification') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="school_admin">
                    <a class="nav-link menu-link" href="#sidebarSchoolReports" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarSchoolReports">
                        <i class="ri-file-chart-line"></i> <span>{{ __('common.reports') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSchoolReports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('reports.index') }}" class="nav-link">{{ __('common.all_reports') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.students') }}" class="nav-link">{{ __('common.students_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.teachers') }}" class="nav-link">{{ __('common.teachers_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.staff') }}" class="nav-link">{{ __('common.staff_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.attendance') }}" class="nav-link">{{ __('common.attendance_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.fees') }}" class="nav-link">{{ __('common.fees_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.exam-results') }}" class="nav-link">{{ __('common.exam_results_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.school-admin.library') }}" class="nav-link">{{ __('common.library_report') }}</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Teacher -->
                <li class="menu-title"><span data-key="t-menu">{{ __('common.teacher') }}</span></li>

                <li class="nav-item" data-role="teacher">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-user-3-line"></i> <span>{{ __('common.profile') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="teacher">
                    <a class="nav-link menu-link" href="#sidebarClassroom" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarClassroom">
                        <i class="ri-contacts-line"></i> <span>{{ __('common.classroom') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarClassroom">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="#" class="nav-link">{{ __('common.attendance') }}</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">{{ __('common.assignments') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.exam.index') }}"
                                    class="nav-link">{{ __('common.exams') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.exam-schedule.index') }}"
                                    class="nav-link">{{ __('common.exam_schedules') }}</a></li>
                            <li class="nav-item"><a href="{{ route('school-admin.result.index') }}"
                                    class="nav-link">{{ __('common.results') }}</a></li>

                            <li class="nav-item"><a href="#" class="nav-link">{{ __('common.apply_for_leave') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="teacher">
                    <a class="nav-link menu-link" href="#sidebarTeacherReports" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarTeacherReports">
                        <i class="ri-file-chart-line"></i> <span>{{ __('common.reports') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTeacherReports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="{{ route('reports.index') }}" class="nav-link">{{ __('common.all_reports') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.teacher.class-students') }}" class="nav-link">{{ __('common.class_students') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.teacher.attendance') }}" class="nav-link">{{ __('common.attendance_report') }}</a></li>
                            <li class="nav-item"><a href="{{ route('reports.teacher.results') }}" class="nav-link">{{ __('common.results') }} {{ __('common.reports') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" data-role="teacher">
                    <a class="nav-link menu-link" href="{{ route('teacher.complaint.index') }}">
                        <i class="ri-feedback-line"></i> <span>{{ __('common.add_student_complaint') }}</span>
                    </a>
                </li>

                <!-- Student & Parent -->
                <li class="menu-title"><span data-key="t-menu">{{ __('common.student_parent') }}</span></li>
                <li class="nav-item" data-role="student">
                    <a class="nav-link menu-link" href="{{ route('student.fee') }}">
                        <i class="ri-wallet-3-line"></i> <span>{{ __('common.fees') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="student">
                    <a class="nav-link menu-link" href="{{ route('student.exam-schedule-results') }}">
                        <i class="ri-file-list-3-line"></i> <span>{{ __('common.exam_schedule_results') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="student">
                    <a class="nav-link menu-link" href="{{ route('student.reports') }}">
                        <i class="ri-file-chart-line"></i> <span>{{ __('common.student_reports') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="parent">
                    <a class="nav-link menu-link" href="{{ route('parent.my-children') }}">
                        <i class="ri-parent-line"></i> <span>{{ __('common.my_children') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="parent">
                    <a class="nav-link menu-link" href="{{ route('parent.student-reports') }}">
                        <i class="ri-file-chart-line"></i> <span>{{ __('common.student_reports') }}</span>
                    </a>
                </li>

                <li class="nav-item" data-role="parent">
                    <a class="nav-link menu-link" href="{{ route('parent.complaint.index') }}">
                        <i class="ri-feedback-line"></i> <span>{{ __('common.view_student_complaints') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- ========== App Menu End ========== -->
