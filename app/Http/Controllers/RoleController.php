<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdmin\Role\StoreRoleRequest;
use App\Http\Requests\SuperAdmin\Role\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('roles.index');
    }

    public function create(): View
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request, PermissionRegistrar $permissionRegistrar): RedirectResponse
    {
        $validated = $request->validated();
        $guardName = config('auth.defaults.guard');

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $guardName,
        ]);

        $permissions = Permission::query()
            ->whereIn('id', $validated['permissions'] ?? [])
            ->get();

        $role->syncPermissions($permissions);
        $permissionRegistrar->forgetCachedPermissions();

        return redirect()
            ->route('roles.index')
            ->with('success', __('common.role_created_successfully'));
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role, PermissionRegistrar $permissionRegistrar): RedirectResponse
    {
        $validated = $request->validated();

        $role->update([
            'name' => $validated['name'],
        ]);

        $permissions = Permission::query()
            ->whereIn('id', $validated['permissions'] ?? [])
            ->get();

        $role->syncPermissions($permissions);
        $permissionRegistrar->forgetCachedPermissions();

        return redirect()
            ->route('roles.index')
            ->with('success', __('common.role_updated_successfully'));
    }

    public function destroy(Role $role, PermissionRegistrar $permissionRegistrar): RedirectResponse
    {
        $protectedRoleNames = [
            'Super Admin',
            'School Admin',
            'Teacher',
            'Student',
            'Parent',
        ];

        if (in_array($role->name, $protectedRoleNames, true)) {
            return redirect()
                ->route('roles.index')
                ->with('error', __('common.cannot_delete_protected_role'));
        }

        $role->delete();
        $permissionRegistrar->forgetCachedPermissions();

        return redirect()
            ->route('roles.index')
            ->with('success', __('common.role_deleted_successfully'));
    }
}
