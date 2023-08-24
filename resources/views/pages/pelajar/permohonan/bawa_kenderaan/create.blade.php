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
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kenderaan', 'Jenis Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jenis_kenderaan', ['K' => 'Kereta', 'M' => 'Motorsikal'],$model->jenis_kenderaan ?? old('jenis_kenderaan') , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('jenis_kenderaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenama', 'Jenama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('jenama', $model->jenama ?? old('jenama'),['class' => 'form-control form-control-sm '.($errors->has('jenama') ? 'is-invalid':''), 'id' =>'jenama','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('jenama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('model', 'Model', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('model', $model->model ?? old('model'),['class' => 'form-control form-control-sm '.($errors->has('model') ? 'is-invalid':''), 'id' =>'model','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('warna', 'Warna', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('warna', $model->warna ?? old('warna'),['class' => 'form-control form-control-sm '.($errors->has('warna') ? 'is-invalid':''), 'id' =>'warna','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('warna') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_pendaftaran', 'No Pendaftaran Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_pendaftaran', $model->no_pendaftaran ?? old('no_pendaftaran'),['class' => 'form-control form-control-sm '.($errors->has('no_pendaftaran') ? 'is-invalid':''), 'id' =>'no_pendaftaran','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('no_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat_cukai_kenderaan', 'Tarikh Tamat Cukai Jalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_tamat_cukai_kenderaan', old('tarikh_tamat_cukai_kenderaan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_tamat_cukai_kenderaan') ? 'is-invalid':''), 'id' =>'tarikh_tamat_cukai_kenderaan','onkeydown' =>'return false','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('tarikh_tamat_cukai_kenderaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat_lesen_memandu', 'Tarikh Tamat Lesen Memandu', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_tamat_lesen_memandu', old('tarikh_tamat_lesen_memandu'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_tamat_lesen_memandu') ? 'is-invalid':''), 'id' =>'tarikh_tamat_lesen_memandu','onkeydown' =>'return false','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('tarikh_tamat_lesen_memandu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab', 'Sebab Permohonan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('sebab', $model->sebab ?? old('sebab'),['class' => 'form-control form-control-sm '.($errors->has('sebab') ? 'is-invalid':''), 'id' =>'sebab','autocomplete' => 'off', 'rows'=>'4']) }}
                                        @error('sebab') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_depan_upload', 'Gambar Hadapan Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="gambar_depan_upload" id="gambar_depan_upload" required>
                                        @error('gambar_depan_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_belakang_upload', 'Gambar Belakang Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="gambar_belakang_upload" id="gambar_belakang_upload" required>
                                        @error('gambar_belakang_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('salinan_kad_matrik_upload', 'Salinan Kad Matrik', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="salinan_kad_matrik_upload" id="salinan_kad_matrik_upload" required>
                                        @error('salinan_kad_matrik_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('salinan_lesen_upload', 'Salinan Lesen Memandu', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="salinan_lesen_upload" id="salinan_lesen_upload" required>
                                        @error('salinan_lesen_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('salinan_geran_upload', 'Salinan Geran Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="salinan_geran_upload" id="salinan_geran_upload" required>
                                        @error('salinan_geran_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('salinan_surat_kebenaran_pemilik_upload', 'Salinan Surat Kebenaran Pemilik', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="salinan_surat_kebenaran_pemilik_upload" id="salinan_surat_kebenaran_pemilik_upload">
                                        @error('salinan_surat_kebenaran_pemilik_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
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


    $("#tarikh_tamat_lesen_memandu").daterangepicker({
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
        $("#tarikh_tamat_lesen_memandu").val(datePicked);
    });

    $("#tarikh_tamat_cukai_kenderaan").daterangepicker({
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
        $("#tarikh_tamat_cukai_kenderaan").val(datePicked);
    });
</script>

@endpush
