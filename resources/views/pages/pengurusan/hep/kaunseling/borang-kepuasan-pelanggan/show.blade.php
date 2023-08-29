@php
    $title = __('BOrang Kepuasan Pelanggan');
    $breadcrumbs = [
        'Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Senarai Rekod Kaunseling' => route('pengurusan.hep.rekod-kaunseling.index'),
        'Maklumat Rekod Kaunseling' => route('pengurusan.hep.rekod-kaunseling.show', $kaunseling->id),
        'Borang Kepuasan Pelanggan' => false,
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Maklumat Kaunseling</h3>
        @include('pages.pengurusan.hep.kaunseling.partials.info')
    </x-container>

    @include('pages.pengurusan.hep.kaunseling.partials.show-borang-kepuasan-pelanggan')

@endsection
