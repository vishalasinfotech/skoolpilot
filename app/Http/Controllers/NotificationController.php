<?php

namespace App\Http\Controllers;

use App\Models\NotificationRecipient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get user notifications for the topbar (AJAX endpoint).
     */
    public function getNotifications(): JsonResponse
    {
        $userId = Auth::id();

        $notifications = NotificationRecipient::where('user_id', $userId)
            ->with(['notification.sender'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($recipient) {
                return [
                    'id' => $recipient->id,
                    'notification_id' => $recipient->notification_id,
                    'title' => $recipient->notification->title ?? 'No Title',
                    'message' => $recipient->notification->message ?? '',
                    'sender' => $recipient->notification->sender->name ?? 'System',
                    'is_read' => $recipient->is_read,
                    'created_at' => $recipient->created_at->diffForHumans(),
                    'url' => $recipient->notification->url ?? null,
                ];
            });

        $unreadCount = NotificationRecipient::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Display the specified notification for the current user.
     */
    public function show(NotificationRecipient $notificationRecipient): View|RedirectResponse
    {
        // Ensure the notification belongs to the current user
        if ($notificationRecipient->user_id !== Auth::id()) {
            abort(403);
        }

        $notificationRecipient->load(['notification.sender', 'notification.template']);

        // Mark as read if not already read
        if (! $notificationRecipient->is_read) {
            $notificationRecipient->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        $notification = $notificationRecipient->notification;

        return view('notification.show', compact('notification', 'notificationRecipient'));
    }

    /**
     * Mark notification as read (AJAX endpoint).
     */
    public function markAsRead(NotificationRecipient $notificationRecipient): JsonResponse
    {
        // Ensure the notification belongs to the current user
        if ($notificationRecipient->user_id !== Auth::id()) {
            abort(403);
        }

        if (! $notificationRecipient->is_read) {
            $notificationRecipient->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }
}
