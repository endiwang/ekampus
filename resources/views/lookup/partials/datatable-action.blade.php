<div class="d-flex">
    @can('view-lookup')
        <a class="cursor-pointer mx-2 btn btn-primary btn-sm" href="{{ route($view_route, $data) }}">
            @lang('View')
        </a>
    @endcan

    @can('update-lookup')
        <a class="cursor-pointer mx-2 btn btn-secondary btn-sm" href="{{ route($edit_route, $data) }}">
            @lang('Update')
        </a>
    @endcan
</div>
