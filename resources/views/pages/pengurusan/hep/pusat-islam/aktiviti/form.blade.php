@php
    $title = __('Senarai Aktiviti');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Senarai Aktiviti' => route('pengurusan.hep.pusat-islam.aktiviti.index'),
    ];
    if(!isset($aktiviti)) {
        $aktiviti = new \App\Models\PusatIslam\Aktiviti;
    }

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.activity :data="$aktiviti" />
    </x-container>
@endsection
