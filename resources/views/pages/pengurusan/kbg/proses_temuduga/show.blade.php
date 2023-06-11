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
                        <form class="form" action="{{ route('pengurusan.kbg.proses_temuduga.update', $temuduga->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tajuk_borang_temuduga', 'Tajuk Borang Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tajuk_borang_temuduga', $temuduga->tajuk_borang,['class' => 'form-control form-control-sm '.($errors->has('tajuk_borang_temuduga') ? 'is-invalid':''), 'id' =>'tajuk_borang_temuduga','autocomplete' => 'off']) }}
                                        @error('tajuk_borang_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('program_pengajian',$kursus, $temuduga->kursus_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm '.($errors->has('program_pengajian') ? 'is-invalid':'')]) }}
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
                                        {{ Form::select('sesi', $sesi, $temuduga->sesi_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('sesi') ? 'is-invalid':''),'id'=>'sesi' ]) }}
                                        @error('sesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pilihan_temuduga', 'Pilihan Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('pilihan_temuduga',['B'=>'Temuduga Pengambilan','R'=>'Temuduga Rayuan'], $temuduga->temuduga_type, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm '.($errors->has('pilihan_temuduga') ? 'is-invalid':'')]) }}
                                        @error('pilihan_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pusat_temuduga', 'Pusat Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('pusat_temuduga',$pusat_temuduga, $temuduga->pusat_temuduga_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm '.($errors->has('pusat_temuduga') ? 'is-invalid':'')]) }}
                                        @error('pusat_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_temuduga', 'Tarikh Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_temuduga',Carbon\Carbon::parse($temuduga->tarikh)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_temuduga') ? 'is-invalid':''), 'id' =>'tarikh_temuduga','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_temuduga', 'Masa Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('masa_temuduga',$temuduga->masa,['class' => 'form-control form-control-sm '.($errors->has('masa_temuduga') ? 'is-invalid':''), 'id' =>'masa_temuduga','autocomplete' => 'off']) }}
                                        @error('masa_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_tempat_temuduga', 'Nama Tempat Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_tempat_temuduga', $temuduga->nama_tempat,['class' => 'form-control form-control-sm '.($errors->has('nama_tempat_temuduga') ? 'is-invalid':''), 'id' =>'nama_tempat_temuduga','autocomplete' => 'off']) }}
                                        @error('nama_tempat_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_tempat_temuduga', 'Alamat Tempat Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat_tempat_temuduga', $temuduga->alamat_temuduga,['class' => 'form-control form-control-sm '.($errors->has('alamat_tempat_temuduga') ? 'is-invalid':''), 'id' =>'alamat_tempat_temuduga','autocomplete' => 'off', 'rows'=>'4']) }}
                                        @error('alamat_tempat_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_cetak_surat_temuduga', 'Tarikh Cetakan Surat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_cetak_surat_temuduga',$temuduga->tkh_cetakan != NULL ? Carbon\Carbon::parse($temuduga->tkh_cetakan)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_cetak_surat_temuduga') ? 'is-invalid':''), 'id' =>'tarikh_cetak_surat_temuduga','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_cetak_surat_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('ketua_temuduga', 'Ketua Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('ketua_temuduga',$ketua_temuduga, $temuduga->id_ketua, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm '.($errors->has('ketua_temuduga') ? 'is-invalid':''),'data-control'=>'select2']) }}
                                        @error('ketua_temuduga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.kursus.index') }}" class="btn btn-sm btn-light">Batal</a>
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
$("#tarikh_cetak_surat_temuduga").daterangepicker({
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
        $("#tarikh_cetak_surat_temuduga").val(datePicked);
});
</script>

@endpush
