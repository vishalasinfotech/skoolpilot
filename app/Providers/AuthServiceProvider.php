<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Language;
use App\Models\Result;
use App\Models\School;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Policies\AttendancePolicy;
use App\Policies\ExamPolicy;
use App\Policies\ExamSchedulePolicy;
use App\Policies\LanguagePolicy;
use App\Policies\ResultPolicy;
use App\Policies\SchoolPolicy;
use App\Policies\SpatieRolePolicy;
use App\Policies\SubscriptionPlanPolicy;
use App\Policies\TeacherPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role as SpatieRole;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        // Gate::before(function (User $user, string $ability) {
        //     if ($user->role === 'super_admin') {
        //         return true;
        //     }
        // });

        Gate::policy(School::class, SchoolPolicy::class);
        Gate::policy(SubscriptionPlan::class, SubscriptionPlanPolicy::class);
        Gate::policy(Language::class, LanguagePolicy::class);
        Gate::policy(SpatieRole::class, SpatieRolePolicy::class);
        Gate::policy(Exam::class, ExamPolicy::class);
        Gate::policy(ExamSchedule::class, ExamSchedulePolicy::class);
        Gate::policy(Result::class, ResultPolicy::class);
        Gate::policy(Attendance::class, AttendancePolicy::class);
        Gate::policy(User::class, TeacherPolicy::class);

        Gate::define('access-super-admin', static fn (User $user): bool => $user->role === 'super_admin');
        Gate::define('access-school-admin', static fn (User $user): bool => in_array($user->role, ['school_admin', 'school-admin'], true));
        Gate::define('access-teacher', static fn (User $user): bool => $user->role === 'teacher');
        Gate::define('access-student', static fn (User $user): bool => $user->role === 'student');
        Gate::define('access-parent', static fn (User $user): bool => $user->role === 'parent');
        Gate::define('view-subscription-plans', static fn (User $user): bool => in_array($user->role, ['school_admin', 'school-admin'], true));
    }
}
