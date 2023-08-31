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
                        <h3 class="card-title">{{ $page_title }}</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @if($model->id) @method('PUT') @endif
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_program', 'Nama Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_program', $model->nama_program ?? old('nama_program'),['class' => 'form-control form-control-sm '.($errors->has('nama_program') ? 'is-invalid':''), 'id' =>'nama_program','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required' ]) }}
                                        @error('nama_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('maklumat_program', 'Keterangan Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('maklumat_program', $model->maklumat_program ?? old('maklumat_program'),['class' => 'form-control form-control-sm '.($errors->has('maklumat_program') ? 'is-invalid':''), 'id' =>'maklumat_program','autocomplete' => 'off', 'rows'=>'4', 'required' => 'required']) }}
                                        @error('maklumat_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('lokasi_program', 'Lokasi Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('lokasi_program', $model->lokasi_program ?? old('lokasi_program'),['class' => 'form-control form-control-sm '.($errors->has('lokasi_program') ? 'is-invalid':''), 'id' =>'lokasi_program','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required' ]) }}
                                        @error('lokasi_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_program', 'Tarikh Bermula', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula_program', $model->tarikh_mula ? Carbon\Carbon::parse($model->tarikh_mula)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula_program') ? 'is-invalid':''), 'id' =>'tarikh_mula_program','onkeydown' =>'return false','autocomplete' => 'off','required' => 'required']) }}
                                        @error('tarikh_mula_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_mula', 'Masa Bermula', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::time('masa_mula', $model->masa_mula ?? old('masa_mula'),['class' => 'form-control form-control-sm '.($errors->has('masa_mula') ? 'is-invalid':''), 'id' =>'masa_mula','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}

                                        @error('masa_rampmasa_mulaasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat_program', 'Tarikh Tamat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_tamat_program', $model->tarikh_tamat ? Carbon\Carbon::parse($model->tarikh_tamat)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_tamat_program') ? 'is-invalid':''), 'id' =>'tarikh_tamat_program','onkeydown' =>'return false','autocomplete' => 'off','required' => 'required']) }}
                                        @error('tarikh_tamat_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_tamat', 'Masa Tamat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::time('masa_tamat', $model->masa_tamat ?? old('masa_tamat'),['class' => 'form-control form-control-sm '.($errors->has('masa_tamat') ? 'is-invalid':''), 'id' =>'masa_tamat','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}

                                        @error('masa_tamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jumlah_sesi', 'Jumlah Sesi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('jumlah_sesi', $model->jumlah_sesi ?? old('jumlah_sesi'),['class' => 'form-control form-control-sm '.($errors->has('jumlah_sesi') ? 'is-invalid':''), 'id' =>'jumlah_sesi','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required', 'max' => '15']) }}
                                        @error('jumlah_sesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mt-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kehadiran', 'Kehadiran :', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jenis_kehadiran',['0' => 'Tidak Wajib', '1'=>'Wajib'], $model->status, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2','required' => 'required']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pelajar.permohonan.bawa_barang.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')
<script>
    tinymce.init({
        selector: 'textarea#tinymce',
        height: 400
    });

    $("#tarikh_mula_program").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_mula_program").val(datePicked);
    });
    $("#tarikh_tamat_program").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_tamat_program").val(datePicked);
    });
</script>

@endpush
