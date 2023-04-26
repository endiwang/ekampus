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
                                    {{ Form::label('nama_mesyuarat', 'Nama Mesyuarat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_mesyuarat', old('nama_mesyuarat'),['class' => 'form-control form-control-sm '.($errors->has('nama_mesyuarat') ? 'is-invalid':''), 'id' =>'nama_mesyuarat','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_mesyuarat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mesyuarat', 'Tarikh Mesyuarat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mesyuarat', old('tarikh_mesyuarat'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mesyuarat') ? 'is-invalid':''), 'id' =>'tarikh_mesyuarat','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_mesyuarat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bahagian_terlibat', 'Unit/Bahagian Terlibat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('bahagian_terlibat[]', $departments, null, ['class' =>'form-control form-control-lg ', 'data-control'=>'select2', 'multiple'=>'multiple', 'data-placeholder' => 'Sila Pilih']) }}
                                        @error('bahagian_terlibat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
            
                            <br/>
                            <h5 class="fw-bold m-0">Muat Naik Laporan</h5>
                            <br/>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="3%">#</th>
                                                <th>Nama Fail</th> 
                                                <th>Keterangan</th>  
                                                <th>Pilih Fail</th>                       
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <template v-for="(field, index) in fields" :key="index">
                                           <tr>
                                            <td v-text="index + 1"></td>
                                            <td><input v-model="field.file_name" type="text" v-bind:name="`data[${index}][file_name]`" class="form-control form-control-sm"></td>
                                            <td><textarea v-model="field.description" v-bind:name="`data[${index}][description]`" class="form-control form-control-sm"></textarea></td>
                                            <td><input v-model="field.file" type="file" v-bind:name="`data[${index}][file]`" @change="onChangeFile" class="form-control form-control-sm" accept=".png, .jpg, .jpeg, .doc, .docx, .xls, .xlsx, .pdf"></td>
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
                                        <a href="{{ route('pengurusan.akademik.laporan.laporan_mesyuarat.index') }}" class="btn btn-sm btn-light">Batal</a>
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
                    description : '',
                    file : '', 
                },
            ],
        }
    },
    methods: {
        addNewField() {
              this.fields.push({
                file_name: '',
                description: '',
                file: '',
               });
            },
        removeField(index) {
               this.fields.splice(index, 1);
            },
        onChangeFile(e) {
            var files = e.target.files || e.dataTransfer.files;
  console.log(files);
            },
        createFile(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.this.fields.image = e.target.result;
            };
        reader.readAsDataURL(file);
    },
        },
    mounted() {

        },
    }).mount('#advanceSearch')

    $("#tarikh_mesyuarat").daterangepicker({
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
        $("#tarikh_mesyuarat").val(datePicked);
    });
</script>

@endpush