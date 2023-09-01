@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('siri', 'Siri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('siri',$tetapan->siri,['class' => 'form-control form-control-sm '.($errors->has('siri') ? 'is-invalid':''), 'id' =>'siri','autocomplete' => 'off' , 'disabled'=> true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('lokasi', 'Lokasi Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <div class="row">
                                                <select name="lokasi[]" class="form-select" data-control="select2" data-placeholder="Sila Pilih" data-allow-clear="true" multiple="multiple" data-hide-search="false" disabled="true">
                                                    @foreach ($lokasi_peperiksaan as $lokasi)
                                                        <option value="{{ $lokasi->id }}" @if ($tetapan->lokasi_peperiksaan != NULL && in_array($lokasi->id, json_decode($tetapan->lokasi_peperiksaan))) @selected(true) @endif>{{ $lokasi->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_permohonan_dibuka', 'Tarikh Permohonan dibuka', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_permohonan_dibuka',date('d/m/Y', strtotime($tetapan->tarikh_permohonan_dibuka)),['class' => 'form-control form-control-sm '.($errors->has('tarikh_permohonan_dibuka') ? 'is-invalid':''), 'id' =>'tarikh_permohonan_dibuka','onkeydown' =>'return false','autocomplete' => 'off', 'disabled'=> true]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tarikh_permohonan_ditutup', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_permohonan_ditutup',date('d/m/Y', strtotime($tetapan->tarikh_permohonan_ditutup)),['class' => 'form-control form-control-sm '.($errors->has('tarikh_permohonan_ditutup') ? 'is-invalid':''), 'id' =>'tarikh_permohonan_ditutup','onkeydown' =>'return false','autocomplete' => 'off', 'disabled'=> true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Permohonan Ujian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', $tetapan->status, ($tetapan->status == 0 ? false:true), ['class' => 'form-check-input h-25px w-60px mt-1', 'disabled'=> true]); }}
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
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>

@endsection

@push('scripts')


@endpush
