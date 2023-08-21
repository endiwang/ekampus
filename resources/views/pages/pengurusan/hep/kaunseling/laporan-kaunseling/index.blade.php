@php
    $title = __('Laporan Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => false,
        'Senarai Kaunseling' => false,
        'Rekod Kaunseling' => false,
        'Laporan Kaunseling' => false,
    ];
    $buttons = [];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        {{ $dataTable->table() }}
    </x-container>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
