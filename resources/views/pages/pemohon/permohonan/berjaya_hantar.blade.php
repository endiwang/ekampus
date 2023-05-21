@extends('layouts.public.main_inner_pemohon')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                    <div class="col-xl-12">
                        <!--begin::Table widget 14-->
                        <div class="card">
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <div class="mb-10">
                                    <!--begin::Title-->
                                    <div class="fs-2 fw-bold text-gray-800 text-center mb-13">
                                    <span class="me-2">Maklumat Permohonan Anda Telah Berjaya Dihantar dan Disimpan </span> <br>
                                    <span class="me-2">Tarikh dan masa hantar : </span>
                                    <span class="position-relative d-inline-block text-danger">
                                        <span class="text-danger opacity-75-hover">{{ $tarikh_hantar }}</span>
                                        <!--begin::Separator-->
                                        <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                        <!--end::Separator-->
                                    </span>
                                </div>
                                    <!--end::Title-->
                                    <!--begin::Action-->
                                    <div class="text-center">
                                        <a href="#" class="btn btn-sm btn-primary fw-bold"><i class="fa fa-print"></i> Cetak Permohonan</a>
                                        <a href="#" class="btn btn-sm btn-success fw-bold"><i class="fa fa-download"></i> Muat Turun Permohonan</a>
                                    </div>
                                    <!--begin::Action-->
                                </div>
                            </div>

                            <!--end: Card Body-->
                        </div>
                        <!--end::Table widget 14-->
                    </div>
                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
