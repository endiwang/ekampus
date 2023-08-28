<div class="d-flex justify-content-end">
    @can('view', $data)
        <a class="cursor-pointer mx-2 btn btn-primary btn-sm" href="{{ $viewUrl }}">
            @lang('View')
        </a>
    @endcan

    @can('update', $data)
        <a class="cursor-pointer mx-2 btn btn-secondary btn-sm" href="{{ $updateUrl }}">
            @lang('Update')
        </a>
    @endcan

    @can('delete', $data)
        <div class="cursor-pointer mx-2 btn btn-danger btn-sm"
            onclick="
                event.preventDefault();
                if(confirm('Anda pasti untuk hapuskan rekod ini?')) {
                    document.getElementById('delete-{{ $data->id }}').submit();
                }">
            @lang('Delete')
            <form action="{{ $deleteUrl }}" method="POST" id="delete-{{ $data->id }}">
                @csrf
                @method('DELETE')
            </form>
        </div>
    @endcan
</div>
