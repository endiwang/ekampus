@extends('layouts.public.main')

@section('content')
    <!--begin::How It Works Section-->
    {{-- <div class="mb-n10 mb-lg-n20">
        <!--begin::Container-->
        <div class="container">

        </div>
        <!--end::Container-->
    </div> --}}
    <!--end::How It Works Section-->
    <!--begin::How It Works Section-->
    <div class="mb-10 mb-lg-10 z-index-2 mt-10">
        <!--begin::Container-->
        <div class="container">
            <div class="row g-5 g-xl-8 justify-content-center">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <a href="{{ route('login_pemohon') }}" class="card card-xl-stretch mb-xl-8 card bg-light-primary shadow-sm">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <span class="fw-bold text-dark fs-4 mb-2 text-hover-primary">Log Masuk Pemohon</span>
                                <span class="fw-semibold text-muted fs-5">Pemohonan dan Semakan</span>
                            </div>
                            <img src="assets/media/svg/avatars/029-boy-11.svg" alt="" class="align-self-end h-100px">
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 2-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <a href="{{ route('login') }}" class="card card-xl-stretch mb-5 mb-xl-8 bg-light-primary shadow-sm">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <span class="fw-bold text-dark fs-4 mb-2 text-hover-primary">Log Masuk E-Kampus</span>
                                <span class="fw-semibold text-muted fs-5">Kakitangan, Pelajar dan Alumni</span>
                            </div>
                            <img src="assets/media/svg/avatars/004-boy-1.svg" alt="" class="align-self-end h-100px">
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 2-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::How It Works Section-->
@endsection
