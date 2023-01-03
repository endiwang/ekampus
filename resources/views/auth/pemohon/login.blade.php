@extends('layouts.public.main_inner')

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
            <div class="text-center mb-17">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">Permohonan</h3>
                <!--end::Title-->
            </div>
            <div class="row g-5 g-xl-8 justify-content-center">
                <div class="col-xl-6">
                    <div class="card card-flush shadow-sm">
                        <div class="card-body p-10 p-lg-20">
                            <!--begin::Form-->
                            <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('login_pemohon') }}">
                                @csrf
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <!--begin::Title-->
                                    <h1 class="text-dark fw-bolder mb-3">Log Masuk Pemohon</h1>
                                    <!--end::Title-->
                                    <!--begin::Subtitle-->
                                    <div class="text-gray-500 fw-semibold fs-6">Untuk permohonan, semakan dan rayuan</div>
                                    <!--end::Subtitle=-->
                                </div>
                                <!--begin::Heading-->
                                <!--begin::Input group=-->
                                <div class="fv-row mb-3 fv-plugins-icon-container">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="No. Kad Pengenalan" name="username" autocomplete="off" auto class="form-control bg-transparent form-control-sm">
                                    <!--end::Email-->
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                <!--end::Input group=-->
                                <div class="fv-row mb-8 fv-plugins-icon-container">
                                    <!--begin::Password-->
                                    <input type="password" placeholder="Katalaluan" name="password" autocomplete="off" class="form-control bg-transparent form-control-sm">
                                    <!--end::Password-->
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                <!--end::Input group=-->
                                <!--begin::Submit button-->
                                <div class="d-grid mb-3">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary btn-sm">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Log Masuk</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="button" id="kt_sign_in_submit" class="btn btn-success btn-sm">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Lupa Katalaluan?</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-flush shadow-sm">
                        <div class="card-body p-10 p-lg-20">
                            <!--begin::Form-->
                            <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="../../demo1/dist/index.html" action="#">
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <!--begin::Title-->
                                    <h1 class="text-dark fw-bolder mb-3">Pendaftaran Akaun Pemohon</h1>
                                    <!--end::Title-->
                                    <!--begin::Subtitle-->
                                    <div class="text-gray-500 fw-semibold fs-6">Untuk pemohon baru sahaja</div>
                                    <!--end::Subtitle=-->
                                </div>
                                <!--begin::Heading-->
                                <!--begin::Input group=-->
                                <div class="fv-row mb-3 fv-plugins-icon-container">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="No. Kad Pengenalan" name="no_ic" autocomplete="off" auto class="form-control bg-transparent form-control-sm">
                                    <!--end::Email-->
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                <!--end::Input group=-->
                                <div class="fv-row mb-8 fv-plugins-icon-container">
                                    <!--begin::Password-->
                                    <input type="email" placeholder="Emel yang sah" name="email" autocomplete="off" class="form-control bg-transparent form-control-sm">
                                    <!--end::Password-->
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                <!--end::Input group=-->
                                <!--begin::Submit button-->
                                <div class="d-grid mb-3">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary btn-sm">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Daftar</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <div class="d-grid mb-10">
                                    <div class="d-flex flex-column">
                                        <li class="d-flex align-items-start py-2"><span class="bullet bg-danger mt-2"></span>&nbsp Sila semak emel anda untuk mengesahkan pendaftaran.</li>
                                        <li class="d-flex align-items-start py-2"><span class="bullet bg-danger mt-2"></span>&nbsp Katalaluan akan dihantar melui emel selepas pengesahan<br>&nbsp pendaftaran dibuat.</li>
                                    </div>
                                </div>
                                <!--end::Submit button-->
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::How It Works Section-->
@endsection
