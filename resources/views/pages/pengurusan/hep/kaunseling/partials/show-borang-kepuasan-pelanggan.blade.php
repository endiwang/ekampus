@php
    $data = [
        'Jenis Kaunseling' => data_get($kaunseling, 'jenis_kaunseling'),
        'Kekerapan Kaunseling' => data_get($kaunseling, 'tujuan_kaunseling'),
        'Tujuan Kaunseling' => data_get($kaunseling, 'jenis_pengujian'),
        'Hasil Kaunseling' => data_get($kaunseling, 'hasil_kaunseling'),
        'Adakah matlamat tercapai?' => data_get($kaunseling, 'matlamat_tercapai') ? 'Ya' : 'Tidak',
    ];

@endphp

<x-container>
    <h3>Maklumat Kepuasan Pelanggan</h3>
    <table class="table table-bordered table-condensed table-striped">
        @foreach ($data as $label => $value)
            <tr>
                <td style="width:15% !important;">@lang($label)</td>
                <td>
                    {{ $value }}
                </td>
            </tr>
        @endforeach
    </table>

    <div class="d-flex justify-content-end">
        <a class="cursor-pointer mx-2 btn btn-primary btn-sm"
            href="{{ route('pengurusan.hep.brg-kpsn-plngn-knslng.edit', $kaunseling->id) }}">
            @lang('Kemaskini')
        </a>
    </div>
</x-container>
