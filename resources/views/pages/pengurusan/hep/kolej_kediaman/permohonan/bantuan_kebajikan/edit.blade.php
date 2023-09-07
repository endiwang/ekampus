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
                            @method('PUT')
                            @csrf
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'No Rujukan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->no_rujukan}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'Pemohon :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->pelajar->nama}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'No Matrik :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->pelajar->no_matrik}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'No Ic :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->pelajar->no_ic}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'Jenis Penyakit :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">

                                        <p class="mt-2">{{ $bantuan}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('', 'Lain-lain :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->lain_lain}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kad_pengenalan_upload', 'Salinan Kad Pengenalan (disahkan)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                @if(!empty($data->kad_pengenalan))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->kad_pengenalan) }}"  target='_blank'>Lihat Salinan Kad Pengenalan</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sijil_kematian_upload', 'Salinan Sijil Kematian (disahkan)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->sijil_kematian))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->sijil_kematian) }}"  target='_blank'>Lihat Salinan Sijil Kematian</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('akuan_bank_upload', 'Salinan Akuan Bank (disahkan)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                @if(!empty($data->akaun_bank))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->akaun_bank) }}"  target='_blank'>Lihat Salinan Akaun Bank</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('akuan_bank_upload', 'Salinan Bukti Bayaran (resit asal)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                @if(!empty($data->bukti_bayaran))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->bukti_bayaran) }}"  target='_blank'>Lihat Salinan Bukti Bayaran</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row fv-row mt-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status Permohonan :', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status',['1' => 'Lulus', '2'=>'Di Tolak'], $data->status, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        @if($data->status_rawatan == 0)
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        @endif
                                        <a href="{{ route('pelajar.permohonan.bawa_barang.index') }}" class="btn btn-sm btn-light">Kembali</a>
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
