@php
    $title = __('Senarai Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Senarai Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Maklumat Kaunseling' => false,
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Maklumat Permohonan Kaunseling</h3>

        @include('pages.pengurusan.hep.kaunseling.partials.info')
    </x-container>

    @include('pages.pengurusan.hep.kaunseling.partials.show-borang-kepuasan-pelanggan')

    @include('pages.pengurusan.hep.kaunseling.partials.show-laporan')

@endsection
