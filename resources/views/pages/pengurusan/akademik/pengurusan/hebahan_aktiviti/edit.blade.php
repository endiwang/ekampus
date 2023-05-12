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
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('nama_program', 'Nama Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('nama_program', $model->nama_program ?? old('nama_program'),['class' => 'form-control form-control-sm '.($errors->has('nama_program') ? 'is-invalid':''), 'id' =>'nama_program','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('nama_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_program', 'Tarikh Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_program', Carbon\Carbon::parse($model->tarikh_program)->format('d/m/Y') ?? old('tarikh_program'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_program') ? 'is-invalid':''), 'id' =>'tarikh_program','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('tarikh_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_mula', 'Tarikh Mula Hebahan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_mula', Carbon\Carbon::parse($model->tarikh_mula)->format('d/m/Y') ?? old('tarikh_mula'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula') ? 'is-invalid':''), 'id' =>'tarikh_mula','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('tarikh_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh_tamat', 'Tarikh Tamat Hebahan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh_tamat', Carbon\Carbon::parse($model->tarikh_tamat)->format('d/m/Y') ?? old('tarikh_tamat'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_tamat') ? 'is-invalid':''), 'id' =>'tarikh_tamat','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('tarikh_tamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('type', 'Jenis Hebahan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <select class="form-control form-select form-select-sm" data-control="select2" v-model="select_type" @change="onChangePair" name="jenis_hebahan" id="types">
                                                    <option value="">Pilih Jenis Hebahan</option>
                                                    <option v-for="type in typeData" :value="type.typeId" :key="type.typeId">@{{ type.type }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('type_description', 'Deskripsi Hebahan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <select class="form-control form-select form-select-sm" data-control="select2" v-model="select_type_pair" name="jenis_hebahan_detail" id="type_description">
                                                    <option value="">Pilih Deskripsi Hebahan</option>
                                                    <option v-for="description in selected_description_arr" :value="description.id" :key="description.id">@{{ description.text }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('kelulusan', 'Status Kelulusan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <select class="form-control form-select form-select-sm" data-control="select2" name="kelulusan" id="types">
                                                    <option value="">Pilih Status Kelulusan</option>
                                                    @foreach($statuses as $key => $value)
                                                    <option value="{{ $key }}" @if(!empty($selected_status) && $key == $selected_status) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.akademik.pengurusan.hebahan_aktiviti.index') }}" class="btn btn-sm btn-light">Batal</a>
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
                                    <h5 class="fw-bold">Fail-fail Hebahan Aktiviti</h5>
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahFail" class="btn btn-sm btn-primary fw-bold" title="Tambah Fail Hebahan Aktiviti">
                                        <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah Fail Hebahan Aktiviti
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
                            <h3 class="modal-title">Tambah Fail Hebahan Aktiviti</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.akademik.pengurusan.hebahan_aktiviti.upload_file', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('file_name', 'Nama Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('file_name', old('file_name'),['class' => 'form-control form-control-sm '.($errors->has('file_name') ? 'is-invalid':''), 'id' =>'file_name','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('file_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('file', 'Pilih Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <input type="file" name="file" class="form-control form-control-sm">
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

        const { createApp } = Vue

        createApp({
        data() {
            return {
                fields: [
                    {
                        file_name : '',
                        file : '', 
                    },
                ],
                typeData : [
                    {
                        type     : 'Fizikal',
                        typeId   : 1
                    },
                    {
                        type     : 'Digital',
                        typeId   : 2
                    }
                ], 
                select_type : '',
                select_type_pair : '',
                selected_description_arr : [],
                typePairData : {
                    1: [{
                            text    : 'Poster',
                            id      : 1,
                        },
                        {
                            text    : 'Bunting',
                            id      : 2,
                        },
                    ],
                    2: [{
                            text    : 'Media Sosial',
                            id      : 3,
                        },
                    ], 
                }, 
                statusData : [
                    {
                        id : 1,
                        description : 'Dalam Proses'
                    },
                    {
                        id : 2,
                        description : 'Diluluskan'
                    },
                    {
                        id : 3,
                        description : 'Tidak Diluluskan'
                    },
                ]
            }
        },
        // watch : {
        //     select_type: function() {
        //         this.selected_description_arr = [];
        //         console.log(this.select_type);
        //         if (this.select_type > 0) {
        //             this.selected_description_arr = this.typePairData[this.select_type];
        //         }
        //     }
        // },
        methods: {
            addNewField() {
                this.fields.push({
                    file_name: '',
                    file: '',
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
            onChangePair() {
                console.log("here")
                this.selected_description_arr = [];
                console.log(this.select_type);
                if (this.select_type > 0) {
                    this.selected_description_arr = this.typePairData[this.select_type];
                }
            },
        },
        mounted() {
            this.select_type = {!! $selected_type ??  old('jenis_hebahan') !!},
            this.select_type_pair = {!! $selected_detail ??  old('jenis_hebahan_detail') !!},
        },
    }).mount('#advanceSearch')

    $("#tarikh_program").daterangepicker({
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
        $("#tarikh_program").val(datePicked);
    });

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

    $("#tarikh_tamat").daterangepicker({
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
        $("#tarikh_tamat").val(datePicked);
    });

    </script>

    {!! $dataTable->scripts() !!}

@endpush