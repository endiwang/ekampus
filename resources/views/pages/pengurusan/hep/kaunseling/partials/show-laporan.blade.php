@php
    $data = [
        'Latar Belakang' => data_get($kaunseling, 'latar_belakang'),
        'Ringkas Kes' => data_get($kaunseling, 'ringkasan'),
        'Hasil Konsultasi' => data_get($kaunseling, 'hasil_konsultasi'),
    ];

@endphp

<x-container>
    <h3>Laporan</h3>
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
            href="{{ route('pengurusan.hep.laporan-kaunseling.edit', $kaunseling->id) }}">
            @lang('Kemaskini')
        </a>
    </div>
</x-container>
