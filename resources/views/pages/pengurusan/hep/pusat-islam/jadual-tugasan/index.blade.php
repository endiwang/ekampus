@php
    $title = __('Jadual Tugsan');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Jadual Tugsan' => false,
    ];
    $buttons = [
        [
            'title' => 'Jana Rekod Baru',
            'route' => route('pengurusan.hep.pusat-islam.jadual-tugasan.create'),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-pi-jadual-tugasan')
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
