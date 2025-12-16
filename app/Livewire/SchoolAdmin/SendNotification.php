<?php

namespace App\Livewire\SchoolAdmin;

use App\Models\User;
use App\Notifications\SchoolNotification;
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

    public function sendNotification(): void
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
        $users = collect();

        if ($this->sendType === 'role') {
            $users = User::where('school_id', $schoolId)
                ->whereIn('role', $this->selectedRoles)
                ->where('is_active', true)
                ->get();
        } else {
            $users = User::where('school_id', $schoolId)
                ->whereIn('id', $this->selectedUserIds)
                ->where('is_active', true)
                ->get();
        }

        $notification = new SchoolNotification(
            title: $this->title,
            message: $this->message,
            url: $this->url
        );

        foreach ($users as $user) {
            $user->notify($notification);
        }

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Notification sent successfully to {$users->count()} user(s)!",
        ]);

        $this->reset(['title', 'message', 'url', 'selectedRoles', 'selectedUserIds', 'userSearch']);
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
        $selectedUsers = User::whereIn('id', $this->selectedUserIds)->get();

        return view('livewire.school-admin.send-notification', [
            'availableRoles' => $this->availableRoles,
            'users' => $this->users,
            'selectedUsers' => $selectedUsers,
        ]);
    }
}
