<div class="d-lg-block" id="kt_header_nav_wrapper">
    <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
        <!--begin::Menu-->
        <div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-semibold" id="kt_landing_menu">
            <!--begin::Menu item-->
            <div class="menu-item">
                <!--begin::Menu link-->
                <a class="menu-link nav-link @if (Route::currentRouteNamed('pemohon.utama.index')) active @endif py-3 px-4 px-xxl-6" href="{{ route('pemohon.utama.index') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Utama</a>
                <!--end::Menu link-->
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            {{-- <div class="menu-item">
                <!--begin::Menu link-->
                <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="{{ route('pemohon.permohonan.index') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Permohonan</a>
                <!--end::Menu link-->
            </div> --}}
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item">
                <!--begin::Menu link-->
                <a class="menu-link nav-link @if ( Route::currentRouteNamed('pemohon.semakan.index')) active @endif py-3 px-4 px-xxl-6" href="{{ route('pemohon.semakan.index') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Semakan</a>
                <!--end::Menu link-->
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item">
                <!--begin::Menu link-->
                <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="#team" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Rayuan</a>
                <!--end::Menu link-->
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item">
                <!--begin::Menu link-->
                <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="#portfolio" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Semakan Rayuan</a>
                <!--end::Menu link-->
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->
    </div>
</div>
