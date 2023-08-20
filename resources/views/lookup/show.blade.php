@php
    $title = __('Maklumat Lookup');
    $category = $lookup->category;
    $index_route = str_replace('.lookup.show', '.lookup.index', request()->route()->getName());
    $edit_route = str_replace('.lookup.show', '.lookup.edit', request()->route()->getName());
    $breadcrumbs = [
        'Tetapan' => false,
        'Senarai Lookup' => route($index_route, ['category' => $category]),
    ];
    $buttons = [
        [
            'title' => 'Kemaskini Maklumat',
            'route' => route($edit_route, $lookup),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-pencil-circle',
            'is_show' => auth()->user()->can('update-lookup') && auth()->user()->can('update-'.$category)
        ],
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Maklumat Lookup</h3>

        <table class="table table-bordered table-condensed table-striped">
            <tr>
                <td style="width:15% !important;">@lang('Nama')</td>
                <td>
                    {{ $lookup->name }}
                </td>
            </tr>
            <tr>
                <td style="width:15% !important;">@lang('Keterangan')</td>
                <td>
                    {{ $lookup->description }}
                </td>
            </tr>
            <tr>
                <td style="width:15% !important;">@lang('Status')</td>
                <td>
                    {{ $lookup->is_enabled ? 'Aktif' : 'Tidak Aktif' }}
                </td>
            </tr>
            <tr>
                <td style="width:15% !important;">@lang('Value')</td>
                <td>
                    @if($lookup->value)
                        {{ $lookup->value }}
                    @else
                        <ol>
                            @foreach($lookup->values as $value)
                                <li>{{ $value }}</li>
                            @endforeach
                        </ol>
                    @endif
                </td>
            </tr>
        </table>
        @can('update-lookup')
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-sm btn-primary" href="{{ route('lookup.edit', $lookup->id) }}">Kemaskini</a>
            </div>
        @endcan
    </x-container>
@endsection
