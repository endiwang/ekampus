@php
    $title = __('Surat Rasmi');
    $breadcrumbs = [
        'Pusat Islam' => false,
        $title => route('pengurusan.hep.pusat-islam.surat-rasmi.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.surat-rasmi />
    </x-container>
@endsection
