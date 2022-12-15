@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Tetapan Permohonan Pelajar</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Pentadbir Sistem</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Tetapan Permohonan Pelajar</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Pinda Tetapan</li>

                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pentadbir_sistem.permohonan_pelajar.store')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kursus', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('kursus', $kursus, $tetapan_permohonan->kursus_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kursus') ? 'is-invalid':''), 'data-control'=>'select2','disabled' ]) }}
                                            @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('sesi', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('sesi', $sesi, $tetapan_permohonan->sesi_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('sesi') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                            @error('sesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status_ujian', 'Status Permohonan Ujian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status_ujian', '1', ($tetapan_permohonan->status_ujian == 1 ? true:false), ['class' => 'form-check-input h-25px w-60px mt-1']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Dibuka Untuk Ujian Dalaman
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Permohonan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', '1', ($tetapan_permohonan->status == 1 ? true:false), ['class' => 'form-check-input h-25px w-60px mt-1']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Dibuka Untuk Permohonan
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('mula_permohonan', 'Tarikh Mula Permohonan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('mula_permohonan',Carbon\Carbon::parse($tetapan_permohonan->mula_permohonan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('mula_permohonan') ? 'is-invalid':''), 'id' =>'mula_permohonan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('mula_permohonan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tutup_permohonan', 'Tarikh Tutup Permohonan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tutup_permohonan',Carbon\Carbon::parse($tetapan_permohonan->tutup_permohonan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tutup_permohonan') ? 'is-invalid':''), 'id' =>'tutup_permohonan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tutup_permohonan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tutup_pendaftaran', 'Tarikh Tutup Pendaftaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tutup_pendaftaran',Carbon\Carbon::parse($tetapan_permohonan->tutup_pendaftaran)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tutup_pendaftaran') ? 'is-invalid':''), 'id' =>'tutup_pendaftaran','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tutup_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('mula_semakan_temuduga', 'Tarikh Semakan Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('mula_semakan_temuduga',Carbon\Carbon::parse($tetapan_permohonan->mula_semakan_temuduga)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('mula_semakan_temuduga') ? 'is-invalid':''), 'id' =>'mula_semakan_temuduga','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('mula_semakan_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tutup_semakan_temuduga', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tutup_semakan_temuduga',Carbon\Carbon::parse($tetapan_permohonan->tutup_semakan_temuduga)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tutup_semakan_temuduga') ? 'is-invalid':''), 'id' =>'tutup_semakan_temuduga','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tutup_semakan_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajuk_temuduga', 'Tajuk Semakan Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tajuk_temuduga',$tetapan_permohonan->tajuk_semakan_temuduga,['class' => 'form-control form-control-sm '.($errors->has('tajuk_temuduga') ? 'is-invalid':''), 'id' =>'tajuk_temuduga','autocomplete' => 'off']) }}
                                            @error('tajuk_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('maklumat_temuduga', 'Maklumat Semakan Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::textarea('maklumat_temuduga',$tetapan_permohonan->maklumat_semakan_temuduga,['class' => 'form-control form-control-sm '.($errors->has('maklumat_temuduga') ? 'is-invalid':''), 'id' =>'maklumat_temuduga', 'rows'=>'3']) }}
                                            @error('maklumat_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('mula_semakan_tawaran', 'Tarikh Semakan Tawaran Kemasukan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('mula_semakan_tawaran',Carbon\Carbon::parse($tetapan_permohonan->mula_semakan_tawaran)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('mula_semakan_tawaran') ? 'is-invalid':''), 'id' =>'mula_semakan_tawaran','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('mula_semakan_tawaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tutup_semakan_tawaran', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tutup_semakan_tawaran',Carbon\Carbon::parse($tetapan_permohonan->tutup_semakan_tawaran)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tutup_semakan_tawaran') ? 'is-invalid':''), 'id' =>'tutup_semakan_tawaran','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tutup_semakan_tawaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tutup_rayuan', 'Tarikh Akhir Rayuan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tutup_rayuan',Carbon\Carbon::parse($tetapan_permohonan->tutup_rayuan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tutup_rayuan') ? 'is-invalid':''), 'id' =>'tutup_rayuan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tutup_rayuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajuk_rayuan', 'Tajuk Semakan Rayuan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tajuk_rayuan',$tetapan_permohonan->tajuk_semakan_rayuan,['class' => 'form-control form-control-sm '.($errors->has('tajuk_rayuan') ? 'is-invalid':''), 'id' =>'tajuk_rayuan' ,'autocomplete' => 'off']) }}
                                            @error('tajuk_rayuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('mula_semakan_rayuan', 'Tarikh Semakan Rayuan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('mula_semakan_rayuan',Carbon\Carbon::parse($tetapan_permohonan->mula_semakan_rayuan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('mula_semakan_rayuan') ? 'is-invalid':''), 'id' =>'mula_semakan_rayuan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('mula_semakan_rayuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tutup_semakan_rayuan', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tutup_semakan_rayuan',Carbon\Carbon::parse($tetapan_permohonan->tutup_semakan_rayuan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tutup_semakan_rayuan') ? 'is-invalid':''), 'id' =>'tutup_semakan_rayuan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tutup_semakan_rayuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajuk_semakan_tawaran', 'Tajuk Semakan Tawaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tajuk_semakan_tawaran',$tetapan_permohonan->tajuk_semakan_tawaran,['class' => 'form-control form-control-sm '.($errors->has('tajuk_semakan_tawaran') ? 'is-invalid':''), 'id' =>'tajuk_semakan_tawaran','autocomplete' => 'off']) }}
                                            @error('tajuk_semakan_tawaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('maklumat_semakan_tawaran', 'Maklumat Semakan Tawaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::textarea('maklumat_semakan_tawaran',$tetapan_permohonan->maklumat_semakan_tawaran,['class' => 'form-control form-control-sm '.($errors->has('maklumat_semakan_tawaran') ? 'is-invalid':''), 'id' =>'maklumat_semakan_tawaran', 'rows'=>'3']) }}
                                            @error('maklumat_semakan_tawaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.pentadbir_sistem.permohonan_pelajar.index') }}" class="btn btn-light btn-sm">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>

@endsection

@push('scripts')
<script>
$("#mula_permohonan").daterangepicker({
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
        $("#mula_permohonan").val(datePicked);
});
$("#tutup_permohonan").daterangepicker({
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
        $("#tutup_permohonan").val(datePicked);
});
$("#tutup_pendaftaran").daterangepicker({
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
        $("#tutup_pendaftaran").val(datePicked);
});
$("#mula_semakan_temuduga").daterangepicker({
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
        $("#mula_semakan_temuduga").val(datePicked);
});
$("#tutup_semakan_temuduga").daterangepicker({
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
        $("#tutup_semakan_temuduga").val(datePicked);
});
$("#mula_semakan_tawaran").daterangepicker({
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
        $("#mula_semakan_tawaran").val(datePicked);
});
$("#tutup_semakan_tawaran").daterangepicker({
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
        $("#tutup_semakan_tawaran").val(datePicked);
});
$("#tutup_rayuan").daterangepicker({
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
        $("#tutup_rayuan").val(datePicked);
});
$("#mula_semakan_rayuan").daterangepicker({
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
        $("#mula_semakan_rayuan").val(datePicked);
});
$("#tutup_semakan_rayuan").daterangepicker({
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
        $("#tutup_semakan_rayuan").val(datePicked);
});
</script>

@endpush
