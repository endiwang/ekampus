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
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->nama ?? null }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('created_at', 'Tarikh Permohonan Dihantar', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ Utils::formatDate($data->created_at) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('laporan_polis', 'Dokumen Laporan Polis', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href="{{ route('alumni.permohonan.sijil_ganti.downloadFile', [$data->id, 'laporan_polis']) }}"
                                            class="btn btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip"
                                            target="_blank" title="Lihat Dokumen">
                                            Lihat Dokumen Sokongan
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('salinan_sijil', 'Dokumen Salinan Sijil', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>
                                @if ($data->salinan_sijil)
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a href="{{ route('alumni.permohonan.sijil_ganti.downloadFile', [$data->id, 'salinan_sijil']) }}"
                                                class="btn btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip"
                                                target="_blank" title="Lihat Dokumen">
                                                Lihat Dokumen Sokongan
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">Tidak disertakan</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kod_qr', 'Kod QR', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>
                                @if ($data->kod_qr)
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a href="{{ route('alumni.permohonan.sijil_ganti.downloadFile', [$data->id, 'kod_qr']) }}"
                                                class="btn btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip"
                                                target="_blank" title="Lihat Dokumen">
                                                Lihat Dokumen Sokongan
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">Tidak disertakan</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <form class="form" action="{{ $action }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="row fv-row mt-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Permohonan :', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>

                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('status', ['1' => 'Terima', '2' => 'Tolak'], $data->status, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ', 'data-control' => 'select2', 'required' => 'required']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit"
                                                class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('alumni.permohonan.sijil_ganti.index') }}"
                                                class="btn btn-sm btn-light">Kembali</a>
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
