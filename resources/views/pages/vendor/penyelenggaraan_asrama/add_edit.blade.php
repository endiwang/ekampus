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
                                    {{ Form::label('nama_kerja', 'Nama Kerja :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->nama_kerja}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kategori', 'Kategori :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            @php
                                                if($model->kategori == 'R')
                                                {
                                                    $kategori = 'Rutin Penyelenggaran Berkala';

                                                }elseif ($model->kategori == 'A') {
                                                    $kategori = 'Aduan Penyelenggaraan';
                                                }else{
                                                    $kategori = 'N\A';
                                                }
                                            @endphp
                                            <p class="mt-2">{{ $kategori}}</p>

                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kategori', 'Status Aduan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            @php
                                                if($model->status_aduan == '0')
                                                {
                                                    $status = 'Aduan Baru';

                                                }elseif ($model->status_aduan == '1') {
                                                    $status = 'Buka';
                                                }elseif ($model->status_aduan == '2') {
                                                    $status = 'Tutup';
                                                }else{
                                                    $status = 'N\A';
                                                }
                                            @endphp
                                            <p class="mt-2">{{ $status}}</p>

                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keputusan_aduan', 'Keputusan Kerja :', ['class' => 'fs-7 fw-semibold form-label mt-2 ']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            @php
                                                if ($model->keputusan_aduan == 0) {
                                                    $keputusan = 'Belum Disemak';
                                                }
                                                elseif ($model->keputusan_aduan == 1) {
                                                    $keputusan = 'Cemerlang';
                                                }
                                                elseif ($model->keputusan_aduan == 2) {
                                                    $keputusan = 'Memuaskan';
                                                }
                                                elseif ($model->keputusan_aduan == 3) {
                                                    $keputusan = 'Tidak Memuaskan';
                                                }
                                                elseif ($model->keputusan_aduan == 4) {
                                                    $keputusan = 'Perlu Diperbaikai';
                                                }
                                                else{
                                                    $kategori = 'N\A';
                                                }
                                            @endphp
                                            <p class="mt-2">{{ $keputusan}}</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_kerja', 'Komen :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->komen}}</p>
                                    </div>
                                </div>
                            </div>
                            @if($model->id)

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_kerja', 'Status Kerja', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::select('status_kerja', [0 => 'Belum Bermula', 1 => 'Sedang Dijalankan', 2 => 'Selesai'], $model->status_kerja ?? old('status_kerja'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ','data-control'=>'select2', 'required' => 'required']) }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_aduan', 'Tarikh Mula', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula_aduan', $model->tarikh_mula ? Carbon\Carbon::parse($model->tarikh_mula)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula_aduan') ? 'is-invalid':''), 'id' =>'tarikh_mula_aduan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_mula_aduan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_selesai_aduan', 'Tarikh Selesai', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_selesai_aduan', $model->tarikh_selesai ? Carbon\Carbon::parse($model->tarikh_selesai)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_selesai_aduan') ? 'is-invalid':''), 'id' =>'tarikh_selesai_aduan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_selesai_aduan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            @endif
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('vendor.penyelenggaraan_asrama.index') }}" class="btn btn-sm btn-light">Batal</a>
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
    $("#tarikh_mula_aduan").daterangepicker({
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
            $("#tarikh_mula_aduan").val(datePicked);
    });

    $("#tarikh_selesai_aduan").daterangepicker({
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
            $("#tarikh_selesai_aduan").val(datePicked);
    });
    </script>


@endpush
