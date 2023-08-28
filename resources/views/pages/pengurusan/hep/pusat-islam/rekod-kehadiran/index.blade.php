@php
    $title = __('Rekod Kehadiran');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Rekod Kehadiran' => false,
    ];
    $buttons = [
        [
            'title' => 'Jana Rekod Baru',
            'route' => route('pengurusan.hep.pusat-islam.rekod-kehadiran.create'),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-pi-rekod-kehadiran')
        ],
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
