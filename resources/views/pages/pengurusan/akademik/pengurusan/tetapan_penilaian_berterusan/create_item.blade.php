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
                                    {{ Form::label('nama_item', 'Nama Item', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_item', old('nama_item'),['class' => 'form-control form-control-sm '.($errors->has('nama_item') ? 'is-invalid':''), 'id' =>'nama_item','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_item') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('peratus_item', 'Peratus Keseluruhanan Item (%)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('peratus_item', old('peratus_item'),['class' => 'form-control form-control-sm '.($errors->has('peratus_item') ? 'is-invalid':''), 'id' =>'peratus_item','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('peratus_item') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="subjek_id" value="{{ $subjek_id }}">
                            
                            <br/>
                            <h5 class="fw-bold m-0">Tambah Komponen Pemarkahan</h5>
                            <br/>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="3%">#</th>
                                                <th>Nama Komponen</th> 
                                                <th>Peratus Pemarkahan</th>                       
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <template v-for="(field, index) in fields" :key="index">
                                           <tr>
                                            <td v-text="index + 1"></td>
                                            <td><input v-model="field.name" type="text" v-bind:name="`data[${index}][name]`" class="form-control form-control-sm"></td>
                                            <td><input v-model="field.mark" type="text" v-bind:name="`data[${index}][mark]`" class="form-control form-control-sm"></td>
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
                                        <a href="{{ route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.show', $subjek_id) }}" class="btn btn-sm btn-light">Batal</a>
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
                        name : '',
                        mark : '', 
                    },
                ], 
            }
        },
        methods: {
            addNewField() {
                this.fields.push({
                    name: '',
                    mark: '',
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
        },
        mounted() {
            this.select_type = 1
        },
    }).mount('#advanceSearch')

</script>

@endpush