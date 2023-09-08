@php
    $title = __('Jadual Tugasan');
    $breadcrumbs = [
        'Pusat Islam' => false,
        $title => route('pengurusan.hep.pusat-islam.jadual-tugasans.index'),
    ];

    if(! isset($jadualTugasan)) {
        $jadualTugasan = null;
    }

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.jadual-tugasan :data="$jadualTugasan" />
    </x-container>
@endsection
