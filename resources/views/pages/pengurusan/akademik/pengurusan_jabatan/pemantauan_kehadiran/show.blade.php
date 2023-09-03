@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.show', $id)}}" method="get">
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_pelajar', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_pelajar', Request::get('nama_pelajar') ,['class' => 'form-control form-control-sm', 'id' =>'nama_pelajar','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('subjek', Request::get('subjek') ,['class' => 'form-control form-control-sm', 'id' =>'subjek','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
                                            <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.show', $id) }}" class="btn btn-sm btn-light">Set Semula</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
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

            <div class="modal fade" id="downloadKehadiran" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Muat Turun Kehadiran</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.akademik.pengurusan_jabatan.pemantauan_kehadiran.export') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('pelajar', 'Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('pelajar', $students, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('subjek') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_mula', 'Tarikh Mula', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_mula', old('tarikh_mula'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula') ? 'is-invalid':''), 'id' =>'tarikh_mula','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_akhir', 'Tarikh Akhir', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_akhir', old('tarikh_akhir'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_akhir') ? 'is-invalid':''), 'id' =>'tarikh_akhir','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            Hantar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
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
        $("#tarikh_mula").daterangepicker({
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
            $("#tarikh_mula").val(datePicked);
        });

        $("#tarikh_akhir").daterangepicker({
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
            $("#tarikh_akhir").val(datePicked);
        });
    </script>

    {!! $dataTable->scripts() !!}

@endpush
