@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Select options',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'id' => null,
])

@php
    $id = $id ?? $name;
    $selectedValues = $value ?? old($name, []);
    if (!is_array($selectedValues)) {
        $selectedValues = [$selectedValues];
    }
    $hasError = $errors->has($name);
    $selectClass = 'form-select ' . ($hasError ? 'is-invalid' : '') . ' ' . $class;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select
        name="{{ $name }}[]"
        id="{{ $id }}"
        multiple
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="{{ trim($selectClass) }}"
        {{ $attributes->except(['class', 'name', 'id', 'required', 'disabled', 'label', 'options', 'value', 'placeholder']) }}
    >
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ in_array($optionValue, $selectedValues) ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if($placeholder)
        <small class="form-text text-muted">{{ $placeholder }}</small>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

