@props(['label' => 'Label', 'key' => 'key', 'description' => '', 'info' => '', 'value' => '', 'wiredName' => ''])

<div class="row mb-6">
    <div class="col-lg-4">
        {{ Form::label($key, $label, ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0', 'wire:model.defer' => $wiredName]) }}
        @if ($description)
            <div class="form-text mt-0">{{ $description }}</div>
        @endif
    </div>
    <div class="col-lg-8 fv-row">
        {{ Form::text($key, $value, ['class' => 'form-control']) }}
        @if($info)
            <div class="form-text">{{ $info }}</div>
        @endif
    </div>
</div>
