<div class="d-flex justify-content-end">
    <a class="cursor-pointer mx-2 btn btn-primary btn-sm" href="{{ route('pengurusan.hep.kaunseling.show', $data->id) }}"
       >
        @lang('View')
    </a>
    @if(auth()->user()->can('update-kaunseling') && $data->status == \App\Models\Kaunseling::STATUS_BARU )
        <a class="cursor-pointer mx-2 btn btn-secondary btn-sm"
            href="{{ route('pengurusan.hep.kaunseling.edit', $data->id) }}" >
            @lang('Update')
        </a>
    @endif

    @if(auth()->user()->can('delete-kaunseling') && $data->status == \App\Models\Kaunseling::STATUS_BARU )
        <div class="cursor-pointer mx-2 btn btn-danger btn-sm"
            onclick="
            event.preventDefault();
            if(config('Anda pasti untuk hapuskan rekod ini?') {
                document.getElementById('delete-kaunseling-{{ $data->id }}').submit();
            }">
            @lang('Delete')
            <form action="{{ route('pengurusan.hep.kaunseling.destroy', $data->id) }}" method="POST"
                id="delete-kaunseling-{{ $data->id }}">
                @csrf
                @method('DELETE')
            </form>
        </div>
    @endif
</div>
