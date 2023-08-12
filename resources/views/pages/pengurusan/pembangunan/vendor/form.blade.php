@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Maklumat Vendor</h3>
                    </div>

                    <form class="form" action="{{ $action }}" method="post">
                        @if($model->id) @method('PUT') @endif
                        @csrf
                        <div class="card-body py-5">
                                                
                            <div class="row mb-2">
                                {{ Form::label('nama_syarikat', 'Nama Syarikat', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('nama_syarikat', $model->nama_syarikat ?? old('nama_syarikat'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama_syarikat') ? 'is-invalid':''), 'id' => 'nama_syarikat', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('nama_syarikat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('no_tel_syarikat', 'No Tel Syarikat', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                <div class="col-lg-8">
                                    {{ Form::number('no_tel_syarikat', $model->no_tel_syarikat ?? old('no_tel_syarikat'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_tel_syarikat') ? 'is-invalid':''), 'id' => 'no_tel_syarikat', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                    @error('no_tel_syarikat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('alamat', 'Alamat Syarikat', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                <div class="col-lg-8">
                                    {{ Form::textarea('alamat', $model->alamat, ['class' => 'form-control form-control-sm', 'rows'=>'4']) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Pengurus</h3>
                        </div> 

                        <div class="card-body py-5">
                                                
                            <div class="row mb-2">
                                {{ Form::label('nama_pengurus', 'Nama Pengurus', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('nama_pengurus', $model->nama_pengurus ?? old('nama_pengurus'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama_pengurus') ? 'is-invalid':''), 'id' => 'nama_pengurus', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('nama_pengurus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('no_tel_pengurus', 'No Tel', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    {{ Form::number('no_tel_pengurus', $model->no_tel_pengurus ?? old('no_tel_pengurus'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_tel_pengurus') ? 'is-invalid':''), 'id' => 'no_tel_pengurus', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('no_tel_pengurus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('emel_pengurus', 'Emel', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    {{ Form::email('emel_pengurus', $model->emel_pengurus ?? old('emel_pengurus'), ['class' => 'form-control form-control-sm ' . ($errors->has('emel_pengurus') ? 'is-invalid':''), 'id' => 'emel_pengurus', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    <span class="text-muted">Emel akan digunakan bagi pihak pengurusan vendor untuk login ke sistem. No telefon akan digunakan sebagai kata laluan.</span>
                                    @error('emel_pengurus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                <div class="col-lg-8 d-flex align-items-center">
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        {{ Form::checkbox('status', '1', $model->status, ['class' => 'form-check-input h-25px w-60px']); }}
                                        <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            <a href="{{ route('pengurusan.pembangunan.kemaskini.vendor.index') }}" class="btn btn-light btn-sm">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Row-->

    </div>
</div>


@endsection
@section('script')
@endsection

@push('scripts')

@endpush
