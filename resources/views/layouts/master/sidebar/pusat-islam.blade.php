@php
    $menus = [
        [
            'title' => 'Dashboard',
            'route' => 'pengurusan.hep.pusat-islam.dashboard.index',
        ],
        [
            'title' => 'Aktiviti',
            'route' => 'pengurusan.hep.pusat-islam.aktiviti.index',
        ],
        [
            'title' => 'Jadual Tugasan',
            'route' => 'pengurusan.hep.pusat-islam.jadual-tugasan.index',
        ],
        [
            'title' => 'Orang Awam',
            'route' => 'pengurusan.hep.pusat-islam.orang-awam.index',
        ],
        [
            'title' => 'Rekod Kehadiran',
            'route' => 'pengurusan.hep.pusat-islam.rekod-kehadiran.index',
        ],
        [
            'title' => 'Surat Rasmi',
            'route' => 'pengurusan.hep.pusat-islam.surat-rasmi.index',
        ],
    ];
@endphp

<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true"
            data-kt-menu-expand="false">
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold fs-7" style="color: white !Important">Halaman Utama</span>
                </div>
            </div>
            <div class="menu-item">
                @foreach($menus as $menu)
                    <x-menu-link
                        :title="$menu['title']"
                        :route="$menu['route']"/>
                @endforeach
            </div>
        </div>
    </div>
</div>
