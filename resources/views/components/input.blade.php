@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'class' => '',
    'id' => null,
    'autocomplete' => null,
    'min' => null,
    'max' => null,
    'step' => null,
    'pattern' => null,
])

@php
    $id = $id ?? $name;
    $value = $value ?? old($name);
    $hasError = $errors->has($name);
    $inputClass = 'form-control ' . ($hasError ? 'is-invalid' : '') . ' ' . $class;
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

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        @if($step !== null) step="{{ $step }}" @endif
        @if($pattern) pattern="{{ $pattern }}" @endif
        class="{{ trim($inputClass) }}"
        {{ $attributes->except(['class', 'name', 'id', 'type', 'value', 'placeholder', 'required', 'readonly', 'disabled', 'autocomplete', 'min', 'max', 'step', 'pattern', 'label']) }}
    >

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

