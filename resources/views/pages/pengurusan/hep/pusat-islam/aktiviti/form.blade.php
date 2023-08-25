@php
    $title = __('Senarai Aktiviti');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Senarai Aktiviti' => route('pengurusan.hep.pusat-islam.aktiviti.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.activity />
    </x-container>
@endsection
