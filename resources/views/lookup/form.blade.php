@php
    if (!isset($lookup)) {
        $lookup = new \App\Models\Lookup();
    }

    $title = $lookup->id ? __('Kemaskini Maklumat Lookup') : __('Tambah Maklumat Lookup');
    $category = $lookup->category;
    $index_route = $lookup->id
        ? str_replace('.lookup.edit', '.lookup.index', request()->route()->getName())
        : str_replace('.lookup.create', '.lookup.index', request()->route()->getName());
    $breadcrumbs = [
        'Tetapan' => false,
        'Senarai Lookup' => route($index_route, ['category' => $category]),
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Maklumat Lookup (WIP)</h3>

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
                            @foreach($lookup->values ?? [] as $value)
                                <li>{{ $value }}</li>
                            @endforeach
                        </ol>
                    @endif
                </td>
            </tr>
        </table>
    </x-container>
@endsection
