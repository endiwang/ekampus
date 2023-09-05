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
                        <div class="card-body py-5">
                            <form class="form" action="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.show', $id)}}" method="get">
                                <div class="card">
                                    <div class="card-body py-5">
                                        <div class="row fv-row mb-2" >
                                            <div class="col-md-3 text-md-end">
                                                {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                            </div>
                                            <div class="col-md-9">
                                                <div class="w-100">
                                                    {{ Form::text('nama', Request::get('nama') ,['class' => 'form-control form-control-sm', 'id' =>'nama','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fv-row mb-2" >
                                            <div class="col-md-3 text-md-end">
                                                {{ Form::label('no_matrik', 'No Matrik', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                            </div>
                                            <div class="col-md-9">
                                                <div class="w-100">
                                                    {{ Form::text('no_matrik', Request::get('no_matrik') ,['class' => 'form-control form-control-sm', 'id' =>'no_matrik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fv-row mb-2" >
                                            <div class="col-md-3 text-md-end">
                                                {{ Form::label('tarikh', 'Tarikh', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                            </div>
                                            <div class="col-md-9">
                                                <div class="w-100">
                                                    {{ Form::text('tarikh', old('tarikh'),['class' => 'form-control form-control-sm ', 'id' =>'tarikh','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fv-row mb-2" >
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3">
                                                        <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                                    </button>
                                                    <a href="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.show', $id) }}" class="btn btn-sm btn-light">Set Semula</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body py-5">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                  
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#muatTurunKehadiran" class="btn btn-sm btn-primary fw-bold" title="Muat Turun Kehadiran">
                                        <i class="fa fa-circle-down" style="vertical-align: initial"></i>Muat Turun Kehadiran
                                    </a>
                                </div>
                            </div>
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="muatTurunKehadiran" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Muat Turun Kehadiran</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.muat_turun') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_kehadiran', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_kehadiran', old('tarikh_kehadiran'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_kehadiran') ? 'is-invalid':''), 'id' =>'tarikh_kehadiran','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('tarikh_kehadiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="nama_subjek" value="{{ $subjek->nama ?? null }}">
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            Simpan
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <div class="modal fade" id="addKehadiran" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah Kehadiran</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('no_matrik', 'No Matrik Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('no_matrik', old('no_matrik') ,['class' => 'form-control form-control-sm', 'id' =>'no_matrik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_kehadiran2', 'Tarikh Kehadiran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_kehadiran', old('tarikh_kehadiran'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_kehadiran2') ? 'is-invalid':''), 'id' =>'tarikh_kehadiran2','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('status', $statuses, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('lampiran', 'Lampiran', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <input type="file" name="file" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $id }}" name="subjek_id">
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            Simpan
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
        function remove(id){
            Swal.fire({
                title: 'Are you sure you want to delete this data?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
                reverseButtons: true,
                customClass: {
                    title: 'swal-modal-delete-title',
                    htmlContainer: 'swal-modal-delete-container',
                    cancelButton: 'btn btn-light btn-sm mr-1',
                    confirmButton: 'btn btn-primary btn-sm ml-1'
                },
                buttonsStyling: false
            })
                .then((result) => {
                    if(result.isConfirmed){
                        document.getElementById(`delete-${id}`).submit();
                    }
                })
        }
        
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

        $("#tarikh_kehadiran").daterangepicker({
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
            $("#tarikh_kehadiran").val(datePicked);
        });

        $("#tarikh_kehadiran2").daterangepicker({
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
            $("#tarikh_kehadiran2").val(datePicked);
        });
    </script>

    {!! $dataTable->scripts() !!}

@endpush