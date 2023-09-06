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
                                    {{ Form::label('soalan', 'Soalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <textarea class="form-control" id="tinymce" name="soalan">{{ old('soalan') }}</textarea>
                                        @error('soalan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis', 'Jenis Soalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select name="jenis" @change="onChange($event)" class="form-control form-select form-select-sm" 
                                            v-model="select_type">
                                        <option value="">Pilih Jenis</option>
                                        @foreach($types as $key => $value)
                                            <option value="{{ $key }}" @if(!empty($model->jenis) && $model->jenis == $key) selected @endif>{{ $value}}</option>
                                        @endforeach
                                        </select>
                                        @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" v-show="isVisible">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jawapan', 'Jawapan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('jawapan', old('jawapan') ,['class' => 'form-control form-control-sm', 'id' =>'jawapan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jawapan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" v-show="isShow">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="3%">#</th>
                                                    <th>Jawapan</th> 
                                                    <th>Jawapan Yang Betul</th>                       
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <template v-for="(field, index) in fields" :key="index">
                                               <tr>
                                                <td v-text="index + 1"></td>
                                                <td><input v-model="field.name" type="text" v-bind:name="`data[${index}][name]`" class="form-control form-control-sm"></td>
                                                <td>
                                                    <select class="form-control form-select form-select-sm" data-control="select2" x-model="field.is_correct" v-bind:name="`data[${index}][is_correct]`">
                                                        <option data-display="Status*" value="">Adakah Jawapan Yang Betul *</option>
                                                        <option value="1">Ya</option> 
                                                        <option value="0">Tidak</option> 
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
                            </div>
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('markah', 'Markah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('markah', old('markah') ,['class' => 'form-control form-control-sm', 'id' =>'markah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('markah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-0">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                </div>
                                
                                <div class="col-lg-9">
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        {{ Form::checkbox('status', '1', $model->status ?? old('status'), ['class' => 'form-check-input h-25px w-60px']); }}
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
                                        <a href="{{ route('pengurusan.akademik.e_learning.pengurusan_ujian_atas_talian.index') }}" class="btn btn-sm btn-light">Batal</a>
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
    tinymce.init({
        selector: 'textarea#tinymce',
        height: 300
    });

    const { createApp } = Vue
    createApp({
        
    data() {
        return {
            showOption : false,
            showText : false,
            fields: [
                    {
                        name : '',
                        is_correct : '', 
                    },
                ]
        }
    },
    methods: {
            addNewField() {
                this.fields.push({
                    name : '',
                    is_correct : '', 
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
            onChange(event) {
                if(event.target.value == '1' || event.target.value == '2')
                {
                    this.showOption = true;
                    this.showText = false;
                }
                else {
                    this.showSection = false;
                    this.showText = false;
                }

                if(event.target.value == '3')
                {
                    this.showOption = false;
                    this.showText = true;
                }
                else {
                    this.showSection = false;
                    this.showText = false;
                }
            },
        },
    computed:{
        isVisible(){
            return this.showText;
        },
        isShow(){
            return this.showOption;
        }
    },
    mounted() {
        
        },
    }).mount('#advanceSearch')

    function remove(id){
        Swal.fire({
            title: 'Are you sure you want to delete this data? All of the data associated with this data will be deleted.',
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

