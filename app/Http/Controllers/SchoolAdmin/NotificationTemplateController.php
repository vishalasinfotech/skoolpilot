<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\NotificationTemplate\StoreNotificationTemplateRequest;
use App\Http\Requests\SchoolAdmin\NotificationTemplate\UpdateNotificationTemplateRequest;
use App\Models\NotificationTemplate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class NotificationTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(static function ($request, $next) {
            Gate::authorize('access-school-admin');

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('school-admin.notification-template.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('school-admin.notification-template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationTemplateRequest $request): RedirectResponse
    {
        $schoolId = auth()->user()->school_id;

        NotificationTemplate::create([
            'school_id' => $schoolId,
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'variables' => $request->variables ?? [],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('school-admin.notification-template.index')
            ->with('success', 'Notification template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NotificationTemplate $notificationTemplate): View
    {
        Gate::authorize('view', $notificationTemplate);

        return view('school-admin.notification-template.show', compact('notificationTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotificationTemplate $notificationTemplate): View
    {
        Gate::authorize('update', $notificationTemplate);

        return view('school-admin.notification-template.edit', compact('notificationTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationTemplateRequest $request, NotificationTemplate $notificationTemplate): RedirectResponse
    {
        Gate::authorize('update', $notificationTemplate);

        $notificationTemplate->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'variables' => $request->variables ?? [],
            'is_active' => $request->boolean('is_active', $notificationTemplate->is_active),
        ]);

        return redirect()
            ->route('school-admin.notification-template.index')
            ->with('success', 'Notification template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotificationTemplate $notificationTemplate): RedirectResponse
    {
        Gate::authorize('delete', $notificationTemplate);

        $notificationTemplate->delete();

        return redirect()
            ->route('school-admin.notification-template.index')
            ->with('success', 'Notification template deleted successfully.');
    }
}
