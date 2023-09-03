
@if($model->id) @method('PUT') @endif
@csrf
<div class="row mb-2">
    {{ Form::label('nama', 'Nama Yuran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
    <div class="col-lg-8">
        {{ Form::text('nama', $model->nama ?? old('nama'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama') ? 'is-invalid':''), 'id' => 'nama', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row mb-2">
    {{ Form::label('amaun', 'Amaun Yuran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
    <div class="col-lg-8">
        {{ Form::number('amaun', $model->amaun ?? old('amaun'), ['class' => 'form-control form-control-sm ' . ($errors->has('amaun') ? 'is-invalid':''), 'id' => 'amaun', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
        @error('amaun') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<input type="hidden" name="status" value="1">
<!-- <div class="row mb-0">
    {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
    <div class="col-lg-8 d-flex align-items-center">
        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
            {{ Form::checkbox('status', '1', $model->status, ['class' => 'form-check-input h-25px w-60px']); }}
            <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
        </div>
    </div>
</div> -->