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
                                    {{ Form::label('nama_pelaku', 'Nama Pelaku', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pelaku', $model->nama_pelaku ?? old('nama_pelaku'),['class' => 'form-control form-control-sm '.($errors->has('nama_pelaku') ? 'is-invalid':''), 'id' =>'nama_pelaku','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('nama_pelaku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_ic_pelaku', 'No Ic Pelaku ( Jika Ada )', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_ic_pelaku', $model->no_ic_pelaku ?? old('no_ic_pelaku'),['class' => 'form-control form-control-sm '.($errors->has('no_ic_pelaku') ? 'is-invalid':''), 'id' =>'no_ic_pelaku','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_ic_pelaku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_matrik_pelaku', 'No Matrik Pelaku ( Jika Ada )', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_matrik_pelaku', $model->no_matrik_pelaku ?? old('no_matrik_pelaku'),['class' => 'form-control form-control-sm '.($errors->has('no_matrik_pelaku') ? 'is-invalid':''), 'id' =>'no_matrik_pelaku','onkeydown' =>'return true','autocomplete' => 'off' ]) }}
                                        @error('no_matrik_pelaku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_kes', 'Tarikh Kes', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_kes',Carbon\Carbon::parse($model->tarikh_kes)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_kes') ? 'is-invalid':''), 'id' =>'tarikh_kes','onkeydown' =>'return false','autocomplete' => 'off','required' => 'required']) }}
                                        @error('tarikh_kes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_kes', 'Masa Kes', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::time('masa_kes', $model->masa_kes ?? old('masa_kes'),['class' => 'form-control form-control-sm '.($errors->has('masa_kes') ? 'is-invalid':''), 'id' =>'masa_kes','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}

                                        @error('masa_kes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tempat_kes', 'Tempat Kes', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tempat_kes', $model->tempat_kes ?? old('tempat_kes'),['class' => 'form-control form-control-sm '.($errors->has('tempat_kes') ? 'is-invalid':''), 'id' =>'tempat_kes','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('tempat_kes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_saksi', 'Nama Saksi ( Jika Ada )', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_saksi', $model->nama_saksi ?? old('nama_saksi'),['class' => 'form-control form-control-sm '.($errors->has('nama_saksi') ? 'is-invalid':''), 'id' =>'nama_saksi','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_saksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kesalahan', 'Jenis Kesalahan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jenis_kesalahan', $jenis_kesalahan,'' , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('jenis_kesalahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kesalahan_kolej_kediaman_id', 'Kesalahan Kolej Kediaman', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kesalahan_kolej_kediaman_id', $kesalahan_kolej_kediaman,'' , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('kesalahan_kolej_kediaman_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('aduan', 'Keterangan Aduan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('aduan','',['class' => 'form-control form-control-sm form-control', 'rows'=>'10', 'required' => 'required', 'id' =>'aduan']) }}
                                        @error('aduan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bukti_1', 'Bukti 1', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="bukti_1" id="bukti_1"  required>
                                        @error('bukti_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bukti_2', 'Bukti 2', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="bukti_2" id="bukti_2">
                                        @error('bukti_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bukti_3', 'Bukti 3', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="bukti_3" id="bukti_3">
                                        @error('bukti_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Hantar
                                        </button>
                                        <a href="{{ route('home') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->

        @if(!empty($model->id))
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header d-flex flex-row-reverse justify-content-between">
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#export" class="btn btn-icon btn-info btn-sm hover-elevate-up mt-5" title="Muat Turun Senarai Pelajar">
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="export" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Muat Turun Senarai Pelajar</h3>
                        <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <form class="form-horizontal" action="{{ route('pengurusan.akademik.pengurusan_kelas.export_by_class') }}" method="POST" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                        @csrf
                            <div class="modal-body">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('export_type', 'Jenis Muat Turun', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('export_type',
                                            [
                                                'pdf' => 'PDF',
                                                //'excel' => 'Excel'
                                            ],
                                            null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="class_id" value="{{ $model->id }}">
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex">
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                        Hantar
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#tarikh_kes").daterangepicker({
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
            $("#tarikh_kes").val(datePicked);
    });
    </script>


@endpush
