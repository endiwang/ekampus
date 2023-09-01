@extends('layouts.master.main')
@section('css')
<style>
    .select-info{
        display: none
    }
</style>
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <form class="form" action="{{ route('pengurusan.kbg.pengurusan.senarai_tapisan_permohonan.proses_pemilihan')}}" method="get">
                    <div class="card">
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kursus', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kursus', $kursus, Request::get('kursus'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kursus') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sesi1', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('sesi1',[],'' , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('sesi1') ? 'is-invalid':''),'id'=>'sesi1', 'data-control'=>'select2' ]) }}
                                        @error('sesi1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0">
                                            <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0 pt-6">
                <h3 class="card-title">Senarai Nama Pelajar</h3>
            </div>
            <div class="card-body py-4">
                <table id="senarai_pemohon_table" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                    <thead>
                    <tr class="">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#senarai_pemohon_table .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th>Nama Pelajar</th>
                        <th>Program</th>
                        <th>No. KP</th>
                        <th>Jumlah %</th>
                    </tr>
                    </thead>
                    <tbody class="">
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-start" data-kt-docs-table-toolbar="base">
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-sm btn-secondary me-5" data-bs-toggle="tooltip" disabled>
                        <i class="fa fa-save"></i>
                        Simpan
                    </button>

                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
                        Kembali
                    </a>
                    <!--end::Add customer-->
                </div>
                <div class="d-flex justify-content-start align-items-center d-none" data-kt-docs-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-docs-table-select="selected_count"></span> Telah Dipilih
                    </div>

                    <button type="button" class="btn btn-sm btn-success me-5" data-kt-docs-table-select="simpan-selected" data-bs-toggle="tooltip" title="Simpan">
                        <i class="fa fa-save"></i>
                        Pilih
                    </button>
                    <button type="button" class="btn btn-sm btn-danger me-5" data-kt-docs-table-select="tolak-selected" data-bs-toggle="tooltip" title="Tolak">
                        <i class="fa fa-save"></i>
                        Tolak
                    </button>

                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
                        Kembali
                    </a>
                </div>


            </div>
        </div>
</div>



@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        if($("#kursus").val() != null || $("#kursus").val() != '')
        {
            $("#sesi").select2({
                ajax: {
                    url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                    type: "POST",
                    data: {
                                kursus_id: $("#kursus").val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                }
            })
        }

        $("#kursus").on('change', function(){
            var kursus_id = this.value;

            $("#sesi").val('');
            $("#sesi1").select2({
                ajax: {
                    url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                    type: "POST",
                    data: {
                                kursus_id: kursus_id,
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                }
            })
        })
    });
    </script>

@endpush


