<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold fs-7" style="color: white !Important">Hal Ehwal Akademik</span>
                </div>
            </div>
            {{-- <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs" target="blank">
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
                    <span class="menu-title">Kelas</span>
                </a>
                <!--end:Menu link-->
            </div>--}}
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ Request::routeIs('pengurusan.akademik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.index') }}" target="blank">
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
            <div data-kt-menu-trigger="click" class="menu-item {{ Request::routeIs('pengurusan.akademik.kursus.*') ? 'here show' : '' }} menu-accordion">
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
                    <span class="menu-title">Pengurusan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.kalendar_akademik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.kalendar_akademik.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Kalendar Akademik</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.peraturan_akademik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.peraturan_akademik.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Peraturan Akademik</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.semester.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.semester.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Semester</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.kursus.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.kursus.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Kursus</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.kelas.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.kelas.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Kelas</span>
                        </a>
                    </div>
                    
                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.subjek.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.subjek.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Subjek</span>
                        </a>
                    </div> --}}

                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('base2') ? 'active' : '' }}" href="{{ route('base2') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Syukbah</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('base2') ? 'active' : '' }}" href="{{ route('base2') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pusat Pengajian</span>
                        </a>
                    </div> --}}
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan.penamatan_pengajian.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan.penamatan_pengajian.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Arahan Berhenti Belajar</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan.mpk_iso.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan.mpk_iso.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">MPK & ISO</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan.hebahan_aktiviti.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan.hebahan_aktiviti.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Hebahan Aktiviti</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan.aktiviti_pdp.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan.aktiviti_pdp.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Aktiviti PDP</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan.penilaian_pensyarah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan.penilaian_pensyarah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Soalan Penilaian Pensyarah</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Tetapan Penilaian Berterusan</span>
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
                    <span class="menu-title">Permohonan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.permohonan.pertukaran_syukbah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.permohonan.pertukaran_syukbah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pertukaran Syukbah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.permohonan.pelepasan_kuliah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.permohonan.pelepasan_kuliah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pelepasan Kuliah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.permohonan.penangguhan_pengajian.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.permohonan.penangguhan_pengajian.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penangguhan Pengajian</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.permohonan.rayuan_pengajian.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.permohonan.rayuan_pengajian.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rayuan Pengajian</span>
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
                    <span class="menu-title">Pendaftaran</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Akademik Pelajar</span>
                        </a>
                    </div> --}}
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.kelas_pelajar.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.kelas_pelajar.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Kelas Pelajar</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.syukbah_pelajar.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.syukbah_pelajar.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Syukbah Pelajar</span>
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
                    <span class="menu-title">Pensyarah</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pensyarah.senarai_pensyarah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pensyarah.senarai_pensyarah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Senarai Pensyarah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.guru_tasmik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.guru_tasmik.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Guru Tasmik</span>
                        </a>
                    </div>
                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Kehadiran</span>
                        </a>
                    </div>
                </div>--}}
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
                    <span class="menu-title">Jadual Waktu</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.jadual.jadual_kelas.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.jadual.jadual_kelas.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Kelas</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('#') ? 'active' : '' }}" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pensyarah</span>
                        </a>
                    </div>
                </div>
                    
                </div>
            </div>
            {{-- <div data-kt-menu-trigger="click" class="menu-item {{ (request()->is('utama')) ? 'here show' : '' }} menu-accordion">
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
                    <span class="menu-title">Peperiksaan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.guru_tasmik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.guru_tasmik.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Jadual Peperiksaan</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Calon Peperiksaan</span>
                        </a>
                    </div>
                </div>
            </div> --}}
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
                    <span class="menu-title">Rekod Kehadiran</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pelajar</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.rekod_kehadiran.rekod_pensyarah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_pensyarah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pensyarah</span>
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
                    <span class="menu-title">Jabatan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Hafazan Lisan (Shafawi)</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Bertulis (Tahriri)</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Murajaah Harian</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.pengurusan_clo.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.pengurusan_clo.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengurusan CLO</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.pengurusan_plo.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengurusan PLO</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pemetaan CLO & PLO</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pendaftaran Markah CLO & PLO</span>
                        </a>
                    </div>
                </div>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Penilaian Berterusan</span>
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
                    <span class="menu-title">Ijazah</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.pelajar.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.pelajar.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Kemasukan Pelajar Ijazah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.penawaran_subjek.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Penawaran Subjek</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.akademik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.akademik.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Akademik</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.jadual_pembelajaran.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.jadual_pembelajaran.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Jadual Pembelajaran</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.nota_kuliah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.nota_kuliah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Nota Kuliah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Profil Pensyarah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.kompilasi_soalan.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.kompilasi_soalan.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Kompilasi Soalan</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Tesis/Projek Ilmiah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.latihan_industri.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Latihan Industri</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Rekod Maklumat Graduasi</span>
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
                    <span class="menu-title">Laporan</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.laporan.laporan_mesyuarat.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.laporan.laporan_mesyuarat.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Laporan Mesyuarat</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.laporan.tangguh_pengajian.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.laporan.tangguh_pengajian.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pelajar Gantung/Tangguh</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.laporan.akademik.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.laporan.akademik.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Akademik</span>
                        </a>
                    </div>
                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Laporan Akademik</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Laporan Pensyarah</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Laporan Tasmik (Pelajar)</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('base2') ? 'active' : '' }}" href="{{ route('base2') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Laporan Tasmik (Guru)</span>
                        </a>
                    </div> --}}
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
                    <span class="menu-title">E-Learning</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.e_learning.pengurusan_kandungan.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.e_learning.pengurusan_kandungan.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengurusan Kandungan Pembelajaran</span>
                        </a>
                    </div>
                    {{-- <div class="menu-item">
                        <a class="menu-link {{ Request::routeIs('pengurusan.akademik.rekod_kehadiran.rekod_pensyarah.index') ? 'active' : '' }}" href="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_kehadiran.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengurusan Jadual Pembelajaran</span>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
