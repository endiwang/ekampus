@php
    $action = route('pengurusan.hep.rekod-kaunseling.update', ['rekod_kaunseling' => $kaunseling->id]);

    $title = __('Rekod Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Senarai Kaunseling' => route('pengurusan.hep.kaunseling.index'),
        'Rekod Kaunseling' => route('pengurusan.hep.rekod-kaunseling.index')
    ];
@endphp

@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Rekod Kaunseling</h3>
        @include('pages.pengurusan.hep.kaunseling.partials.info')
    </x-container>

    <x-container>
        <livewire:forms.kaunseling.rekod-kaunseling :kaunseling="$kaunseling" />
    </x-container>
@endsection
