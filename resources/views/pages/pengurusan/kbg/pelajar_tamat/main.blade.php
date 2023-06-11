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
            <div class="modal fade modal-lg" tabindex="-1" id="maklumatPelajar">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="mb-10">
                                <!--begin::Title-->
                                <div class="fs-3 fw-bold text-gray-800 text-center mb-13">
                                    <span class="me-2">Pendaftaran Pelajar</span> <br><br>
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                        <img src="{{URL::asset('assets/media/avatars/300-1.jpg')}}" alt="image">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">NAMA PENUH </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">: Test</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">NO. KAD PENGENALAN :</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">Test</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">SESI PENGAJIAN :</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">Test</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">ALAMAT RUMAH :</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">Test</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">POSKOD :</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">Test</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">NEGERI :</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">Test</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-2">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold">NO. TELEFON :</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-7 text-gray-800">Test</span>
                                </div>
                                <!--end::Col-->
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Sahkan Pendaftaran</button>
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

    <script>
        function getMaklumatPelajar(d){
            var pelajarId = d.getAttribute("data-id");
            $.ajax({
               url: '{{ route('pengurusan.kbg.pengurusan.pendaftaran_pelajar.getMaklumatPelajar') }}',
               type: 'post',
               data: {
                            id_pelajar: pelajarId,
                            _token: '{{csrf_token()}}'
                        },
               success: function(response){
                    // Add response in Modal body
                    $('.modal-body').html(response);

                    // Display Modal
                    $('#maklumatPelajar').modal('show');
               }
            });
        }

    </script>

    {!! $dataTable->scripts() !!}

@endpush
