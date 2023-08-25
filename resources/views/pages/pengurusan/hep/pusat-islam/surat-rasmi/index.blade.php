@php
    $title = __('Surat Rasmi');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Surat Rasmi' => false,
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
