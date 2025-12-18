@php
    $selectedPermissionIds = collect(old('permissions', $rolePermissions ?? []))
        ->map(fn ($id) => (int) $id)
        ->values()
        ->all();

    $knownOperations = [
        'view_any' => __('common.view_any') !== 'common.view_any' ? __('common.view_any') : 'View Any',
        'create' => __('common.create') !== 'common.create' ? __('common.create') : 'Create',
        'edit' => __('common.update') !== 'common.update' ? __('common.update') : 'Update',
        'delete' => __('common.delete') !== 'common.delete' ? __('common.delete') : 'Delete',
        'view' => __('common.view') !== 'common.view' ? __('common.view') : 'View',
    ];

    $operationOrder = array_keys($knownOperations);

    $parsePermission = function (string $name) use ($operationOrder): array {
        foreach ($operationOrder as $operation) {
            $prefix = $operation.'_';
            if (str_starts_with($name, $prefix)) {
                return [$operation, substr($name, strlen($prefix))];
            }
        }

        return ['other', 'other'];
    };

    $moduleLabel = function (string $module): string {
        if ($module === 'other') {
            return 'Other';
        }

        return str($module)->replace('_', ' ')->title()->toString();
    };

    $groups = collect($permissions)
        ->map(function ($permission) use ($parsePermission) {
            [$operation, $module] = $parsePermission($permission->name);

            return [
                'permission' => $permission,
                'operation' => $operation,
                'module' => $module,
            ];
        })
        ->groupBy('module')
        ->sortKeys()
        ->map(function ($items) use ($operationOrder) {
            return $items
                ->sort(function ($a, $b) use ($operationOrder) {
                    $aIndex = array_search($a['operation'], $operationOrder, true);
                    $bIndex = array_search($b['operation'], $operationOrder, true);

                    $aIndex = $aIndex === false ? 999 : $aIndex;
                    $bIndex = $bIndex === false ? 999 : $bIndex;

                    return $aIndex <=> $bIndex ?: strcmp($a['permission']->name, $b['permission']->name);
                })
                ->values();
        });
@endphp

<div class="d-flex align-items-center justify-content-between">
    <label class="form-label mb-0">
        {{ __('common.permissions') }}
        <span class="badge bg-light text-dark ms-2">
            Resources {{ $groups->count() }}
        </span>
    </label>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="select_all_permissions">
        <label class="form-check-label" for="select_all_permissions">
            {{ __('common.select_all') }}
        </label>
    </div>
</div>

<div class="mt-3 border rounded p-2">
    <div class="accordion" id="permissionAccordion">
        @forelse($groups as $moduleKey => $items)
            @php
                $moduleId = (string) str($moduleKey)->slug('_');
                $collapseId = "permission-group-collapse-{$moduleId}";
                $headingId = "permission-group-heading-{$moduleId}";
            @endphp

            <div class="accordion-item" data-permission-group="{{ $moduleId }}">
                <h2 class="accordion-header" id="{{ $headingId }}">
                    <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#{{ $collapseId }}" aria-expanded="true"
                        aria-controls="{{ $collapseId }}">
                        <div class="d-flex flex-column">
                            <span class="fw-semibold" data-permission-group-title="{{ $moduleId }}">
                                {{ $moduleLabel($moduleKey) }}
                            </span>
                            <small class="text-muted">{{ $moduleKey }}</small>
                        </div>
                    </button>
                </h2>

                <div id="{{ $collapseId }}" class="accordion-collapse collapse show"
                    aria-labelledby="{{ $headingId }}">
                    <div class="accordion-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small">&nbsp;</span>
                            <div class="form-check">
                                <input class="form-check-input permission-group-select-all" type="checkbox"
                                    id="select_all_{{ $moduleId }}" data-permission-group-select-all="{{ $moduleId }}">
                                <label class="form-check-label" for="select_all_{{ $moduleId }}">
                                    {{ __('common.select_all') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-4">
                            @foreach($items as $item)
                                @php
                                    $permission = $item['permission'];
                                    $operation = $item['operation'];
                                    $operationLabel = $knownOperations[$operation] ?? str($permission->name)->replace('_', ' ')->title()->toString();
                                    $isChecked = in_array($permission->id, $selectedPermissionIds, true);
                                @endphp

                                <div class="form-check">
                                    <input
                                        class="form-check-input permission-checkbox"
                                        type="checkbox"
                                        id="permission-{{ $permission->id }}"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        data-permission-group-item="{{ $moduleId }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                        {{ $operationLabel }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-muted p-2">
                {{ __('common.no_permissions_found') }}
            </div>
        @endforelse
    </div>
</div>

@error('permissions')
    <small class="text-danger d-block mt-2">{{ $message }}</small>
@enderror
@error('permissions.*')
    <small class="text-danger d-block mt-2">{{ $message }}</small>
@enderror

@push('scripts')
    <script>
        (function () {
            const globalSelectAll = document.getElementById('select_all_permissions');
            const permissionCheckboxes = Array.from(document.querySelectorAll('.permission-checkbox'));
            const groupSelectAllCheckboxes = Array.from(document.querySelectorAll('.permission-group-select-all'));

            if (!permissionCheckboxes.length) {
                return;
            }

            function setChecked(checkboxes, isChecked) {
                checkboxes.forEach((cb) => {
                    cb.checked = isChecked;
                });
            }

            function getGroupItems(groupId) {
                return permissionCheckboxes.filter((cb) => cb.dataset.permissionGroupItem === groupId);
            }

            function syncGroupSelectAll(groupId) {
                const groupItems = getGroupItems(groupId);
                const groupSelectAll = document.querySelector(`[data-permission-group-select-all="${groupId}"]`);

                if (!groupSelectAll || !groupItems.length) {
                    return;
                }

                groupSelectAll.checked = groupItems.every((cb) => cb.checked);
                groupSelectAll.indeterminate = !groupSelectAll.checked && groupItems.some((cb) => cb.checked);
            }

            function syncGlobalSelectAll() {
                if (!globalSelectAll) {
                    return;
                }

                globalSelectAll.checked = permissionCheckboxes.every((cb) => cb.checked);
                globalSelectAll.indeterminate = !globalSelectAll.checked && permissionCheckboxes.some((cb) => cb.checked);
            }

            // Initialize states
            groupSelectAllCheckboxes.forEach((cb) => {
                syncGroupSelectAll(cb.dataset.permissionGroupSelectAll);
            });
            syncGlobalSelectAll();

            if (globalSelectAll) {
                globalSelectAll.addEventListener('change', function () {
                    setChecked(permissionCheckboxes, globalSelectAll.checked);

                    groupSelectAllCheckboxes.forEach((cb) => {
                        cb.checked = globalSelectAll.checked;
                        cb.indeterminate = false;
                    });
                });
            }

            groupSelectAllCheckboxes.forEach((cb) => {
                cb.addEventListener('change', function () {
                    const groupId = cb.dataset.permissionGroupSelectAll;
                    const groupItems = getGroupItems(groupId);

                    setChecked(groupItems, cb.checked);
                    cb.indeterminate = false;

                    syncGlobalSelectAll();
                });
            });

            permissionCheckboxes.forEach((cb) => {
                cb.addEventListener('change', function () {
                    const groupId = cb.dataset.permissionGroupItem;
                    syncGroupSelectAll(groupId);
                    syncGlobalSelectAll();
                });
            });
        })();
    </script>
@endpush


