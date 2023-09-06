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
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('nama', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">
                                        {{ $model->pelajar->nama ?? null }} <br/>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_kp', 'No. K/P', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->pelajar->no_ic }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_matrik', 'No. Matrik', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->pelajar->no_matrik }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->subjek->nama }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('tarikh', 'Tarikh Kelas', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ \App\Helpers\Utils::formatDate($model->tarikh) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('masa', 'Masa', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ \App\Helpers\Utils::formatTime($model->masa) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('status', 'Status Kehadiran', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">
                                        @if($model->status == 'hadir')
                                            Hadir
                                        @elseif($model->status == 'tidak_hadir_tanpa_sebab')
                                            Tidak Hadir
                                        @elseif($model->status == 'tidak_hadir_dengan_kebenaran')
                                            Tidak Hadir Dengan Kebenaran
                                        @elseif($model->status == 'tidak_hadir_dengan_sebab')
                                            Tidak Hadir Dengan Sebab Cuti Sakit
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @if($model->status == 'tidak_hadir_dengan_kebenaran' || $model->status == 'tidak_hadir_dengan_sebab')
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('lampiran', 'Lampiran', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <a class="btn btn-sm btn-primary" href="{{ route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.download', $model->id) }}" target="_blank">Lampiran</a>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-9 offset-md-3">
                                <div class="d-flex">
                                    <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.show', $kelas_id) }}" class="btn btn-sm btn-light">Kembali</a>
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
