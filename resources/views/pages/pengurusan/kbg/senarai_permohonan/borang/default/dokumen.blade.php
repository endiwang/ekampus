<div class="card shadow-none" id="formPermohonanB">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">B. SENARAI DOKUMEN</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <div class="row g-6 g-xl-9 mb-6 mb-xl-9">

        @if ($data->muatnaik_dokumen)
            @foreach ($data->muatnaik_dokumen as $dokumen)

            <div class="col-md-6 col-lg-4 col-xl-3">
                <!--begin::Card-->
                <div class="card h-100">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <!--begin::Name-->
                        <a href="{{ asset($dokumen->path)}}" class="text-gray-800 text-hover-primary d-flex flex-column" target="_blank">
                            <!--begin::Image-->
                            <div class="symbol symbol-60px mb-5">
                                <img src="{{ asset('assets/media/svg/files/doc.svg') }}" class="theme-light-show" alt="">
                            </div>
                            <!--end::Image-->
                            <!--begin::Title-->
                            <div class="fs-5 fw-bold mb-2">
                                @if ($dokumen->jenis_dokumen == 'mykad_passport')
                                    Salinan MyKad / Pasport
                                @elseif ($dokumen->jenis_dokumen == 'sijil_spm_setara')
                                    Salinan Sijil SPM
                                @elseif ($dokumen->jenis_dokumen == 'kad_oku')
                                    Salinan Kad OKU
                                @endif
                            </div>
                            <!--end::Title-->
                        </a>
                        <!--end::Name-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>

            @endforeach
        @endif
        </div>
    </div>
</div>
