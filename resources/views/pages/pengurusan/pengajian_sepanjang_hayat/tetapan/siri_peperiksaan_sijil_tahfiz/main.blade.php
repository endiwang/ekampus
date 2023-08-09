@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header card-header align-items-center py-5 gap-2 gap-md-5">
                        <h3 class="card-title">Tapisan</h3>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <button type="button" class="btn btn-sm btn-light" v-show="show_filter" @click='viewFilterOption'>
                                Buka Tapisan
                            </button>
                            <button type="button" class="btn btn-sm btn-light" v-show="hide_filter" @click='closeFilterOption'>
                                Tutup Tapisan
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-5" v-show="filter_option">
                        <div class="form-floating mb-7" v-show="show_section_1">
                            <input type="text" class="form-control" id="keyword" placeholder="Keyword" name="keyword"/>
                            <label for="floatingKeyword">Carian</label>
                        </div>
                        <div class="row mb-2" v-show="view_more_button">
                            <div class="col-md-9 offset-md-3">
                                <div class="d-flex">
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success me-3 btn-sm">
                                        <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                    </button>
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-light me-3 btn-sm" @click='viewMore'>Lebih Banyak Pilihan Tapisan</button>
                                    <!--end::Button-->
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-7" v-show="show_section_2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>

                        <div class="row" v-show="less_more_button">
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
