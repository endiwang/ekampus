@extends('layouts.public.main_inner_pemohon')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                    <div class="col-xl-7">
                        <!--begin::Table widget 14-->
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Senarai Permohonan Yang Dibuka</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                                <th class="p-0 pb-3 min-w-175px text-start">KURSUS DAN INSTITUSI</th>
                                                <th class="p-0 pb-3 min-w-100px text-center">SESI</th>
                                                <th class="p-0 pb-3 min-w-100px text-center">TARIKH BUKA</th>
                                                <th class="p-0 pb-3 min-w-175px text-center">TARIKH TUTUP</th>
                                                <th class="p-0 pb-3 w-125px text-center">STATUS</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{-- <div class="symbol symbol-50px me-3">
                                                            <img src="assets/media/stock/600x600/img-49.jpg" class="" alt="" />
                                                        </div> --}}
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Diploma Tahfiz Al-Quran dan Al-Qiraat</a>
                                                            <span class="text-gray-400 fw-semibold d-block fs-7">Darul Quran JAKIM</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">SESI 2022/2025</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">28/12/2022</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">28/02/2023</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="badge py-3 px-4 fs-7 badge-light-success">Dibuka</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{-- <div class="symbol symbol-50px me-3">
                                                            <img src="assets/media/stock/600x600/img-49.jpg" class="" alt="" />
                                                        </div> --}}
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Diploma Tahfiz Al-Quran dan Al-Qiraat</a>
                                                            <span class="text-gray-400 fw-semibold d-block fs-7">Darul Quran JAKIM</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">SESI 2022/2025</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">28/12/2022</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">28/02/2023</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="badge py-3 px-4 fs-7 badge-light-danger">Ditutup</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Table widget 14-->
                    </div>
                    <div class="col-xl-5">
                        <!--begin::Timeline-->
                        <div class="card">
                            <!--begin::Card head-->
                            <div class="card-header card-header-stretch">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Aktiviti</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Card head-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <!--begin::Tab panel-->
                                    <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                        <!--begin::Timeline-->
                                        <div class="timeline">
                                            <!--begin::Timeline item-->
                                            <div class="timeline-item">
                                                <!--begin::Timeline line-->
                                                <div class="timeline-line w-40px"></div>
                                                <!--end::Timeline line-->
                                                <!--begin::Timeline icon-->
                                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                                    <div class="symbol-label bg-light-success">
                                                        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                                        <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor" />
                                                                <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </div>
                                                </div>
                                                <!--end::Timeline icon-->
                                                <!--begin::Timeline content-->
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <!--begin::Timeline heading-->
                                                    <div class="pe-3 mb-5">
                                                        <!--begin::Title-->
                                                        <div class="fs-5 fw-semibold mb-2">Permohonan Dihantar</div>
                                                        <!--end::Title-->
                                                        <!--begin::Description-->
                                                        <div class="d-flex align-items-center mt-1 fs-6">
                                                            <!--begin::Info-->
                                                            <div class="text-muted me-2 fs-7">20 Jan 2022</div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Description-->
                                                    </div>
                                                    <!--end::Timeline heading-->
                                                </div>
                                                <!--end::Timeline content-->
                                            </div>
                                            <!--end::Timeline item-->
                                            <div class="timeline-item">
                                                <!--begin::Timeline line-->
                                                <div class="timeline-line w-40px"></div>
                                                <!--end::Timeline line-->
                                                <!--begin::Timeline icon-->
                                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                                    <div class="symbol-label bg-light-success">
                                                        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                                        <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor" />
                                                                <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </div>
                                                </div>
                                                <!--end::Timeline icon-->
                                                <!--begin::Timeline content-->
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <!--begin::Timeline heading-->
                                                    <div class="pe-3 mb-5">
                                                        <!--begin::Title-->
                                                        <div class="fs-5 fw-semibold mb-2">Permohonan Dihantar</div>
                                                        <!--end::Title-->
                                                        <!--begin::Description-->
                                                        <div class="d-flex align-items-center mt-1 fs-6">
                                                            <!--begin::Info-->
                                                            <div class="text-muted me-2 fs-7">20 Jan 2022</div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Description-->
                                                    </div>
                                                    <!--end::Timeline heading-->
                                                </div>
                                                <!--end::Timeline content-->
                                            </div>
                                        </div>
                                        <!--end::Timeline-->

                                    </div>
                                    <!--end::Tab panel-->

                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Timeline-->
                    </div>
                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
