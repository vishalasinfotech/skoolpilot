<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Notification\SendNotificationRequest;
use App\Models\CustomNotification;
use App\Models\NotificationTemplate;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(static function ($request, $next) {
    //         Gate::authorize('access-school-admin');

    //         return $next($request);
    //     });
    // }

    /**
     * Display a listing of sent notifications.
     */
    public function index(): View
    {
        return view('school-admin.notification.index');
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create(): View
    {
        $schoolId = auth()->user()->school_id;
        $templates = NotificationTemplate::where('school_id', $schoolId)
            ->where('is_active', true)
            ->get();

        $availableRoles = [
            'teacher' => 'Teacher',
            'student' => 'Student',
            'parent' => 'Parent',
            'staff' => 'Staff',
        ];

        return view('school-admin.notification.create', compact('templates', 'availableRoles'));
    }

    /**
     * Store a newly created notification and send it.
     */
    public function store(SendNotificationRequest $request, NotificationService $notificationService): RedirectResponse
    {
        $schoolId = auth()->user()->school_id;
        $senderId = auth()->id();

        $userIds = $request->user_ids ?? [];

        $notification = $notificationService->sendNotification(
            schoolId: $schoolId,
            senderId: $senderId,
            title: $request->title,
            message: $request->message,
            type: $request->send_type,
            roles: $request->roles,
            userIds: $userIds,
            url: $request->url,
            templateId: $request->notification_template_id,
            sendEmail: $request->boolean('send_email', true)
        );

        return redirect()
            ->route('school-admin.notification.index')
            ->with('success', "Notification sent successfully to {$notification->total_recipients} recipient(s).");
    }

    /**
     * Display the specified notification.
     */
    public function show(CustomNotification $notification): View
    {
        Gate::authorize('view', $notification);

        $notification->load(['sender', 'template', 'recipients.user']);

        return view('school-admin.notification.show', compact('notification'));
    }

    /**
     * Get users for autocomplete.
     */
    public function getUsers(): JsonResponse
    {
        $schoolId = auth()->user()->school_id;
        $search = request('search', '');
        $userId = request('id');

        $query = User::where('school_id', $schoolId)
            ->where('is_active', true);

        if ($userId) {
            $query->where('id', $userId);
        } elseif ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('admission_number', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        $users = $query->limit(20)
            ->get(['id', 'name', 'email', 'first_name', 'last_name', 'role']);

        return response()->json($users);
    }
}
