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
                        <form class="form" action="" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenama', 'Nama Program :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->nama_program}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('maklumat_program', 'Keterangan Program :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->maklumat_program}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('lokasi_program', 'Lokasi Program :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->lokasi_program}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula_program', 'Tarikh Bermula :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{Carbon\Carbon::parse($model->tarikh_mula)->format('d/m/Y')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_mula', 'Masa Bermula :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        <p class="mt-2">{{$model->masa_mula}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat_program', 'Tarikh Tamat :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ Carbon\Carbon::parse($model->tarikh_tamat)->format('d/m/Y')}}</p>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_tamat', 'Masa Tamat :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{-- <input type="time" id="waktu_masuk" name="waktu_masuk" class="form-control form-control-sm"  value="@if ($model->waktu_masuk) {{$model->waktu_masuk}} @else {{old('waktu_masuk')}} @endif"> --}}
                                        <p class="mt-2">{{ $model->masa_tamat}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jumlah_sesi', 'Jumlah Sesi :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->jumlah_sesi}} Sesi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mt-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kehadiran', 'Kehadiran :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>

                                <div class="col-md-9 mt-2">
                                    <div class="w-100">
                                        <span class="badge badge-success">@if ($model->jenis_kehadiran == 1) Wajib @else Tidak Wajib @endif</span>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <a href="{{ route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar',$model->id) }}" class="btn btn-dark btn-sm me-3">
                                            <i class="fa fa-user-plus" style="vertical-align: initial"></i>Pilih Pelajar
                                        </a>
                                        <a href="{{ route('pengurusan.hep.pengurusan.program_pelajar.show_kehadiran',$model->id) }}" class="btn btn-info btn-sm me-3">
                                            <i class="fa fa-file" style="vertical-align: initial"></i>Kehadiran Pelajar
                                        </a>
                                        <a href="{{ route('pelajar.permohonan.bawa_kenderaan.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
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
