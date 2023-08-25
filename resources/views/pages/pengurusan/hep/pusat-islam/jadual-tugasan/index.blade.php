@php
    $title = __('Jadual Tugsan');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Jadual Tugsan' => false,
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        {{-- {{ $dataTable->table() }} --}}
    </x-container>
@endsection

@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
@endpush
