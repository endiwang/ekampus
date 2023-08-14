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
                        <h3 class="card-title">Maklumat Konvokesyen</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ route('pengurusan.kbg.konvokesyen.update',$konvo->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tajuk_konvo', 'Tajuk Konvokesyen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tajuk_konvo',$konvo->tajuk_konvo,['class' => 'form-control form-control-sm '.($errors->has('tajuk_konvo') ? 'is-invalid':''), 'id' =>'tajuk_konvo','autocomplete' => 'off']) }}
                                        @error('tajuk_konvo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                        {{ Form::text('tarikh',Carbon\Carbon::parse($konvo->tarikh)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh') ? 'is-invalid':''), 'id' =>'tarikh','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-1 text-md-center">
                                    {{ Form::label('tutup_semakan_temuduga', 'Masa', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-2">
                                    <div class="w-100">
                                        {{ Form::text('masa',$konvo->masa,['class' => 'form-control form-control-sm '.($errors->has('masa') ? 'is-invalid':''), 'id' =>'masa','autocomplete' => 'off']) }}
                                        @error('masa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="w-100">
                                        {{ Form::select('waktu',['pagi'=>'Pagi','petang'=>'Petang'], $konvo->waktu, ['class' =>'form-control form-control-sm '.($errors->has('waktu') ? 'is-invalid':'')]) }}
                                        @error('waktu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_tempat', 'Nama Tempat Konvokesyen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_tempat', $konvo->nama_tempat,['class' => 'form-control form-control-sm '.($errors->has('nama_tempat') ? 'is-invalid':''), 'id' =>'nama_tempat','autocomplete' => 'off']) }}
                                        @error('nama_tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_tempat', 'Alamat Tempat Konvokesyen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat_tempat', $konvo->alamat_konvo,['class' => 'form-control form-control-sm '.($errors->has('alamat_tempat') ? 'is-invalid':''), 'id' =>'alamat_tempat_pendaftaran','autocomplete' => 'off', 'rows'=>'4']) }}
                                        @error('alamat_tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_surat', 'Tarikh Cetakan Surat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_surat',Carbon\Carbon::parse($konvo->tarikh_cetakan)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_surat') ? 'is-invalid':''), 'id' =>'tarikh_surat','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status Rekod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status',[0=>'Proses Penyediaan Maklumat',1=>'Semakan Oleh Pelajar',2=>'Telah Selesai'], $konvo->status, ['class' =>'form-control form-control-sm '.($errors->has('status') ? 'is-invalid':'')]) }}
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.kbg.pengurusan.konvokesyen.pilih_pelajar',$konvo->id) }}" class="btn btn-dark btn-sm me-3">
                                            <i class="fa fa-user-plus" style="vertical-align: initial"></i>Pilih Pelajar
                                        </a>
                                        <a href="{{ route('pengurusan.kbg.pengurusan.konvokesyen.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
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
    $("#tarikh").daterangepicker({
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
            $("#tarikh").val(datePicked);
    });

    </script>

{!! $dataTable->scripts() !!}



@endpush
