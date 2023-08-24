<div class="d-flex justify-content-end">
    <a class="cursor-pointer mx-2 btn btn-primary btn-sm" href="{{ route('pengurusan.hep.kaunseling.rekod-kaunseling.show', $data->id) }}"
       >
        @lang('View')
    </a>
    @if(auth()->user()->can('update-rekod-kaunseling') && $data->status == \App\Models\Kaunseling::STATUS_DITERIMA )
        <a class="cursor-pointer mx-2 btn btn-secondary btn-sm"
            href="{{ route('pengurusan.hep.kaunseling.rekod-kaunseling.edit', $data->id) }}" >
            @lang('Update')
        </a>
    @endif
</div>
