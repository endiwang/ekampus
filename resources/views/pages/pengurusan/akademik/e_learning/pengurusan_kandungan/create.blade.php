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
                                    {{ Form::label('nama_kandungan', 'Nama Kandungan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_kandungan', old('nama_kandungan'),['class' => 'form-control form-control-sm '.($errors->has('nama_kandungan') ? 'is-invalid':''), 'id' =>'nama_kandungan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_kandungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kursus', 'Kursus', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select class="form-control form-select form-select-sm" data-control="select2" name="kursus" id="kursus">
                                            <option value="">Pilih Kursus</option>
                                            @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->kod_subjek }} - {{ $subject->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('penerangan', 'Penerangan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <textarea class="form-control" id="tinymce" name="penerangan">{{ $model->penerangan ?? old('body') }}</textarea>
                                        @error('penerangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::checkbox('status', '0', ($model->status == 0 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
                                            <span class="form-check-label fs-7 fw-semibold mt-2">
                                                Aktif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <br/>
                            <h5 class="fw-bold m-0">Muat Naik Kandungan Pembelajaran</h5>
                            <br/>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="3%">#</th>
                                                <th>Nama Fail</th> 
                                                <th>Jenis Kandungan</th> 
                                                <th>Pilih Fail</th> 
                                                <th>Status</th>                       
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <template v-for="(field, index) in fields" :key="index">
                                           <tr>
                                            <td v-text="index + 1"></td>
                                            <td><input v-model="field.file_name" type="text" v-bind:name="`data[${index}][file_name]`" class="form-control form-control-sm"></td>
                                            <td>
                                                <select class="form-control form-select form-select-sm" data-control="select2" x-model="field.type" v-bind:name="`data[${index}][type]`">
                                                    <option data-display="Jenis Kandungan*" value="">Jenis Kandungan *</option>
                                                    @foreach($types as $key => $value)
                                                        <option value="{{ $key ?? old('type') }}">{{ $value }}</option>    
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input v-model="field.file" type="file" v-bind:name="`data[${index}][file]`" class="form-control form-control-sm" accept=".png, .jpg, .jpeg, .doc, .docx, .xls, .xlsx, .pdf"></td>
                                            <td>
                                                <select class="form-control form-select form-select-sm" data-control="select2" x-model="field.status" v-bind:name="`data[${index}][status]`">
                                                    <option data-display="Status*" value="">Status *</option>
                                                    <option value="1">Aktif</option> 
                                                    <option value="0">Tidak Aktif</option> 
                                                </select>
                                            </td>
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
                                        <a href="{{ route('pengurusan.akademik.e_learning.pengurusan_kandungan.index') }}" class="btn btn-sm btn-light">Batal</a>
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
    tinymce.init({
        selector: 'textarea#tinymce',
        height: 400
    });

    const { createApp } = Vue

    createApp({
        data() {
            return {
                fields: [
                    {
                        file_name : '',
                        type : '',
                        file : '', 
                        status : '',
                    },
                ],
            }
        },
        methods: {
            addNewField() {
                this.fields.push({
                    file_name: '',
                    type : '',
                    file: '',
                    status: ''
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
            
        },
    }).mount('#advanceSearch')

</script>

@endpush