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
                                    {{ Form::label('jenama', 'No Rujukan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->no_rujukan}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_barang', 'Jenis Barang :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        @php
                                            if($data->jenis_kenderaan == 'K')
                                            {
                                                $jenis_barang = 'Kereta';
                                            }elseif($data->jenis_kenderaan == 'M')
                                            {
                                                $jenis_barang =  'Motorsikal';
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
                                    {{ Form::label('sebab', 'No Pendaftaran :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->no_pendaftaran}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab', 'Tarikh Tamat Cukai Kenderaan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ \Carbon\Carbon::parse($data->tarikh_tamat_cukai)->format('d/m/Y')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab', 'Tarikh Tamat Lesen Memandu :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ \Carbon\Carbon::parse($data->tarikh_tamat_lesen)->format('d/m/Y')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab', 'Sebab Memohon :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $data->sebab}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Gambar Hadapan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->gambar_hadapan))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->gambar_hadapan) }}"  target='_blank'>Lihat Gambar Hadapan</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mt-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Gambar Belakang :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->gambar_belakang))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->gambar_belakang) }}"  target='_blank'>Lihat Gambar Belakang</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mt-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Salinan Kad Matrik :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->salinan_kad_matrik))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->salinan_kad_matrik) }}"  target='_blank'>Lihat Salinan Kad Matrik</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mt-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Salinan Lesen Memandu :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->salinan_lesen))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->salinan_lesen) }}"  target='_blank'>Lihat Salinan Lesen Memanduk</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mt-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Salinan Geran Kenderaan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->salinan_geran))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->salinan_geran) }}"  target='_blank'>Lihat Salinan Geran Kenderaan</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row fv-row mt-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar_barang_upload', 'Salinan Surat Kebenaran Pemilik :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                @if(!empty($data->salinan_surat_kebenaran_pemilik))
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a class="btn btn-info btn-sm me-3" href="{{ url('storage/'.$data->salinan_surat_kebenaran_pemilik) }}"  target='_blank'>Lihat Salinan Surat Kebenaran Pemilik</a>
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
    </div>
</div>
@endsection
