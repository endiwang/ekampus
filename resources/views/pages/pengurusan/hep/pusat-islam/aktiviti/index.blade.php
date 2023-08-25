@php
    $title = __('Senarai Aktiviti');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Senarai Aktiviti' => false,
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
