@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body py-5">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                  
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="{{ route('pengurusan.kakitangan.kehadiran.kehadiran_pelajar.download_qr', $id) }}" class="btn btn-sm btn-primary fw-bold" title="Muat Turun Kehadiran">
                                        <i class="fa fa-circle-down" style="vertical-align: initial"></i>Muat Turun Qr
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center mt-5 mb-5">
                                {!! $qr_code !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center mt-5 mb-5">
                                    <p>Subjek : {{ $subjek->nama ?? null }}</p>
                                    <p style="font-size:10px;">Dijana Pada : {{ $generated_at ?? null }}</p>
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


