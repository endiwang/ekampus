@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.index')}}" method="get">
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_projek', 'Nama Projek', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_projek', Request::get('nama_projek') ,['class' => 'form-control form-control-sm', 'id' =>'nama_projek','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            @error('nama_projek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajuk_tesis', 'Tajuk Tesis', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tajuk_tesis', Request::get('tajuk_tesis') ,['class' => 'form-control form-control-sm', 'id' =>'tajuk_tesis','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            @error('tajuk_tesis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
                                            <a href="{{ route('pengurusan.akademik.pengurusan_ijazah.rekod_tesis.index') }}" class="btn btn-sm btn-light">Set Semula</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
            }
        }).mount('#advanceSearch')
    </script>

    {!! $dataTable->scripts() !!}

@endpush
