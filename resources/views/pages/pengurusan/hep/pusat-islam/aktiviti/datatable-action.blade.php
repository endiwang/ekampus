<div class="d-flex justify-content-end">
    @can('view', $data)
        <a class="cursor-pointer mx-2 btn btn-primary btn-sm"
            href="{{ route('pengurusan.hep.pusat-islam.aktiviti.show', $data->id) }}">
            @lang('View')
        </a>
    @endcan
    @can('update', $data)
        <a class="cursor-pointer mx-2 btn btn-secondary btn-sm"
            href="{{ route('pengurusan.hep.pusat-islam.aktiviti.edit', $data->id) }}">
            @lang('Update')
        </a>
        @endif

        @can('delete', $data)
            <div class="cursor-pointer mx-2 btn btn-danger btn-sm"
                onclick="
            event.preventDefault();
            if(confirm('Anda pasti untuk hapuskan rekod ini?')) {
                document.getElementById('delete-kaunseling-{{ $data->id }}').submit();
            }">
                @lang('Delete')
                <form action="{{ route('pengurusan.hep.pusat-islam.aktiviti.destroy', $data->id) }}" method="POST"
                    id="delete-kaunseling-{{ $data->id }}">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endcan
    </div>
