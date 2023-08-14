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
                                    {{ Form::label('nama_pensyarah', 'Nama Pensyarah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pensyarah', old('nama_pensyarah'),['class' => 'form-control form-control-sm '.($errors->has('nama_pensyarah') ? 'is-invalid':''), 'id' =>'nama_pensyarah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_pensyarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('id_pensyarah', 'ID Pensyarah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('id_pensyarah', old('id_pensyarah'),['class' => 'form-control form-control-sm '.($errors->has('id_pensyarah') ? 'is-invalid':''), 'id' =>'id_pensyarah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('id_pensyarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jantina', 'Jantina', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::select('jantina', $genders, old('jantina'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ', 'data-control'=>'select2']) }}
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('warganegara', 'Jenis Kewarganegaraan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::select('warganegara', $nationalities, old('warganegara'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ', 'data-control'=>'select2']) }}
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jawatan', 'Jawatan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('jawatan', old('jawatan'),['class' => 'form-control form-control-sm '.($errors->has('jawatan') ? 'is-invalid':''), 'id' =>'jawatan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jawatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gred', 'Gred', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('gred', old('jawatan'),['class' => 'form-control form-control-sm '.($errors->has('gred') ? 'is-invalid':''), 'id' =>'gred','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('gred') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_1', 'Alamat 1', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('alamat_1', old('alamat_1'),['class' => 'form-control form-control-sm '.($errors->has('alamat_1') ? 'is-invalid':''), 'id' =>'alamat_1','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('alamat_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_2', 'Alamat 2', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('alamat_2', old('alamat_2'),['class' => 'form-control form-control-sm '.($errors->has('alamat_2') ? 'is-invalid':''), 'id' =>'alamat_2','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('alamat_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('poskod', 'Poskod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('poskod', old('poskod'),['class' => 'form-control form-control-sm '.($errors->has('poskod') ? 'is-invalid':''), 'id' =>'poskod','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('poskod') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bandar', 'Bandar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('bandar', old('bandar'),['class' => 'form-control form-control-sm '.($errors->has('bandar') ? 'is-invalid':''), 'id' =>'bandar','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('bandar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('negeri', 'Negeri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('negeri', old('negeri'),['class' => 'form-control form-control-sm '.($errors->has('negeri') ? 'is-invalid':''), 'id' =>'negeri','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('negeri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('emel', 'Alamat Emel', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('emel', old('emel'),['class' => 'form-control form-control-sm '.($errors->has('emel') ? 'is-invalid':''), 'id' =>'emel','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('emel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('phone', 'No. Telefon (Bimbit)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('phone', old('phone'),['class' => 'form-control form-control-sm '.($errors->has('phone') ? 'is-invalid':''), 'id' =>'phone','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('phone', 'No. Telefon (Rumah)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('home', old('home'),['class' => 'form-control form-control-sm '.($errors->has('home') ? 'is-invalid':''), 'id' =>'home','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('home') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('office', 'No. Telefon (Pejabat)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('office', old('office'),['class' => 'form-control form-control-sm '.($errors->has('office') ? 'is-invalid':''), 'id' =>'office','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('office') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            
                            <br/>
                            <h5 class="fw-bold m-0">Muat Naik Dokumen Tambahan</h5>
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
                ]
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

</script>

@endpush