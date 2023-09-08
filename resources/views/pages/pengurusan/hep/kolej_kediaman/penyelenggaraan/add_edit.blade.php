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
                                    {{ Form::label('nama_kerja', 'Nama Kerja', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::text('nama_kerja', $model->nama_kerja ?? old('nama_kerja'),['class' => 'form-control form-control-sm '.($errors->has('nama_kerja') ? 'is-invalid':''), 'id' =>'nama_kerja','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('nama_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kategori', 'Kategori', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::select('kategori', ['R' => 'Rutin Penyelenggaran Berkala', 'A' =>  'Aduan Penyelenggaraan'], $model->kategori ?? old('kategori'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ','data-control'=>'select2', 'required' => 'required']) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('vendor_id', 'Vendor', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::select('vendor_id', $vendor, $model->vendor_id ?? old('vendor'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ','data-control'=>'select2', 'required' => 'required']) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if($model->id)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_aduan', 'Status Aduan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::select('status_aduan', [0 => 'Aduan baru', 1 => 'Buka', 2 => 'Tutup'], $model->status_aduan ?? old('status_aduan'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ','data-control'=>'select2', 'required' => 'required']) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
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
                                    {{ Form::label('keputusan_aduan', 'Keputusan Kerja', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::select('keputusan_aduan', [0 => 'Belum Selesai', 1 => 'Cemerlang', 2 => 'Memuaskan', 3 => 'Tidak Memuaskan', 4 => 'Perlu Diperbaikai'], $model->keputusan_aduan ?? old('keputusan_aduan'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ','data-control'=>'select2', 'required' => 'required']) }}
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
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('komen', 'Komen', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::textarea('komen',$model->komen ?? old('komen'),['class' => 'form-control form-control-sm form-control', 'rows'=>'4', 'id' =>'komen']) }}
                                        </label>
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
                                        <a href="{{ route('pengurusan.kolej_kediaman.takwim_tahunan.index') }}" class="btn btn-sm btn-light">Batal</a>
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
