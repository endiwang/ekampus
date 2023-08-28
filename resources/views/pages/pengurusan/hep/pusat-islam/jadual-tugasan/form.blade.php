@php
    $title = __('Jadual Tugasan');
    $breadcrumbs = [
        'Pusat Islam' => false,
        $title => route('pengurusan.hep.pusat-islam.jadual-tugasan.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.pusat-islam.jadual-tugasan />
    </x-container>
@endsection
