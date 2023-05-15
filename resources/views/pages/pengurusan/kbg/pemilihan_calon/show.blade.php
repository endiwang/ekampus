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
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Maklumat Tawaran</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ route('pengurusan.kbg.tawaran.update',$tawaran->id) }}" method="post">
                            @method('PUT')

                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tajuk_tawaran', 'Tajuk Tawaran Kemasukan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tajuk_tawaran',$tawaran->tajuk_tawaran,['class' => 'form-control form-control-sm '.($errors->has('tajuk_tawaran') ? 'is-invalid':''), 'id' =>'tajuk_tawaran','autocomplete' => 'off']) }}
                                        @error('tajuk_tawaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('program_pengajian',$kursus, $tawaran->kursus_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm '.($errors->has('program_pengajian') ? 'is-invalid':'')]) }}
                                        @error('program_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sesi', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('sesi', $sesi, $tawaran->sesi_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('sesi') ? 'is-invalid':''),'id'=>'sesi' ]) }}
                                        @error('sesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tawaran_type', 'Pilihan Tawaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('tawaran_type',['B'=>'Tawaran Pengambilan','R'=>'Tawaran Rayuan'], $tawaran->tawaran_type, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm '.($errors->has('tawaran_type') ? 'is-invalid':'')]) }}
                                        @error('tawaran_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_surat', 'Tarikh Cetakan Surat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_surat',\Carbon\Carbon::parse($tawaran->tarikh_surat)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_surat') ? 'is-invalid':''), 'id' =>'tarikh_surat','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_pendaftaran', 'Tarikh Pendaftaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_pendaftaran',\Carbon\Carbon::parse($tawaran->tarikh_pendaftaran)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_pendaftaran') ? 'is-invalid':''), 'id' =>'tarikh_pendaftaran','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_pendaftaran', 'Masa Pendaftaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('masa_pendaftaran',$tawaran->masa,['class' => 'form-control form-control-sm '.($errors->has('masa_pendaftaran') ? 'is-invalid':''), 'id' =>'masa_pendaftaran','autocomplete' => 'off']) }}
                                        @error('masa_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_tempat_pendaftaran', 'Nama Tempat Pendaftaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_tempat_pendaftaran', $tawaran->nama_tempat,['class' => 'form-control form-control-sm '.($errors->has('nama_tempat_pendaftaran') ? 'is-invalid':''), 'id' =>'nama_tempat_pendaftaran','autocomplete' => 'off']) }}
                                        @error('nama_tempat_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_tempat_pendaftaran', 'Alamat Tempat Pendaftaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat_tempat_pendaftaran', $tawaran->alamat_pendaftaran,['class' => 'form-control form-control-sm '.($errors->has('alamat_tempat_pendaftaran') ? 'is-invalid':''), 'id' =>'alamat_tempat_pendaftaran','autocomplete' => 'off', 'rows'=>'4']) }}
                                        @error('alamat_tempat_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_kemasukan', 'Status Kemasukan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status_kemasukan',[1=>'Tidak Aktif (Proses Penyediaan)',2=>'Aktif (Proses Pendaftaran Pelajar)',3=>'Arkib'], $tawaran->status, ['class' =>'form-control form-control-sm '.($errors->has('status_kemasukan') ? 'is-invalid':'')]) }}
                                        @error('status_kemasukan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm me-3">
                                            <i class="fa fa-print" style="vertical-align: initial"></i>Cetak Senarai Nama
                                        </button>
                                        <a href="{{ route('pengurusan.kbg.pengurusan.tawaran.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection

@push('scripts')

<script>

    $(document).ready(function () {
        if($("#program_pengajian").val() != null || $("#program_pengajian").val() != '')
        {
            $("#sesi").select2({
                ajax: {
                    url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                    type: "POST",
                    data: {
                                kursus_id: $("#program_pengajian").val(),
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

        $("#program_pengajian").on('change', function(){
            var kursus_id = this.value;

            $("#sesi").val('');
            $("#sesi").select2({
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

    $("#tarikh_temuduga").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_temuduga").val(datePicked);
});
$("#tarikh_surat").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_surat").val(datePicked);
});

$("#tarikh_pendaftaran").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_pendaftaran").val(datePicked);
});
</script>

@endpush
