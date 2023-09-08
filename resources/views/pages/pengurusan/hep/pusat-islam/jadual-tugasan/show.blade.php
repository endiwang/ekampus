@php
    $title = __('Jadual Tugasan');
    $breadcrumbs = [
        'Pusat Islam' => false,
        $title => route('pengurusan.hep.pusat-islam.jadual-tugasans.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <div class="mt-8">
            <h4>Jenis Tugasan</h3>
            @include('pages.pengurusan.hep.pusat-islam.partials.jenis-tugasan')
        </div>

        <div class="mt-8">
            <h4>Waktu Solat</h3>
            @include('pages.pengurusan.hep.pusat-islam.partials.waktu-solat')
        </div>

        <div class="mt-8">
            <h4>Maklumat Petugas</h4>
            @include('pages.pengurusan.hep.pusat-islam.partials.user')
        </div>


    </x-container>
@endsection
