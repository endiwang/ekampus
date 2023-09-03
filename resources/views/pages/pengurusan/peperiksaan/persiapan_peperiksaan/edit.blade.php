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
                            <div class="row fv-row mb-2" >
                                <form class="form" action="{{ $action }}" method="post">
                                    @csrf
                                    @if($model->id) @method('PUT') @endif
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sesi', 'Sesi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('sesi', $sessions, $model->sesi_id, ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'sesi' ]) }}
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('lokasi', 'Lokasi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('lokasi', $locations, $model->lokasi_id, ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'lokasi' ]) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                        </div>
                                        
                                        <div class="col-lg-9">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status', '1', $model->status, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.peperiksaan.persiapan_peperiksaan.index') }}" class="btn btn-sm btn-light">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                    <h5 class="fw-bold">Item-item Fasiliti</h5>
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahFail" class="btn btn-sm btn-primary fw-bold" title="Tambah Fail Hebahan Aktiviti">
                                        <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah Item
                                    </a>
                                </div>
                            </div>
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tambahFail" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah Item Fasiliti yang Diperlukan</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.peperiksaan.persiapan_peperiksaan.add_item', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('item', 'Item', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('item', old('item'),['class' => 'form-control form-control-sm ', 'id' =>'item','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('kuantiti', 'Kuantiti', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('kuantiti', old('kuantiti'),['class' => 'form-control form-control-sm ', 'id' =>'kuantiti','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('catatan', 'Catatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('catatan', old('catatan'),['class' => 'form-control form-control-sm ', 'id' =>'catatan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                               
                                            </div>
                                        </div>
                                    </div>
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
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function remove(id){
            Swal.fire({
                title: 'Are you sure you want to delete this file?',
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

    </script>

    {!! $dataTable->scripts() !!}

@endpush