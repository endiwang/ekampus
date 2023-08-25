@php
    $title = __('Rekod Kehadiran');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Rekod Kehadiran' => false,
    ];
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
