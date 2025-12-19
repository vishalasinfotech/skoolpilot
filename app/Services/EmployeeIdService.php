<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;

class EmployeeIdService
{
    /**
     * Generate a unique employee ID for the given school and role.
     */
    public function generate(int $schoolId, string $role): string
    {
        $prefix = $this->getPrefix($role);
        $counter = $this->getNextCounter($schoolId, $role);

        return $prefix.$schoolId.'-'.str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the prefix for the employee ID based on role.
     */
    protected function getPrefix(string $role): string
    {
        return match ($role) {
            'teacher' => 'TCH',
            'staff' => 'STF',
            default => 'EMP',
        };
    }

    /**
     * Get the next counter value for the school and role.
     */
    protected function getNextCounter(int $schoolId, string $role): int
    {
        $prefix = $this->getPrefix($role);
        $expectedPrefix = $prefix.$schoolId.'-';

        // Get all employee IDs for this school and role that match our format
        $existingIds = User::where('school_id', $schoolId)
            ->where('role', $role)
            ->whereNotNull('employee_id')
            ->where('employee_id', 'like', $expectedPrefix.'%')
            ->pluck('employee_id')
            ->toArray();

        if (empty($existingIds)) {
            return 1;
        }

        // Extract counters and find the maximum
        $counters = [];
        foreach ($existingIds as $id) {
            $parts = explode('-', $id);
            if (count($parts) >= 2) {
                $counter = (int) end($parts);
                if ($counter > 0) {
                    $counters[] = $counter;
                }
            }
        }

        if (empty($counters)) {
            return 1;
        }

        return max($counters) + 1;
    }

    /**
     * Check if auto-generate employee ID is enabled for the school.
     */
    public function isAutoGenerateEnabled(int $schoolId): bool
    {
        return filter_var(
            Setting::get('auto_generate_employee_id', false, $schoolId),
            FILTER_VALIDATE_BOOLEAN
        );
    }
}
