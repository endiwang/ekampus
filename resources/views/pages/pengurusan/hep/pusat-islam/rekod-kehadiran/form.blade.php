@php
    $title = __('Rekod Kehadiran');
    $breadcrumbs = [
        'Pusat Islam' => false,
        $title => route('pengurusan.hep.pusat-islam.rekod-kehadiran.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.rekod-kehadiran />
    </x-container>
@endsection
