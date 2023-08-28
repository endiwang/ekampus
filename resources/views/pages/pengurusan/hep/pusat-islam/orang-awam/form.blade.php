@php
    $title = __('Kelas Orang Awam');
    $breadcrumbs = [
        'Pusat Islam' => false,
        $title => route('pengurusan.hep.pusat-islam.orang-awam.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.orang-awam />
    </x-container>
@endsection
