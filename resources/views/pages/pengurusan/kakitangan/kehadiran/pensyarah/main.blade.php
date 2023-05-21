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
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('maklumat_carian', 'Maklumat Carian', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="d-flex">
                                        <input type="text" v-model="keyword.search" v-on:keyup.enter="search()" class="form-control me-3 form-control-sm">
                                        <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0" @click="search()">
                                            <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
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
            <div class="modal fade" id="kodQr" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Imbas Kod QR Kehadiran</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row fv-row mb-2" >
                                {!! $qr_code !!}
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center mt-5 mb-5">
                                    <p style="font-size:10px;">Dijana Pada : {{ $generated_at ?? null }}</p>
                                </div>
                            </div>
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
                table: null,
                keyword: {
                    search:null,
                }
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
                search() {
                    console.log(this.search);
                    this.search(this.keyword.search).draw();
                },
            },
        mounted() {

            },
        }).mount('#advanceSearch')
    </script>

    {!! $dataTable->scripts() !!}

@endpush
