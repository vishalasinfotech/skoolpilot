<?php

namespace Tests\Feature\SchoolAdmin;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_admin_can_view_notification_page(): void
    {
        $school = School::factory()->create();
        $user = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('school-admin.notification.index'));

        $response->assertStatus(200);
        $response->assertViewIs('school-admin.notification.index');
    }

    public function test_school_admin_can_send_notification_by_role(): void
    {
        Notification::fake();

        $school = School::factory()->create();
        $admin = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school->id,
        ]);

        $teacher1 = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        $teacher2 = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'role' => 'student',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\SchoolAdmin\SendNotification::class)
            ->set('title', 'Test Notification')
            ->set('message', 'This is a test notification')
            ->set('sendType', 'role')
            ->set('selectedRoles', ['teacher'])
            ->call('sendNotification');

        Notification::assertSentTo([$teacher1, $teacher2], \App\Notifications\SchoolNotification::class);
        Notification::assertNotSentTo($student, \App\Notifications\SchoolNotification::class);
    }

    public function test_school_admin_can_send_notification_to_specific_users(): void
    {
        Notification::fake();

        $school = School::factory()->create();
        $admin = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school->id,
        ]);

        $user1 = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        $user2 = User::factory()->create([
            'role' => 'student',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        $user3 = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\SchoolAdmin\SendNotification::class)
            ->set('title', 'Test Notification')
            ->set('message', 'This is a test notification')
            ->set('sendType', 'user')
            ->set('selectedUserIds', [$user1->id, $user2->id])
            ->call('sendNotification');

        Notification::assertSentTo([$user1, $user2], \App\Notifications\SchoolNotification::class);
        Notification::assertNotSentTo($user3, \App\Notifications\SchoolNotification::class);
    }

    public function test_notification_requires_title_and_message(): void
    {
        $school = School::factory()->create();
        $admin = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school->id,
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\SchoolAdmin\SendNotification::class)
            ->set('title', '')
            ->set('message', '')
            ->set('sendType', 'role')
            ->set('selectedRoles', ['teacher'])
            ->call('sendNotification')
            ->assertHasErrors(['title', 'message']);
    }

    public function test_notification_requires_role_selection_when_sending_by_role(): void
    {
        $school = School::factory()->create();
        $admin = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school->id,
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\SchoolAdmin\SendNotification::class)
            ->set('title', 'Test Notification')
            ->set('message', 'This is a test notification')
            ->set('sendType', 'role')
            ->set('selectedRoles', [])
            ->call('sendNotification')
            ->assertHasErrors(['selectedRoles']);
    }

    public function test_notification_requires_user_selection_when_sending_to_users(): void
    {
        $school = School::factory()->create();
        $admin = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school->id,
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\SchoolAdmin\SendNotification::class)
            ->set('title', 'Test Notification')
            ->set('message', 'This is a test notification')
            ->set('sendType', 'user')
            ->set('selectedUserIds', [])
            ->call('sendNotification')
            ->assertHasErrors(['selectedUserIds']);
    }

    public function test_notification_only_sends_to_active_users_in_same_school(): void
    {
        Notification::fake();

        $school1 = School::factory()->create();
        $school2 = School::factory()->create();

        $admin = User::factory()->create([
            'role' => 'school-admin',
            'school_id' => $school1->id,
        ]);

        $activeTeacher = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school1->id,
            'is_active' => true,
        ]);

        $inactiveTeacher = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school1->id,
            'is_active' => false,
        ]);

        $otherSchoolTeacher = User::factory()->create([
            'role' => 'teacher',
            'school_id' => $school2->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($admin)
            ->test(\App\Livewire\SchoolAdmin\SendNotification::class)
            ->set('title', 'Test Notification')
            ->set('message', 'This is a test notification')
            ->set('sendType', 'role')
            ->set('selectedRoles', ['teacher'])
            ->call('sendNotification');

        Notification::assertSentTo($activeTeacher, \App\Notifications\SchoolNotification::class);
        Notification::assertNotSentTo($inactiveTeacher, \App\Notifications\SchoolNotification::class);
        Notification::assertNotSentTo($otherSchoolTeacher, \App\Notifications\SchoolNotification::class);
    }
}
