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
                                {{ Form::label('nama_pelajar', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->pelajar->nama ?? null}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_kp', 'No Kad Pengenalan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->pelajar->no_ic ?? null}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_matrik', 'No Matrik', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->pelajar->no_matrik ?? null}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('program', 'Program Pengajian', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->pelajar->kursus->nama ?? null}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('semester_now', 'Semester Terkini', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->semester->nama ?? null}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row fv-row mb-2">
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('sebab_penangguhan', 'Sebab Penangguhan', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>

                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-1">{!! $data->sebab_penangguhan ?? null !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row fv-row mb-2">
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('status_permohonan', 'Status Permohonan', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>

                            <div class="col-md-9">
                                <div class="w-100">
                                     @if($data->status == 1)
                                    <p class="mt-1">Baru Diterima</p>
                                    @elseif($data->status == 2)
                                    <p class="mt-1">Dalam Proses</p>
                                    @elseif ($data->status == 3)
                                    <p class="mt-1">Lulus</p>
                                    @elseif ($data->status == 4)
                                    <p class="mt-1">Tolak</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                        @if($data->status == 3)
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('surat_pelepasan', 'Muat Turun Surat Pelepasan', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <a href="{{ route('pelajar.permohonan.penangguhan_pengajian.download',$data->id) }}" class="btn btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
                                        Muat Turun Surat Kebenaran
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row mt-5">
                            <div class="col-md-9 offset-md-3">
                                <div class="d-flex">
                                    <a href="{{ route('pelajar.permohonan.penangguhan_pengajian.index') }}" class="btn btn-sm btn-light">Kembali</a>
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
