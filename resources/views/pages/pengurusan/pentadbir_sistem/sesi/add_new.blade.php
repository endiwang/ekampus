@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sesi Pengajian</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Pentadbir Sistem</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Sesi Pengajian</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Tambah Sesi</li>

                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Sesi Pengajian</h3>
                        </div>
                        <div class="card-body py-5">
                            <form class="form" action="{{ route('pengurusan.pentadbir_sistem.sesi.store')}}" method="post">
                                @csrf
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahun_bermula', 'Tahun Bermula', ['class' => 'fs-6 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('tahun_bermula', $sesi_year_from, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select '.($errors->has('tahun_bermula') ? 'is-invalid':'') ]) }}
                                            @error('tahun_bermula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahun_berakhir', 'Tahun Berakhir', ['class' => 'fs-6 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('tahun_berakhir', $sesi_year_to, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select '.($errors->has('tahun_berakhir') ? 'is-invalid':'') ]) }}
                                            @error('tahun_berakhir') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kursus', 'Kursus', ['class' => 'fs-6 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('kursus', $kursus, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select '.($errors->has('kursus') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                            @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', '0', true, ['class' => 'form-check-input h-30px w-60px']); }}
                                                <span class="form-check-label fs-6 fw-semibold mt-2">
                                                    Aktif
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success me-3">
                                                <span class="indicator-label">Tambah</span>
                                            </button>
                                            <a href="{{ route('pengurusan.pentadbir_sistem.sesi.index') }}" class="btn btn-light">Batal</a>
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

@endpush
