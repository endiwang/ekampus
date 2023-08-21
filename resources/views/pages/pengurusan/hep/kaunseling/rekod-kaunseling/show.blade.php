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

        @include('pages.pengurusan.hep.kaunseling.partials.info')

        @can('update-kaunseling')
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-sm btn-primary" href="{{ route('pengurusan.hep.kaunseling.edit', $kaunseling->id) }}">Kemaskini</a>
            </div>
        @endcan
    </x-container>
@endsection
