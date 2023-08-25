@props(['label' => 'Label', 'key' => 'key', 'description' => '', 'info' => '', 'value' => null, 'checked' => false])

<div class="row mb-6">
    <div class="col-lg-4">
        {{ Form::label($key, $label, ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
        @if ($description)
            <div class="form-text mt-0">{{ $description }}</div>
        @endif
    </div>
    <div class="col-lg-8 fv-row">
        {{ Form::checkbox($key, $value, $checked, $attributes->merge(['class' => 'form-check-input'])->getAttributes()); }}
        @if ($info)
            <div class="form-text">{{ $info }}</div>
        @endif
        @error($key) <span class="text-danger">{{ $message }}</span> @enderror
    </div>
</div>
