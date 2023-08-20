<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold fs-7" style="color: white !Important">Pengurusan Sijil Tahfiz Malaysia</span>
                </div>
            </div>
            
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ Request::routeIs('pengurusan.kbg.index') ? 'active' : '' }}" href="{{ route('pengurusan.kbg.index') }}" target="blank">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>

            <div data-kt-menu-trigger="click" class="menu-item {{ (request()->is('utama')) ? 'here show' : '' }} menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                            </svg>
                        </span>
                    </span>
                    <span class="menu-title">Tetapan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Sesi Peperiksaan Sijil Tahfiz</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.tetapan.pusat_peperiksaan_sijil_tahfiz.index') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.pusat_peperiksaan_sijil_tahfiz.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pusat Peperiksaan Sijil Tahfiz</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penemuduga Sijil Tahfiz</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.index') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Majlis Penyerahan Sijil</span>
                        </a>
                    </div>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.*') ? 'here show' : '' }} menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                            </svg>
                        </span>
                    </span>
                    <span class="menu-title">Proses Permohonan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.index') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Permohonan</span>
                        </a>
                    </div>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item {{ (request()->is('utama')) ? 'here show' : '' }} menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                            </svg>
                        </span>
                    </span>
                    <span class="menu-title">Peperiksaan & Pemarkahan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.*') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Calon Peperiksaan Sijil Tahfiz</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.pengajian_sepanjang_hayat.pengesahan_markah_sijil_tahfiz.*') ? 'active' : '' }}" href="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.pengesahan_markah_sijil_tahfiz.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengesahan Markah Sijil Tahfiz</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
