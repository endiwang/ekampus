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
                                    {{ Form::label('nama_pemilik', 'Nama Pemilik (Jika Ada)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pemilik', $model->nama_pemilik ?? old('nama_pemilik'),['class' => 'form-control form-control-sm '.($errors->has('nama_pemilik') ? 'is-invalid':''), 'id' =>'nama_pelaku','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_ic_pemilik', 'No Ic Pemilik ( Jika Ada )', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_ic_pemilik', $model->no_ic_pemilik ?? old('no_ic_pemilik'),['class' => 'form-control form-control-sm '.($errors->has('no_ic_pemilik') ? 'is-invalid':''), 'id' =>'no_ic_pemilik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_ic_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_matrik_pemilik', 'No Matrik Pemilik ( Jika Ada )', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_matrik_pemilik', $model->no_matrik_pemilik ?? old('no_matrik_pemilik'),['class' => 'form-control form-control-sm '.($errors->has('no_matrik_pemilik') ? 'is-invalid':''), 'id' =>'no_matrik_pemilik','onkeydown' =>'return true','autocomplete' => 'off' ]) }}
                                        @error('no_matrik_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_pelekat', 'No Pelekat (Jika Ada)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_pelekat', $model->no_pelekat ?? old('no_pelekat'),['class' => 'form-control form-control-sm '.($errors->has('no_pelekat') ? 'is-invalid':''), 'id' =>'no_pelekat','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_pelekat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kenderaan', 'Jenis Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jenis_kenderaan', ['K' => 'Kereta', 'M' => 'Motorsikal'], $model->jenis_kenderaan ?? old('jenis_kenderaan') , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
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
                                    {{ Form::label('model', 'Model', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('model', $model->model ?? old('model'),['class' => 'form-control form-control-sm '.($errors->has('model') ? 'is-invalid':''), 'id' =>'model','onkeydown' =>'return true','autocomplete' => 'off']) }}
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
                                    {{ Form::label('tarikh_sita_kenderaan', 'Tarikh Sitaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_sita_kenderaan', $model->tarikh_sita ? Carbon\Carbon::parse($model->tarikh_sita)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_sita_kenderaan') ? 'is-invalid':''), 'id' =>'tarikh_sita_kenderaan','onkeydown' =>'return false','autocomplete' => 'off','required' => 'required']) }}
                                        @error('tarikh_sita_kenderaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_sita', 'Masa Sitaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::time('masa_sita', $model->masa_sita ?? old('masa_sita'),['class' => 'form-control form-control-sm '.($errors->has('masa_rampasan') ? 'is-invalid':''), 'id' =>'masa_sita','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}

                                        @error('masa_sita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tempat_sita', 'Tempat Sitaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tempat_sita', $model->tempat_sita ?? old('tempat_sita'),['class' => 'form-control form-control-sm '.($errors->has('tempat_sita') ? 'is-invalid':''), 'id' =>'tempat_sita','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('tempat_sita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab_sita', 'Sebab Sitaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('sebab_sita', $model->sebab_sita ?? old('sebab_sita'),['class' => 'form-control form-control-sm '.($errors->has('sebab_sita') ? 'is-invalid':''), 'id' =>'sebab_sita','autocomplete' => 'off', 'rows'=>'4', 'required' => 'required']) }}
                                        @error('sebab_sita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('lampiran_sita_upload', 'Lampiran Sita', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="lampiran_sita_upload" id="lampiran_sita_upload">
                                        @error('lampiran_sita_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @if(!empty($model->lampiran_sita))
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$model->lampiran_sita) }}"  target='_blank'>Lihat Lampiran Sita</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!empty($model->id))
                            <div class="row fv-row mt-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status Kenderaan Sitaan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status',['0' => 'Tidak Dituntut', '1'=>'Dituntut'], $model->status, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2']) }}
                                    </div>
                                </div>
                            </div>
                            @endif

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

    $("#tarikh_sita_kenderaan").daterangepicker({
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
        $("#tarikh_sita_kenderaan").val(datePicked);
    });
</script>

@endpush
