@extends('layouts.public.main_inner_pemohon')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <a href="{{ route('pemohon.permohonan_sijil_tahfiz.create') }}" class="btn btn-info hover-rotate-start">Tambah Permohonan</a>
                <a href="{{ route('pemohon.permohonan_sijil_tahfiz.semakan_permohonan_sijil_tahfiz.index') }}" class="btn btn-info hover-rotate-start">Semakan Kelayakan Permohonan</a>
                <a href="{{ route('pemohon.permohonan_sijil_tahfiz.semakan_keputusan_sijil_tahfiz.index') }}" class="btn btn-info hover-rotate-start">Semakan keputusan Temuduga</a>
                <a href="{{ route('pemohon.permohonan_sijil_tahfiz.semakan_jemputan_majlis.index') }}" class="btn btn-info hover-rotate-start">Semakan Jemputan Pensijilan</a>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                {{-- <div class="card" id="advanceSearch">
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
                </div> --}}
                <h2>Semakan Jemputan Pensijilan</h2>
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

@section('script')

<!-- Include other required scripts for additional features if needed -->
    <script>
        function checkKehadiran(status_kehadiran, permohonan_id)
        {
            var url = "{{ route('pemohon.permohonan_sijil_tahfiz.semakan_jemputan_majlis.update','idPermohonan')}}";
            url = url.replace('idPermohonan', permohonan_id);

            $.ajax({
                type: "PUT",
                url: url,
                data: {status_kehadiran: status_kehadiran},
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                   Swal.fire('Kehadiran telah disahkan.');
                },
                error: function ($data) {

                }
            });
        }

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
    {!! $html->scripts() !!}
    

@endsection
