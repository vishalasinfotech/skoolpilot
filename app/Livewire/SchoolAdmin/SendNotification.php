<?php

namespace App\Livewire\SchoolAdmin;

use App\Models\NotificationTemplate;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SendNotification extends Component
{
    public string $title = '';

    public string $message = '';

    public ?string $url = null;

    public string $sendType = 'role';

    public array $selectedRoles = [];

    public array $selectedUserIds = [];

    public string $userSearch = '';

    public bool $showUserSearch = false;

    public ?int $notificationTemplateId = null;

    public bool $sendEmail = true;

    protected array $availableRoles = [
        'teacher' => 'Teacher',
        'student' => 'Student',
        'parent' => 'Parent',
        'staff' => 'Staff',
    ];

    public function updatedSendType(): void
    {
        $this->selectedRoles = [];
        $this->selectedUserIds = [];
        $this->userSearch = '';
    }

    public function updatedNotificationTemplateId(): void
    {
        if ($this->notificationTemplateId) {
            $template = NotificationTemplate::find($this->notificationTemplateId);
            if ($template) {
                $this->title = $template->subject;
                $this->message = $template->body;
            }
        }
    }

    public function sendNotification(NotificationService $notificationService): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'url' => ['nullable', 'string', 'max:500'],
            'sendType' => ['required', 'string', 'in:role,user'],
            'selectedRoles' => ['required_if:sendType,role', 'array', 'min:1'],
            'selectedRoles.*' => ['string', 'in:teacher,student,parent,staff'],
            'selectedUserIds' => ['required_if:sendType,user', 'array', 'min:1'],
            'selectedUserIds.*' => ['integer', 'exists:users,id'],
            'notificationTemplateId' => ['nullable', 'integer', 'exists:notification_templates,id'],
            'sendEmail' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'message.required' => 'The message field is required.',
            'message.max' => 'The message may not be greater than 5000 characters.',
            'sendType.required' => 'Please select a send type.',
            'sendType.in' => 'Invalid send type selected.',
            'selectedRoles.required_if' => 'Please select at least one role.',
            'selectedRoles.min' => 'Please select at least one role.',
            'selectedRoles.*.in' => 'Invalid role selected.',
            'selectedUserIds.required_if' => 'Please select at least one user.',
            'selectedUserIds.min' => 'Please select at least one user.',
            'selectedUserIds.*.exists' => 'One or more selected users do not exist.',
        ]);

        $schoolId = auth()->user()->school_id;
        $senderId = auth()->id();

        $notification = $notificationService->sendNotification(
            schoolId: $schoolId,
            senderId: $senderId,
            title: $this->title,
            message: $this->message,
            type: $this->sendType,
            roles: $this->sendType === 'role' ? $this->selectedRoles : null,
            userIds: $this->sendType === 'user' ? $this->selectedUserIds : null,
            url: $this->url,
            templateId: $this->notificationTemplateId,
            sendEmail: $this->sendEmail
        );

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Notification sent successfully to {$notification->total_recipients} recipient(s)!",
        ]);

        return $this->redirect(route('school-admin.notification.index'), navigate: true);
    }

    public function getUsersProperty()
    {
        if (empty($this->userSearch)) {
            return collect();
        }

        $schoolId = auth()->user()->school_id;

        return User::where('school_id', $schoolId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->userSearch.'%')
                    ->orWhere('email', 'like', '%'.$this->userSearch.'%')
                    ->orWhere('first_name', 'like', '%'.$this->userSearch.'%')
                    ->orWhere('last_name', 'like', '%'.$this->userSearch.'%')
                    ->orWhere('admission_number', 'like', '%'.$this->userSearch.'%')
                    ->orWhere('employee_id', 'like', '%'.$this->userSearch.'%');
            })
            ->limit(20)
            ->get();
    }

    public function addUser(int $userId): void
    {
        if (! in_array($userId, $this->selectedUserIds)) {
            $this->selectedUserIds[] = $userId;
        }
        $this->userSearch = '';
    }

    public function removeUser(int $userId): void
    {
        $this->selectedUserIds = array_values(array_filter($this->selectedUserIds, fn ($id) => $id !== $userId));
    }

    public function render(): View
    {
        $schoolId = auth()->user()->school_id;
        $selectedUsers = User::whereIn('id', $this->selectedUserIds)->get();
        $templates = NotificationTemplate::where('school_id', $schoolId)
            ->where('is_active', true)
            ->get();

        return view('livewire.school-admin.send-notification', [
            'availableRoles' => $this->availableRoles,
            'users' => $this->users,
            'selectedUsers' => $selectedUsers,
            'templates' => $templates,
        ]);
    }
}
