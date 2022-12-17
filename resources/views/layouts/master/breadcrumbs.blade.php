<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ $title ?? '' }}</h1>
            @if (isset($breadcrumbs) && is_array($breadcrumbs) && count($breadcrumbs))
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                </li>
                @foreach ($breadcrumbs as $key => $item)
                    @if (is_array($item))
                        @foreach ($item as $ky => $itm)
                            @if ($itm)
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-capitalize text-muted">
                                    <a href="{{ $itm }}">{{ $ky }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-capitalize active text-muted" aria-current="page">
                                    {{ $ky }}
                                </li>
                            @endif
                        @endforeach
                    @else
                        @if ($item)
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-capitalize text-muted">
                                <a href="{{ $item }}">{{ $key }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-capitalize active text-muted" aria-current="page">
                                {{ $key }}
                            </li>
                        @endif
                    @endif

                @endforeach
            </ul>
            @endif
        </div>
        
        @if (isset($buttons) && is_array($buttons) && count($buttons))
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                @foreach ($buttons as $button)
                <a href="{{ $button['route'] }}" class="{{ $button['button_class'] }}">
                    <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
                        <i class="{{ $button['icon_class'] }}"></i>
                    </span>{{ $button['title'] }}
                </a>
                @endforeach
            </div>
        @endif
    </div>
</div>