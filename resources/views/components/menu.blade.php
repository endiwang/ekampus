@props([
    'route' => null,
    'title' => 'Menu',
    'children' => [],
])

<div data-kt-menu-trigger="click"
    class="menu-item {{ Request::routeIs($route) ? 'here show' : '' }} menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <span class="svg-icon svg-icon-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="9" height="9" rx="2"
                        fill="currentColor" />
                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                        fill="currentColor" />
                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                        fill="currentColor" />
                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                        fill="currentColor" />
                </svg>
            </span>
        </span>
        <span class="menu-title">{{ $title }}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">

        <div class="menu-item">
            @foreach ($children as $menu)
                <x-menu-link :title="$menu['title']" :route="$menu['route']" />
            @endforeach
        </div>

    </div>
</div>
