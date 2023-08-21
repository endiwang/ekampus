@php
    if (!isset($kaunseling)) {
        $kaunseling = new \App\Models\Kaunseling();
    }

    $action = $kaunseling->id ? route('pengurusan.hep.kaunseling.update', $kaunseling->id) : route('pengurusan.hep.kaunseling.store');

    $title = __('Senarai Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => route('pengurusan.hep.kaunseling.dashboard.index'),
        'Senarai Kaunseling' => route('pengurusan.hep.kaunseling.index'),
    ];

    if($kaunseling->id) {
        $breadcrumbs['Maklumat Kaunseling'] = route('pengurusan.hep.kaunseling.show', $kaunseling->id);
        $breadcrumbs['Kemaskini Kaunseling'] = false;
    } else {
        $breadcrumbs['Permohonan Kaunseling Baru'] = false;
    }
@endphp

@extends('layouts.master.main')
@section('content')
    <x-container>
        <h3>Permohonan Kaunseling Baru</h3>

        <form class="form" action="{{ $action }}" method="POST">
            @csrf
            @if($kaunseling->id)
                @method('PUT')
            @endif
            <div class="row fv-row mb-2">
                <div class="col-md-3 text-md-end">
                    {{ Form::label('tarikh_permohonan', 'Tarikh Permohonan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                </div>
                <div class="col-md-9">
                    <div class="w-100">
                        {{ Form::date('tarikh_permohonan', data_get($kaunseling, 'tarikh_permohonan', old('tarikh_permohonan')), [
                            'class' => 'form-control form-control-sm ' . ($errors->has('tarikh_permohonan') ? 'is-invalid' : ''),
                            'id' => 'tarik_permohonan',
                            'onkeydown' => 'return true',
                            'autocomplete' => 'off',
                            'min' => now()->addDay()->format('Y-m-d'),
                            'max' => now()->format('Y-') . '12-31',
                        ]) }}
                        @error('tarikh_permohonan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @role('kaunseling')
                <div class="row fv-row mb-2">
                    <div class="col-md-3 text-md-end">
                        {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                    </div>
                    <div class="col-md-9">
                        <div class="w-100">
                            {{ Form::select(
                                'status',
                                \App\Models\Kaunseling::getStatuses(),
                                data_get($kaunseling, 'status', old('status')),
                                [
                                    'placeholder' => 'Pilih Status...',
                                    'class' => 'form-control form-control-sm ' . ($errors->has('status') ? 'is-invalid' : ''),
                                    'id' => 'status',
                                    'onkeydown' => 'return true',
                                    'autocomplete' => 'off',
                                ],
                            ) }}
                            @error('jenis_fasiliti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endrole

            <div class="row mt-5">
                <div class="col-md-9 offset-md-3">
                    <div class="d-flex">
                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                            <i class="fa fa-save" style="vertical-align: initial"></i>
                            @if (!$kaunseling->id)
                                Simpan
                            @else
                                Kemaskini
                            @endif
                        </button>

                        <a href="{{ route('pengurusan.hep.kaunseling.index') }}" class="btn btn-sm btn-light">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </x-container>
@endsection
