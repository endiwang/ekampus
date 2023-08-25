@php
    $title = __('Senarai Aktiviti');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Senarai Aktiviti' => false,
    ];
    $buttons = [
        [
            'title' => 'Jana Rekod Baru',
            'route' => route('pengurusan.hep.pusat-islam.aktiviti.create'),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-pi-aktiviti')
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
