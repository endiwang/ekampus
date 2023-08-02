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
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mt-0">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->nama }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('ic_no', 'No IC', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mt-0">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->ic_no }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_telefon', 'No Telefon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->no_telefon }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('is_public', 'Orang Awam', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        {{ Form::checkbox('is_public', '1', ($model->is_public == 1 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
                                        <span class="form-check-label fs-7 fw-semibold mt-2">
                                            Ya, Orang Awam
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->

        @if(!empty($model->id))
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Senarai Pinjaman</h3>
                    </div>
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                    </div>
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
