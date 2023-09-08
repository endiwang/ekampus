@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page_title }}</h3>
                        </div>
                        <div class="card-body py-5">
                            <form id="pengajian_form_edit" class="form" action="{{ $action }}" method="POST">
                                @if (isset($data))
                                    @method('PUT')
                                @endif
                                @csrf
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_institusi', 'Institusi', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_institusi', $data->nama_institusi ?? old('nama_institusi'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama_institusi') ? 'is-invalid' : ''), 'id' => 'nama_institusi', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required']) }}
                                            @error('nama_institusi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_mula', 'Tarikh mula', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::date('tarikh_mula', $data->tarikh_mula ?? old('tarikh_mula'), ['class' => 'form-control form-control-sm ' . ($errors->has('tarikh_mula') ? 'is-invalid' : ''), 'id' => 'tarikh_mula', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('tarikh_mula')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_tamat', 'Tarikh tamat', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::date('tarikh_tamat', $data->tarikh_tamat ?? old('tarikh_tamat'), ['class' => 'form-control form-control-sm ' . ($errors->has('tarikh_tamat') ? 'is-invalid' : ''), 'id' => 'tarikh_tamat', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('tarikh_tamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $peringkat_pengajian = [
                                        'asasi' => 'Asasi',
                                        'diploma' => 'Diploma',
                                        'ijazah' => 'Ijazah',
                                        'master' => 'Master',
                                        'phd' => 'PhD',
                                    ];
                                @endphp
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('peringkat_pengajian', 'Peringkat Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select(
                                                'peringkat_pengajian',
                                                $peringkat_pengajian,
                                                $data->peringkat_pengajian ?? old('peringkat_pengajian'),
                                                [
                                                    'placeholder' => 'Sila Pilih',
                                                    'class' =>
                                                        'form-contorl form-select form-select-sm ' . ($errors->has('peringkat_pengajian') ? 'is-invalid' : ''),
                                                    'id' => 'peringkat_pengajian',
                                                    'data-control' => 'select2',
                                                    'required' => 'required',
                                                ],
                                            ) }}
                                            @error('peringkat_pengajian')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajaan', 'Tajaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tajaan', $data->tajaan ?? old('tajaan'), ['class' => 'form-control form-control-sm ' . ($errors->has('tajaan') ? 'is-invalid' : ''), 'id' => 'tajaan', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('tajaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <a href="{{ url()->previous() }}"
                                                class="btn btn-secondary btn-sm fw-bold flex-shrink-0 mx-2">
                                                <i class="fa fa-xmark" style="vertical-align: initial"></i>Batal
                                            </a>
                                            <button id="pengajian_tambah_buton"
                                                class="btn btn-primary btn-sm fw-bold flex-shrink-0">
                                                <i class="fa fa-floppy-disk" style="vertical-align: initial"></i>
                                                @if (isset($data))
                                                    Kemaskini
                                                @else
                                                    Simpan
                                                @endif
                                            </button>
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
