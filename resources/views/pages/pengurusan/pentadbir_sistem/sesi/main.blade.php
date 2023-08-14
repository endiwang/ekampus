@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sesi Pengajian</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Pentadbir Sistem</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Sesi Pengajian</li>

                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('pengurusan.pentadbir_sistem.sesi.create') }}" class="btn btn-sm btn-primary fw-bold">
                    <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
                        <i class="fa fa-plus-circle"></i>
                    </span>Tambah Sesi
                </a>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-body py-5">
                            <form id="kt_ecommerce_settings_general_form" class="form" action="#">
                                <div class="row fv-row mb-2" v-show="show_section_1">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('maklumat_carian', 'Maklumat Carian', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex">
                                            {{ Form::text('maklumat_carian','',['class' => 'form-control me-3 form-control-sm']) }}

                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0"
                                            data-clipboard-target="#kt_share_earn_link_input"><i class="fa fa-search" style="vertical-align: initial"></i>Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2" v-show="show_section_1">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <!--begin::Button-->
                                            <button type="button" class="btn btn-light me-3 btn-sm" @click='viewMore'>Lebih Banyak Pilihan Tapisan</button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" v-show="show_section_2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('maklumat_carian', 'Maklumat Carian', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        {{ Form::text('maklumat_carian','',['class' => 'form-control form-control-sm']) }}
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" v-show="show_section_2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kursus', 'Kursus', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('kursus', $kursus, null, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-show="show_section_2">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <!--begin::Button-->
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success me-3 btn-sm">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
                                            <button type="button" @click='hideMore' class="btn btn-light btn-sm">Kurangkan Pilihan Tapisan</button>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <!--end::Button-->
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
