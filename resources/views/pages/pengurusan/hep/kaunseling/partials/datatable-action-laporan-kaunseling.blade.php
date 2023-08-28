<div class="d-flex justify-content-end">
    <a class="cursor-pointer mx-2 btn btn-primary btn-sm" href="{{ route('pengurusan.hep.laporan-kaunseling.show', $data->id) }}"
       >
        @lang('View')
    </a>
    @if($data->status == \App\Models\Kaunseling::STATUS_SELESAI )
        <a class="cursor-pointer mx-2 btn btn-secondary btn-sm"
            href="{{ route('pengurusan.hep.laporan-kaunseling.edit', $data->id) }}" >
            @lang('Update')
        </a>
    @endif
</div>
