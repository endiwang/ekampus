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
                        <form class="form" action="{{ $action }}" method="post">
                            @if($model->id) @method('PUT') @endif
                            @csrf
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_kelas', 'Nama Kelas', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_kelas', $model->nama ?? old('nama_kelas'),['class' => 'form-control form-control-sm '.($errors->has('nama_kelas') ? 'is-invalid':''), 'id' =>'nama_kelas','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bilangan_pelajar', 'Bilangan Pelajar (Maksimum)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('bilangan_pelajar', $model->kapasiti_pelajar ?? old('bilangan_pelajar'),['class' => 'form-control form-control-sm '.($errors->has('bilangan_pelajar') ? 'is-invalid':''), 'id' =>'bilangan_pelajar','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('bilangan_pelajar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jantina_pelajar', 'Jantina Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jantina_pelajar', $genders, $model->semasa_jantina, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('jantina_pelajar') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('jantina_pelajar') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.kelas.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->

        @if(!empty($model->id))
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header d-flex flex-row-reverse justify-content-between">
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#export" class="btn btn-icon btn-info btn-sm hover-elevate-up mt-5" title="Muat Turun Senarai Pelajar">
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="export" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Muat Turun Senarai Pelajar</h3>
                        <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <form class="form-horizontal" action="{{ route('pengurusan.akademik.pengurusan_kelas.export_by_class') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-body">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('export_type', 'Jenis Muat Turun', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('export_type', 
                                            [
                                                'pdf' => 'PDF',
                                                'excel' => 'Excel'
                                            ], 
                                            null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="class_id" value="{{ $model->id }}">
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
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const { createApp } = Vue

    createApp({
    data() {
        return {
            show_section_1: true,
            show_section_2: false,
        }
    },
    methods: {
            viewMore(){
                this.show_section_1 = false;
                this.show_section_2 = true;
            },
            hideMore(){
                this.show_section_1 = true;
                this.show_section_2 = false;
            },
        },
    mounted() {

        },
    }).mount('#advanceSearch')
</script>


{!! $dataTable->scripts() !!}

@endpush