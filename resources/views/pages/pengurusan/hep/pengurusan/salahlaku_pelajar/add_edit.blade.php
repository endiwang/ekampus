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
                                        {{ Form::select('jenis_kesalahan', $jenis_kesalahan,$model->jenis_kesalahan ?? old('jenis_kesalahan'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
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
                                        {{ Form::select('kesalahan_kolej_kediaman_id', $kesalahan_kolej_kediaman, $model->kesalahan_kolej_kediaman_id ?? old('kesalahan_kolej_kediaman_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
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
                                        {{ Form::textarea('aduan',$model->aduan ?? old('aduan'),['class' => 'form-control form-control-sm form-control', 'rows'=>'10', 'required' => 'required', 'id' =>'aduan']) }}

                                        {{-- <textarea class="form-control" id="tinymce" name="sebab_mohon"></textarea> --}}
                                        @error('aduan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'Bukti', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-2">
                                    <div class="card">
                                        <!--begin::Card body-->
                                        <div class="card-body">
                                            <!--begin::Name-->
                                            <a href="{{ url('storage/'.$model->bukti) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                                <!--begin::Image-->
                                                <div class="symbol symbol-60px mb-5">
                                                    <img src="{{ asset('assets/media/svg/files/folder-document.svg') }}" class="theme-light-show" alt="">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Title-->
                                                <div class="fs-7 fw-bold mb-2">Bukti 1</div>
                                                <!--end::Title-->
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                </div>
                                @if ($model->bukti_2)
                                <div class="col-md-2">
                                    <div class="card">
                                        <!--begin::Card body-->
                                        <div class="card-body">
                                            <!--begin::Name-->
                                            <a href="{{ url('storage/'.$model->bukti_2) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                                <!--begin::Image-->
                                                <div class="symbol symbol-60px mb-5">
                                                    <img src="{{ asset('assets/media/svg/files/folder-document.svg') }}" class="theme-light-show" alt="">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Title-->
                                                <div class="fs-7 fw-bold mb-2">Bukti 2</div>
                                                <!--end::Title-->
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                </div>
                                @endif
                                @if ($model->bukti_3)
                                <div class="col-md-2">
                                    <div class="card">
                                        <!--begin::Card body-->
                                        <div class="card-body">
                                            <!--begin::Name-->
                                            <a href="{{ url('storage/'.$model->bukti_3) }}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                                                <!--begin::Image-->
                                                <div class="symbol symbol-60px mb-5">
                                                    <img src="{{ asset('assets/media/svg/files/folder-document.svg') }}" class="theme-light-show" alt="">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Title-->
                                                <div class="fs-7 fw-bold mb-2">Bukti 3</div>
                                                <!--end::Title-->
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                </div>
                                @endif
                            </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
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
        </div>

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
