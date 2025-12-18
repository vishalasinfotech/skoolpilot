<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Components\DataTable;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleTable extends DataTable
{
    protected function getQuery()
    {
        return Role::query()
            ->withCount('permissions')
            ->with('permissions')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('guard_name', 'like', '%'.$this->search.'%')
                        ->orWhereHas('permissions', function ($p) {
                            $p->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function delete(int $id): void
    {
        $role = Role::query()->findOrFail($id);

        $protectedRoleNames = [
            'Super Admin',
            'School Admin',
            'Teacher',
            'Student',
            'Parent',
        ];

        if (in_array($role->name, $protectedRoleNames, true)) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => __('common.cannot_delete_protected_role'),
            ]);

            return;
        }

        $role->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => __('common.role_deleted_successfully'),
        ]);
    }

    public function openDeleteModal(int $id, string $name): void
    {
        $this->dispatch('openDeleteModal', [
            'roleId' => $id,
            'roleName' => $name,
        ]);
    }

    public function render(): View
    {
        $roles = $this->getQuery()->paginate($this->perPage);

        return view('livewire.super-admin.role-table', [
            'roles' => $roles,
        ]);
    }
}
