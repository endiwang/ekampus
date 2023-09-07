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
                                @csrf
                                @if ($data->id)
                                    @method('PUT')
                                @endif
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_pelajar', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ $data->pelajar->nama ?? null }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_kp', 'No Kad Pengenalan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ $data->pelajar->no_ic ?? null }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_matrik', 'No Matrik', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ $data->pelajar->no_matrik ?? null }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('program', 'Program Pengajian', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ $data->kursus->nama ?? null }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('syukbah', 'Syukbah', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ $data->syukbah->nama ?? null }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('sesi', 'Sesi', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ $data->sesi->nama ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_mohon', 'Tarikh Mohon', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="mt-2">{{ Utils::formatDate($data->created_at) ?? null }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Permohonan', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                    </div>

                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('status', $statuses, $data->status, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ', 'data-control' => 'select2']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit"
                                                class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.akademik.permohonan.penangguhan_pengajian.index') }}"
                                                class="btn btn-sm btn-light">Batal</a>
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
