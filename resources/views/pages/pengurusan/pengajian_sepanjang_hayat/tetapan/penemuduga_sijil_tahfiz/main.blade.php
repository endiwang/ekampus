@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
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

        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    
                    <div class="card-body py-5">
                        {{ $html->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
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
        function remove(id){
            Swal.fire({
                title: 'Anda pasti untuk menghapuskan data ini?',
                text: 'Tindakan ini tidak boleh dibatalkan',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus',
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

        const { createApp } = Vue

        createApp({
        data() {
            return {
                filter_option: false,
                show_filter:true,
                hide_filter: false,
                show_section_1: true,
                show_section_2: false,
                view_more_button: true,
                less_more_button: false
            }
        },
        methods: {
                viewFilterOption(){
                    this.filter_option = true;
                    this.hide_filter = true;
                    this.show_filter = false;
                    this.hideMore();
                },
                viewMore(){
                    this.show_section_1 = true;
                    this.show_section_2 = true;
                    this.view_more_button = false;
                    this.less_more_button = true;
                },
                hideMore(){
                    this.show_section_1 = true;
                    this.show_section_2 = false;
                    this.view_more_button = true;
                    this.less_more_button = false;
                },
                closeFilterOption(){
                    this.filter_option = false;
                    this.hide_filter = false;
                    this.show_filter = true;
                },
            },
        mounted() {

            },
        }).mount('#advanceSearch')
    </script>
    {!! $html->scripts() !!}

@endpush
