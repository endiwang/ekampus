@php
    $title = __('Pendaftaran Kelas Orang Awam');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Kelas Orang Awam' => false,
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
