@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Laman Utama
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-md-5">
                <!--begin::Col-->
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-6">
                    <!--begin::Card widget 20-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body pt-9 pb-0">
                            <!--begin::Details-->
                            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                                <!--begin: Pic-->
                                <div class="me-7 mb-4">
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                        <img src="assets/media/avatars/300-1.jpg" alt="image">
                                    </div>
                                </div>
                                <!--end::Pic-->
                                <!--begin::Info-->
                                <div class="flex-grow-1">
                                    <!--begin::Title-->
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                        <!--begin::User-->
                                        <div class="d-flex flex-column">
                                            <!--begin::Name-->
                                            <div class="d-flex align-items-center mb-2">
                                                <a href="#"
                                                    class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">@if ($user->staff){{ $user->staff->nama }}@endif
                                                </a>
                                                <a href="#">
                                                </a>
                                            </div>
                                            <!--end::Name-->
                                            <!--begin::Info-->
                                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                <a href="#"
                                                    class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z"
                                                                fill="currentColor" />
                                                            <rect x="7" y="6" width="4"
                                                                height="4" rx="2" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    @hasallroles('kakitangan|alumni')
                                                        Kakitangan
                                                    @else
                                                        @role('kakitangan')
                                                            Kakitangan
                                                            @endrole @role('alumni')
                                                            Alumni
                                                            @endrole @role('pelajar')
                                                            Pelajar
                                                        @endrole
                                                    @endhasallroles
                                                </a>
                                                <a href="#"
                                                    class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    @if ($user->staff != NULL && $user->staff->pusatPengajian != NULL){{ $user->staff->pusatPengajian->nama }}@endif

                                                </a>
                                                <a href="#"
                                                    class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    @if ($user->staff){{ $user->staff->email }}@endif
                                                </a>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Actions-->
                                        <div class="d-flex my-4">
                                            <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_offer_a_deal">Tukar Kata Laluan</a>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 20-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-6">
                    <!--begin::Card widget 20-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                        style="background-color: #F1416C;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-content-around justify-content-evenly">
                            <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                <span class="fs-4hx text-white fw-bold me-6" id="showClock">
                                </span>
                                <br>
                                <div class="fw-bold fs-6 text-white">
                                    <span class="d-block my-date">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 20-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <div class="col-xxl-6">
                    <!--begin::Engage widget 10-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h3 class="fw-bold mb-1">Kalendar Akademik</h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column mb-9 p-9 pt-3">
                            <!--begin::Item-->
                            <div id="kt_docs_fullcalendar_basic"></div>

                            <!--end::Item-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Engage widget 10-->
                </div>
                <div class="col-xxl-6">
                    <!--begin::Engage widget 10-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h3 class="fw-bold mb-1">Hebahan Aktiviti</h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column mb-9 p-9 pt-3">
                            <!--begin::Item-->
                            @foreach ($hebahan_aktiviti as $aktiviti)
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-primary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Checkbox-->
                                <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                                    {{-- <input class="form-check-input" type="checkbox" value="" /> --}}

                                </div>
                                <!--end::Checkbox-->
                                <!--begin::Details-->
                                <div class="fw-semibold">
                                    <span class="fs-6 fw-bold text-primary">{{ $aktiviti->nama_program }}</span>
                                    <!--begin::Info-->
                                    <div class="text-gray-500">{{ \Carbon\Carbon::parse($aktiviti->tarikh_program)->format('d/m/Y') }}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                                <!--begin::Menu-->
                                {{-- <button type="button" class="btn btn-primary btn-sm ms-auto hover-scale" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Lanjut</button> --}}
                                <!--end::Menu-->
                            </div>
                            @endforeach

                            <!--end::Item-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Engage widget 10-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            clockUpdate();
            setInterval(clockUpdate, 1000);
        })

        function clockUpdate() {
            var date = new Date();

            function addZero(x) {
                if (x < 10) {
                    return x = '0' + x;
                } else {
                    return x;
                }
            }

            function twelveHour(x) {
                if (x > 12) {
                    return x = x - 12;
                } else if (x == 0) {
                    return x = 12;
                } else {
                    return x;
                }
            }

            function ampm(x) {
                if (x > 12) {
                    return x = 'PM';
                } else if (x == 0) {
                    return x = 12;
                } else {
                    return x;
                }
            }

            var h = addZero(twelveHour(date.getHours()));
            var m = addZero(date.getMinutes());
            var s = addZero(date.getSeconds());
            var ampm = (date.getHours() >= 12) ? "PM" : "AM";


            // $('#showClock').html('<span class="fs-4hx text-white fw-bold me-6">' + h + ':' + m + ':' + s + '<small class="fs-4">' + ampm +'</small></span>')
            $('#showClock').html('<span class="fs-4hx text-white fw-bold me-6">' + h + ':' + m + '<small class="fs-4">' +
                ampm + '</small></span>')
            $('#ampm').text(ampm)

            $('.my-date').hijriDate({
                showWeekDay: true,
                showGregDate: true,
                separator: '&nbsp;|&nbsp;',
                weekDayLang: 'en',
                hijriLang: 'en',
                gregLang: 'en',
            });
        }


    </script>
    <script>
        const element = document.getElementById("kt_docs_fullcalendar_basic");

        var todayDate = moment().startOf("day");
        var YM = todayDate.format("YYYY-MM");
        var YESTERDAY = todayDate.clone().subtract(1, "day").format("YYYY-MM-DD");
        var TODAY = todayDate.format("YYYY-MM-DD");
        var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

        var calendarEl = document.getElementById("kt_docs_fullcalendar_basic");
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth"
            },

            // height: 500,
            // withd: 500,
            // contentHeight: 480,
            aspectRatio: 1,  // see: https://fullcalendar.io/docs/aspectRatio

            nowIndicator: true,
            now: TODAY + "T09:25:00", // just for demo

            views: {
                dayGridMonth: { buttonText: "month" },
            },

            initialView: "dayGridMonth",
            initialDate: TODAY,

            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events
            navLinks: true,
            events: [],
        });

        calendar.render();
    </script>
@endsection
