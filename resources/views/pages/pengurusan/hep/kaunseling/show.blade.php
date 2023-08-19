@php
    $title = __('Senarai Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => route('pengurusan.hep.kaunseling.dashboard.index'),
        'Senarai Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Maklumat Kaunseling' => false,
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Maklumat Permohonan Kaunseling</h3>

        <table class="table table-bordered table-condensed table-striped">
            <tr>
                <td style="width:15% !important;">@lang('No. Permohonan')</td>
                <td>
                    {{ $kaunseling->no_permohonan }}
                </td>
            </tr>
            <tr>
                <td style="width:15% !important;">@lang('Jenis Fasiliti')</td>
                <td>
                    {{ $kaunseling->jenis_fasiliti }}
                </td>
            </tr>
            <tr>
                <td style="width:15% !important;">@lang('Tarikh Permohonan')</td>
                <td>
                    {{ $kaunseling->tarikh_permohonan->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <td style="width:15% !important;">@lang('Status Permohonan')</td>
                <td>
                    {{ $kaunseling->status_label }}
                </td>
            </tr>
        </table>
        @can('update-kaunseling')
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-sm btn-primary" href="{{ route('pengurusan.hep.kaunseling.edit', $kaunseling->id) }}">Kemaskini</a>
            </div>
        @endcan
    </x-container>
@endsection
