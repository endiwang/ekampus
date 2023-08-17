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
                            @method('PUT')
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_siasatan', 'Tarikh Mula Siasatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula_siasatan',$model->tarikh_mula_siasatan ? Carbon\Carbon::parse($model->tarikh_mula_siasatan)->format('d/m/Y') : old('tarikh_mula_siasatan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula_siasatan') ? 'is-invalid':''), 'id' =>'tarikh_mula_siasatan','onkeydown' =>'return false','autocomplete' => 'off','required' => 'required']) }}
                                        @error('tarikh_mula_siasatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_mula_siasatan', 'Masa Mula Siasatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::time('masa_mula_siasatan', $model->masa_mula_siasatan ?? old('masa_mula_siasatan'),['class' => 'form-control form-control-sm '.($errors->has('masa_mula_siasatan') ? 'is-invalid':''), 'id' =>'masa_mula_siasatan','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}

                                        @error('masa_mula_siasatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_akhir_siasatan', 'Tarikh Akhir Siasatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_akhir_siasatan',$model->tarikh_akhir_siasatan ? Carbon\Carbon::parse($model->tarikh_akhir_siasatan)->format('d/m/Y') : old('tarikh_akhir_siasatan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_akhir_siasatan') ? 'is-invalid':''), 'id' =>'tarikh_akhir_siasatan','onkeydown' =>'return false','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('tarikh_akhir_siasatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_akhir_siasatan', 'Masa Akhir Siasatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        {{ Form::time('masa_akhir_siasatan', $model->masa_akhir_siasatan ?? old('masa_akhir_siasatan'),['class' => 'form-control form-control-sm '.($errors->has('masa_akhir_siasatan') ? 'is-invalid':''), 'id' =>'masa_akhir_siasatan','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}

                                        @error('masa_akhir_siasatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tempat_siasatan', 'Tempat Siasatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tempat_siasatan',$model->tempat_siasatan ?? old('tempat_siasatan'),['class' => 'form-control form-control-sm '.($errors->has('tempat_siasatan') ? 'is-invalid':''), 'id' =>'tempat_siasatan','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('tempat_siasatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kategori_kesalahan', 'Kategori Kesalahan', ['class' => 'fs-7 fw-semibold required form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kategori_kesalahan', ['R' => 'Ringan', 'B' => 'Berat' ] , $model->kategori_kesalahan ?? old('kategori_kesalahan'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('kategori_kesalahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kesalahan', 'Jenis Kesalahan', ['class' => 'fs-7 fw-semibold required form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jenis_kesalahan',['U' => 'Kesalahan Umum', 'KK' => 'Kesalahan Hal-ehwal Kolej Kediaman'],$model->jenis_kesalahan ?? old('jenis_kesalahan'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('jenis_kesalahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('aduan', 'Keterangan Tertuduh', ['class' => 'fs-7 fw-semibold required required form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('keterangan_tertuduh',$model->keterangan_tertuduh ?? old('keterangan_tertuduh'),['class' => 'form-control form-control-sm form-control', 'rows'=>'10', 'required' => 'required', 'id' =>'aduan']) }}

                                        {{-- <textarea class="form-control" id="tinymce" name="sebab_mohon"></textarea> --}}
                                        @error('keterangan_tertuduh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keputusan_siasatan', 'Keputusan Siasatan', ['class' => 'fs-7 fw-semibold required form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('keputusan_siasatan', ['S' => 'Bersalah', 'TS' => 'Tidak Bersalah' ] , $model->keputusan_siasatan ?? old('keputusan_siasatan'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('keputusan_siasatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('dokumen_siasatan_1', 'Dokumen Siasatan 1', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="dokumen_siasatan_1" id="dokumen_siasatan_1">
                                        @error('dokumen_siasatan_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @if(!empty($model->dokument_siasatan))
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$model->dokument_siasatan) }}"  target='_blank'>Lihat Dokument Siasatan 1</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('dokumen_siasatan_2', 'Dokumen Siasatan 2', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="dokumen_siasatan_2" id="dokumen_siasatan_2">
                                        @error('dokumen_siasatan_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @if(!empty($model->dokument_siasatan_2))
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$model->dokument_siasatan_2) }}"  target='_blank'>Lihat Dokument Siasatan 2</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('dokumen_siasatan_3', 'Dokumen Siasatan 3', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="dokumen_siasatan_3" id="dokumen_siasatan_3">
                                        @error('dokumen_siasatan_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @if(!empty($model->dokument_siasatan_3))
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$model->dokument_siasatan_3) }}"  target='_blank'>Lihat Dokument Siasatan 3</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_aduan', 'Status Aduan', ['class' => 'fs-7 fw-semibold required form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status_aduan', ['1' => 'Dalam Siasatan', '2' => 'Siasatan Selesai' ] , $model->aduan->status ?? old('keputusan_siasatan'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('status_aduan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
        {{-- <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Kemaskini Maklumat Pelaku</h3>
                    </div>
                    <div class="card-body py-5">

                        <form class="form" action="{{ $action }}" method="post">
                            @if($model->id) @method('PUT') @endif
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pelaku_pelajar_id', 'Pelaku', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('pelaku_pelajar_id', $pelajar, $model->pelaku_pelajar_id ?? old('pelaku_pelajar_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('pelaku_pelajar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status', ['0' => 'Aduan Baru', '1' => 'Dalam Siasatan', '2' => 'Selesai'], $model->status ?? old('status'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Kemaskini
                                        </button>
                                        <a href="{{ route('home') }}" class="btn btn-sm btn-light">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#tarikh_mula_siasatan").daterangepicker({
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
            $("#tarikh_mula_siasatan").val(datePicked);
    });
    $("#tarikh_akhir_siasatan").daterangepicker({
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
            $("#tarikh_akhir_siasatan").val(datePicked);
    });
</script>


@endpush
