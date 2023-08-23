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
                                    {{ Form::label('jenis_barang', 'Jenis Barang :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">@php
                                        if($data->jenis_barang == 'EN')
                                        {
                                            $jenis_barang = 'Elektronik';
                                        }elseif($data->jenis_barang == 'E')
                                        {
                                            $jenis_barang =  'Elektrik';
                                        }else{
                                            $jenis_barang =  'Bukan Elektrik/Elektronik';
                                        }
                                    @endphp
                                        <p class="mt-2">{{ $jenis_barang}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenama', 'Jenama :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->jenama}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('model', 'Model :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->model}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kuasa', 'Kuasa :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->kuasa}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('warna', 'Warna :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->warna}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab', 'Sebab Permohonan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->sebab}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Gambar Barang :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->gambar_barang))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->gambar_barang) }}"  target='_blank'>Lihat Gambar Barang</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sataus', 'Status Permohonan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        @if($data->status == 0)<span class="badge badge-primary mt-2">Permohonan Baru</span>
                                        @elseif ($data->status == 1) <span class="badge badge-success mt-2">Permohonan Lulus</span>
                                        @else <span class="badge badge-danger mt-2">Permohonan Di Tolak</span>@endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
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
