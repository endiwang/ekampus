@php
    $title = __('Senarai Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => false,
        'Senarai Kaunseling' => false,
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        @can('create-kaunseling')
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-sm btn-primary" href="{{ route('pengurusan.hep.kaunseling.create') }}">Mohon Sesi Kaunseling</a>
            </div>
        @endcan
        <div>{{ $dataTable->table() }}</div>
    </x-container>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
