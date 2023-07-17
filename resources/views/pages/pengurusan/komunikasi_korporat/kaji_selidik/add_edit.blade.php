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
                                    {{ Form::label('nama_borang', 'Nama Borang', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_borang', $model->title ?? old('nama_borang'),['class' => 'form-control form-control-sm '.($errors->has('nama_borang') ? 'is-invalid':''), 'id' =>'nama_borang','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_borang') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                            {{ Form::checkbox('status', '1', ($model->status == 0 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
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


{{-- {!! $dataTable->scripts() !!} --}}

@endpush
