@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page_title }}</h3>
                        </div>
                        <div class="card-body py-5">
                            <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama', $pelajar->nama ?? old('nama'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama') ? 'is-invalid' : ''), 'id' => 'nama', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_ic', 'MyKad / Passport', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_ic', $pelajar->no_ic ?? old('no_ic'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_ic') ? 'is-invalid' : ''), 'id' => 'no_ic', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('no_ic')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_matrik', 'No. Matrik', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_matrik', $pelajar->no_matrik ?? old('no_matrik'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_matrik') ? 'is-invalid' : ''), 'id' => 'no_matrik', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('no_matrik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('laporan_polis', 'Muat Naik Laporan Polis', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <input type="file" name="laporan_polis" class='form-control form-control-sm'>
                                            @error('laporan_polis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('salinan_sijil', 'Muat Naik Salinan Sijil', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <input type="file" name="salinan_sijil" class='form-control form-control-sm'>
                                            @error('salinan_sijil')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kod_qr', 'Muat Naik Kod QR', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <input type="file" name="kod_qr" class='form-control form-control-sm'>
                                            @error('kod_qr')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit"
                                                class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Hantar
                                            </button>
                                            <a href="{{ route('alumni.permohonan.sijil_ganti.index') }}"
                                                class="btn btn-sm btn-light">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {}
            },
            methods: {},
            mounted() {},
        }).mount('#advanceSearch')

        $("#tarikh_mula").daterangepicker({
            autoApply: true,
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            minYear: parseInt(moment().subtract(1, 'y').format("YYYY")),
            maxYear: parseInt(moment().add(4, 'y').format("YYYY")),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) {
            var datePicked = moment(start).format('DD/MM/YYYY');
            $("#tarikh_mula").val(datePicked);
        });

        $("#tarikh_akhir").daterangepicker({
            autoApply: true,
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            minYear: parseInt(moment().subtract(1, 'y').format("YYYY")),
            maxYear: parseInt(moment().add(4, 'y').format("YYYY")),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) {
            var datePicked = moment(start).format('DD/MM/YYYY');
            $("#tarikh_akhir").val(datePicked);
        });
    </script>
@endpush
