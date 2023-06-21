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
                                    {{ Form::label('nama_projek', 'Nama Projek', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->project_name ?? null}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tajuk_tesis', 'Tajuk Tesis', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->project_title ?? null}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keterangan_dokumen', 'Keterangan Dokumen', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->document_description ?? null}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tesis', 'Fail Tesis/Projek Ilmiah', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a class="mt-2" href="{{ route('pelajar.pengurusan_ijazah.rekod_tesis.download', $data->id) }}" target='_blank'>{{ $model->file_name ?? 'View Document'}}</a>
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
                                        <p class="mt-2">Serahan Baru</p>
                                        @elseif($data->status == 2)
                                        <p class="mt-2">Dalam Proses</p>
                                        @elseif ($data->status == 3)
                                        <p class="mt-2">Lulus</p>
                                        @elseif ($data->status == 4)
                                        <p class="mt-2">Gagal</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('komen', 'Komen (Jika Ada)', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{!! $data->remarks ?? null !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('created_at', 'Tarikh Serahan', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-1">{{ Utils::formatDate($data->created_at) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <a href="{{ route('pelajar.pengurusan_ijazah.rekod_tesis.index') }}" class="btn btn-sm btn-light">Kembali</a>
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
