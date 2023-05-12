@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                {{-- <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card-header cursor-pointer">
                        <h3 class="card-title m-0">Maklumat Proses Temuduga</h3>
                        <a href="../../demo1/dist/account/settings.html" class="btn btn-sm btn-primary align-self-center">Pinda Maklumat</a>
                    </div>
                    <div class="card-body p-9">
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Tajuk Borang Temuduga</label>
                            <div class="col-lg-8">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->tajuk_borang }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Program Pengajian</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Pilihan Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Pusat Pengajian / Pusat Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Tarikh Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Masa Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Nama Tempat Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Alamat Tempat Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Tarikh Cetakan Surat</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 fw-semibold text-muted">Ketua Temuduga</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800">{{ $proses_temuduga->kursus->nama }}</span>
                            </div>
                        </div>

                    </div>
                </div> --}}
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">{{ $page_title }}</h3>
                        {{-- <div class="card-toolbar">
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</a>
                        </div> --}}
                    </div>
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                    </div>

                    <div class="card-footer">
                        <div class="card-toolbar">
                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            <a href="https://www.darulquran.devx/pengurusan/akademik/guru_tasmik" class="btn btn-sm btn-light">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

{!! $dataTable->scripts() !!}

@endpush
