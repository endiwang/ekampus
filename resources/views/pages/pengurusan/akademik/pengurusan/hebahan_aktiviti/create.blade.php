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
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_program', 'Nama Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_program', old('nama_program'),['class' => 'form-control form-control-sm '.($errors->has('nama_program') ? 'is-invalid':''), 'id' =>'nama_program','onkeydown' =>'return true','autocomplete' => 'off']) }}
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
                                        {{ Form::text('tarikh_program', old('tarikh_program'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_program') ? 'is-invalid':''), 'id' =>'tarikh_program','onkeydown' =>'return true','autocomplete' => 'off']) }}
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
                                        {{ Form::text('tarikh_mula', old('tarikh_mula'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula') ? 'is-invalid':''), 'id' =>'tarikh_mula','onkeydown' =>'return true','autocomplete' => 'off']) }}
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
                                        {{ Form::text('tarikh_tamat', old('tarikh_tamat'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_tamat') ? 'is-invalid':''), 'id' =>'tarikh_tamat','onkeydown' =>'return true','autocomplete' => 'off']) }}
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
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            
                            <br/>
                            <h5 class="fw-bold m-0">Muat Naik Kandungan Hebahan</h5>
                            <br/>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="3%">#</th>
                                                <th>Nama Fail</th> 
                                                <th>Pilih Fail</th>                       
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <template v-for="(field, index) in fields" :key="index">
                                           <tr>
                                            <td v-text="index + 1"></td>
                                            <td><input v-model="field.file_name" type="text" v-bind:name="`data[${index}][file_name]`" class="form-control form-control-sm"></td>
                                            <td><input v-model="field.file" type="file" v-bind:name="`data[${index}][file]`" class="form-control form-control-sm" accept=".png, .jpg, .jpeg, .doc, .docx, .xls, .xlsx, .pdf"></td>
                                            <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                          </tr>
                                         </template>
                                        </tbody>
                                        <tfoot>
                                           <tr>
                                             <td colspan="8" style="text-align: right"><button type="button" class="btn btn-sm btn-info" @click="addNewField()">+ Tambah</button></td>
                                          </tr>
                                        </tfoot>
                                    </table>
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
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')
<script>
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
            }
        },
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
            this.select_type = 1
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

@endpush