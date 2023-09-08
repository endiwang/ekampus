@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page_title }}</h3>
                        </div>
                        <div class="card-body py-5">
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('program_pengajian', $kursus, $model->kursus_id, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tahun_pengajian', 'Tahun Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select name="tahun_pengajian" class="form-select form-select-sm select2" placeholder="Sila Pilih">
                                            @foreach ($tahun_pengajian as $tahun)
                                                <option value="{{$tahun}}" @if($model->sesi_pengajian == $tahun) selected @endif>{{ $tahun}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_semester', 'Nama Semester', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('nama_semester', $semesters, $model->semester_id, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        @error('nama_semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_sesi_semasa', 'Nama Sesi Semasa', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_sesi_semasa', $model->sesi ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'nama_sesi_semasa','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_sesi_semasa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_daftar_pelajar', 'Tarikh Daftar Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_daftar_pelajar', Carbon\Carbon::parse($model->tarikh_daftar)->format('d/m/Y') ?? old('tarikh_daftar_pelajar'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_daftar_pelajar') ? 'is-invalid':''), 'id' =>'tarikh_daftar_pelajar','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_daftar_pelajar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_kuliah', 'Tarikh Kuliah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula_kuliah', Carbon\Carbon::parse($model->tarikh_mula_kuliah)->format('d/m/Y') ?? old('mula_semakan_temuduga'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula_kuliah') ? 'is-invalid':''), 'id' =>'tarikh_mula_kuliah','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_mula_kuliah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-1 text-md-center">
                                    {{ Form::label('tarikh_akhir_kuliah', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_akhir_kuliah', Carbon\Carbon::parse($model->tarikh_akhir_kuliah)->format('d/m/Y') ?? old('tarikh_akhir_kuliah'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_akhir_kuliah') ? 'is-invalid':''), 'id' =>'tarikh_akhir_kuliah','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_akhir_kuliah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_daftar', 'Tarikh Daftar Kursus', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula_daftar', Carbon\Carbon::parse($model->tarikh_mula_daftar_kursus)->format('d/m/Y') ?? old('tarikh_mula_daftar'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula_daftar') ? 'is-invalid':''), 'id' =>'tarikh_mula_daftar','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_mula_daftar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-1 text-md-center">
                                    {{ Form::label('tarikh_akhir_daftar', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_akhir_daftar', Carbon\Carbon::parse($model->tarikh_akhir_daftar_kursus)->format('d/m/Y') ?? old('tarikh_akhir_daftar'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_akhir_daftar') ? 'is-invalid':''), 'id' =>'tarikh_akhir_daftar','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_akhir_daftar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_peperiksaan', 'Tarikh Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula_peperiksaan', Carbon\Carbon::parse($model->tarikh_mula_peperiksaan)->format('d/m/Y') ?? old('tarikh_mula_peperiksaan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula_peperiksaan') ? 'is-invalid':''), 'id' =>'tarikh_mula_peperiksaan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_mula_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-1 text-md-center">
                                    {{ Form::label('tarikh_akhir_peperiksaan', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_akhir_peperiksaan', Carbon\Carbon::parse($model->tarikh_akhir_peperiksaan)->format('d/m/Y') ?? old('tarikh_akhir_peperiksaan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_akhir_peperiksaan') ? 'is-invalid':''), 'id' =>'tarikh_akhir_peperiksaan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_akhir_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_keputusan_peperiksaan', 'Tarikh Keputusan Peperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_keputusan_peperiksaan',Carbon\Carbon::parse($model->tarikh_keputusan_peperiksaan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_keputusan_peperiksaan') ? 'is-invalid':''), 'id' =>'tarikh_keputusan_peperiksaan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_keputusan_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_keputusan_peperiksaan', 'Status Paparan Keputusan Peperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_1', 'Semester 1', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_1', $statuses, $model->status_keputusan, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_2', 'Semester 2', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_2', $statuses, $model->status_keputusan_2, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_3', 'Semester 3', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_3', $statuses, $model->status_keputusan_3, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_4', 'Semester 4', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_4', $statuses, $model->status_keputusan_4, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_5', 'Semester 5', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_5', $statuses, $model->status_keputusan_5, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_6', 'Semester 6', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_6', $statuses, $model->status_keputusan_6, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_7', 'Semester 7', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_7', $statuses, $model->status_keputusan_7, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-2 text-md-center">
                                            {{ Form::label('status_semester_8', 'Semester 8', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::select('status_semester_8', $statuses, $model->status_keputusan_8, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_keputusan_peperiksaan_ulangan', 'Status Keputusan Peperiksaan Ulangan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::select('status_keputusan_peperiksaan_ulangan', $statuses, $model->status_keputusan_ulangan, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::checkbox('status', '0', ($model->status == 0 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
                                            <span class="form-check-label fs-7 fw-semibold mt-2">
                                                Aktif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.semester.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')
<script>
$("#tarikh_daftar_pelajar").daterangepicker({
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
        $("#tarikh_daftar_pelajar").val(datePicked);
});
$("#tarikh_mula_kuliah").daterangepicker({
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
        $("#tarikh_mula_kuliah").val(datePicked);
});
$("#tarikh_akhir_kuliah").daterangepicker({
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
        $("#tarikh_akhir_kuliah").val(datePicked);
});
$("#tarikh_mula_daftar").daterangepicker({
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
        $("#tarikh_mula_daftar").val(datePicked);
});
$("#tarikh_akhir_daftar").daterangepicker({
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
        $("#tarikh_akhir_daftar").val(datePicked);
});
$("#tarikh_mula_pengguguran").daterangepicker({
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
        $("#tarikh_mula_pengguguran").val(datePicked);
});
$("#tarikh_akhir_pengguguran").daterangepicker({
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
        $("#tarikh_akhir_pengguguran").val(datePicked);
});
$("#tarikh_mula_peperiksaan").daterangepicker({
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
        $("#tarikh_mula_peperiksaan").val(datePicked);
});
$("#tarikh_akhir_peperiksaan").daterangepicker({
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
        $("#tarikh_akhir_peperiksaan").val(datePicked);
});
$("#tarikh_keputusan_peperiksaan").daterangepicker({
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
        $("#tarikh_keputusan_peperiksaan").val(datePicked);
});
</script>
@endpush