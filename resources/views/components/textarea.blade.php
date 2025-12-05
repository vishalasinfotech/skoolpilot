@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'rows' => 3,
    'class' => '',
    'id' => null,
])

@php
    $id = $id ?? $name;
    $value = $value ?? old($name);
    $hasError = $errors->has($name);
    $textareaClass = 'form-control ' . ($hasError ? 'is-invalid' : '') . ' ' . $class;
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

    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        class="{{ trim($textareaClass) }}"
        {{ $attributes->except(['class', 'name', 'id', 'rows', 'placeholder', 'required', 'readonly', 'disabled', 'label', 'value']) }}
    >{{ $value }}</textarea>

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

