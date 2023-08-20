@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.store')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama',old('nama'),['class' => 'form-control form-control-sm '.($errors->has('nama') ? 'is-invalid':''), 'id' =>'nama','autocomplete' => 'off']) }}
                                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('siri', 'Siri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('siri',old('siri'),['class' => 'form-control form-control-sm '.($errors->has('siri') ? 'is-invalid':''), 'id' =>'siri','autocomplete' => 'off']) }}
                                            @error('siri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahun', 'Tahun', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tahun',old('tahun'),['class' => 'form-control form-control-sm '.($errors->has('tahun') ? 'is-invalid':''), 'id' =>'tahun','autocomplete' => 'off']) }}
                                            @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_fail_surat', 'No Fail Surat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_fail_surat',old('no_fail_surat'),['class' => 'form-control form-control-sm '.($errors->has('no_fail_surat') ? 'is-invalid':''), 'id' =>'no_fail_surat','autocomplete' => 'off']) }}
                                            @error('no_fail_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pusat_pengajian_id', 'Lokasi Majlis', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <select name="pusat_pengajian_id" class="form-select" data-control="select2" data-placeholder="Sila Pilih" data-allow-clear="true" data-hide-search="false" id="pusat_pengajian_id">
                                                @foreach ($lokasi_pusat_pengajian as $pusat_pengajian)
                                                    <option value="{{ $pusat_pengajian->id }}">{{ $pusat_pengajian->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('pusat_pengajian_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_surat_mula', 'Tarikh Surat dibuka', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_surat_mula',old('tarikh_surat_mula'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_surat_mula') ? 'is-invalid':''), 'id' =>'tarikh_surat_mula','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_surat_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tarikh_surat_akhir', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_surat_akhir',old('tarikh_surat_akhir'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_surat_akhir') ? 'is-invalid':''), 'id' =>'tarikh_surat_akhir','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_surat_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_majlis_mula', 'Tarikh Majlis dibuka', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_majlis_mula',old('tarikh_majlis_mula'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_majlis_mula') ? 'is-invalid':''), 'id' =>'tarikh_majlis_mula','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_majlis_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tarikh_majlis_akhir', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_majlis_akhir',old('tarikh_sutarikh_majlis_akhirrat_akhir'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_majlis_akhir') ? 'is-invalid':''), 'id' =>'tarikh_majlis_akhir','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_majlis_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('masa_majlis', 'Masa Majlis', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::time('masa_majlis', $model->masa_majlis ?? old('masa_majlis'),['class' => 'form-control form-control-sm '.($errors->has('masa_majlis') ? 'is-invalid':''), 'id' =>'masa_majlis','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
    
                                            @error('masa_majlis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('staff_id', 'Pegawai Untuk Dihubungi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('staff_id', $staffs, old('staff_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('staff_id') ? 'is-invalid':''),'id'=>'staff_id' ]) }}
                                            @error('staff_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_cetakan', 'Tarikh Cetakan Surat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_cetakan',old('tarikh_cetakan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_cetakan') ? 'is-invalid':''), 'id' =>'tarikh_cetakan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_cetakan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', 1, 0, ['class' => 'form-check-input h-25px w-60px mt-1']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Aktif
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Batal</a>
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
    //Tarikh Surat Picker Start
    $("#tarikh_surat_mula").daterangepicker({
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
        $("#tarikh_surat_mula").val(datePicked);
    });
    $("#tarikh_surat_akhir").daterangepicker({
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
            $("#tarikh_surat_akhir").val(datePicked);
    });
    //Tarikh Surat Picker End

    //Tarikh Majlis Picker Start
    $("#tarikh_majlis_mula").daterangepicker({
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
        $("#tarikh_majlis_mula").val(datePicked);
    });
    $("#tarikh_majlis_akhir").daterangepicker({
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
            $("#tarikh_majlis_akhir").val(datePicked);
    });
    //Tarikh Majlis Picker End

    //Tarikh Cetakan Picker Start
    $("#tarikh_cetakan").daterangepicker({
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
        $("#tarikh_cetakan").val(datePicked);
}); 
    //Tarikh Cetakan Picker End

</script>

@endpush
