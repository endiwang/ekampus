@php
    $action = route('pengurusan.hep.rekod-kaunseling.update', ['rekod_kaunseling' => $kaunseling->id]);

    $title = __('Laporan Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Senarai Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Laporan Kaunseling' => route('pengurusan.hep.laporan-kaunseling.index')
    ];
@endphp

@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Rekod Kaunseling</h3>
        @include('pages.pengurusan.hep.kaunseling.partials.info')
    </x-container>

    @include('pages.pengurusan.hep.kaunseling.partials.show-borang-kepuasan-pelanggan')

    <x-container>
        <livewire:forms.kaunseling.laporan :kaunseling="$kaunseling" />
    </x-container>
@endsection
