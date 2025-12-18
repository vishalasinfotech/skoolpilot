<?php

namespace Tests\Feature\SuperAdmin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_roles_index(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertStatus(200);
        $response->assertViewIs('roles.index');
        $response->assertSeeLivewire('super-admin.role-table');
    }

    public function test_non_super_admin_cannot_view_roles_index(): void
    {
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_role_with_permissions(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $permissionA = Permission::create(['name' => 'manage_schools']);
        $permissionB = Permission::create(['name' => 'manage_languages']);

        $payload = [
            'name' => 'Custom Role',
            'permissions' => [$permissionA->id, $permissionB->id],
        ];

        $response = $this->actingAs($user)->post(route('roles.store'), $payload);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('roles', [
            'name' => 'Custom Role',
        ]);

        $role = Role::query()->where('name', 'Custom Role')->firstOrFail();
        $this->assertDatabaseHas('role_has_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permissionA->id,
        ]);
        $this->assertDatabaseHas('role_has_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permissionB->id,
        ]);
    }

    public function test_super_admin_cannot_create_role_with_empty_name(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($user)->post(route('roles.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_super_admin_can_update_role_and_permissions(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $permissionA = Permission::create(['name' => 'manage_schools']);
        $permissionB = Permission::create(['name' => 'manage_languages']);

        $role = Role::create(['name' => 'Custom Role']);
        $role->syncPermissions([$permissionA]);

        $response = $this->actingAs($user)->put(route('roles.update', $role), [
            'name' => 'Custom Role Updated',
            'permissions' => [$permissionB->id],
        ]);

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Custom Role Updated',
        ]);

        $this->assertDatabaseMissing('role_has_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permissionA->id,
        ]);
        $this->assertDatabaseHas('role_has_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permissionB->id,
        ]);
    }
}
