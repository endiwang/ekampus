<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../" />
    <title>Sistem Maklumat Pelajar Darul Quran</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords"
        content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    @include('layouts.master.css')
    @yield('css')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            <div id="kt_app_header" class="app-header" style="background-color:#7c192a;">

                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">

                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                            id="kt_app_sidebar_mobile_toggle">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="../../demo1/dist/index.html" class="d-lg-none">
                            <img alt="Logo" src="assets/media/logos/default-small.svg" class="h-30px" />
                        </a>
                    </div>

                    @include('layouts.master.header')

                </div>
            </div>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper" style="background-color: #eaedf7">
                <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
                    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                        <a href="../../demo1/dist/index.html">
                            <img alt="Logo" src="{{ URL::asset('assets/media/logos/logo-dq.png') }}"
                                class="app-sidebar-logo-default" />
                            <img alt="Logo" src="assets/media/logos/default-small.svg"
                                class="h-20px app-sidebar-logo-minimize" />
                        </a>
                        <div id="kt_app_sidebar_toggle"
                            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                            data-kt-toggle-name="app-sidebar-minimize">
                            <span class="svg-icon svg-icon-2 rotate-180">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.5"
                                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                        fill="currentColor" />
                                    <path
                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    @if (Request::routeIs('pengurusan.akademik.*'))
                        @include('layouts.master.sidebar.akademik')
                    @elseif(Request::routeIs('pengurusan.kakitangan.*'))
                        @include('layouts.master.sidebar.kakitangan')
                    @elseif(Request::routeIs('pengurusan.kbg.*'))
                        @include('layouts.master.sidebar.kbg')
                    @elseif(Request::routeIs('pengurusan.hep.*'))
                        @include('layouts.master.sidebar.hep')
                    @elseif(Request::routeIs('pengurusan.pentadbir_sistem.*'))
                        @include('layouts.master.sidebar.pentadbir_sistem')
                    @elseif(Request::routeIs('pelajar.*'))
                        @include('layouts.master.sidebar.pelajar')
                    @elseif(Request::routeIs('pengurusan.komunikasi_korporat.*'))
                        @include('layouts.master.sidebar.komunikasi_korporat')
                    @elseif(Request::routeIs('pengurusan.perpustakaan.*'))
                        @include('layouts.master.sidebar.perpustakaan')
                    @elseif(Request::routeIs('pengurusan.peperiksaan.*'))
                        @include('layouts.master.sidebar.peperiksaan')
                    @elseif(Request::routeIs('pengurusan.pembangunan.*'))
                        @include('layouts.master.sidebar.pembangunan')
                    @elseif(Request::routeIs('pengurusan.kewangan.*'))
                        @include('layouts.master.sidebar.kewangan')
                    {{-- sidebar menu --}}
                    @else
                        @include('layouts.master.sidebar.utama')
                    @endif

                </div>
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

                    <div class="d-flex flex-column flex-column-fluid">
                        @include('layouts.master.breadcrumbs')
                        @yield('content')
                    </div>
                    @include('layouts.master.footer')
                </div>
            </div>
        </div>
    </div>
    @include('layouts.master.script')
    @yield('script')
    @stack('scripts')


</body>

</html>
