@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Select an option',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'id' => null,
])

@php
    $id = $id ?? $name;
    $selectedValue = $value ?? old($name);
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
        name="{{ $name }}"
        id="{{ $id }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="{{ trim($selectClass) }}"
        {{ $attributes->except(['class', 'name', 'id', 'required', 'disabled', 'label', 'options', 'value', 'placeholder']) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $selectedValue == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

