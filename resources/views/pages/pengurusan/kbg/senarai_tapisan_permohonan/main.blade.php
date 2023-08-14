@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.kbg.pengurusan.senarai_tapisan_permohonan.index')}}" method="get">
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kursus', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('kursus', $kursus, Request::get('kursus'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kursus') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                            @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('sesi', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('sesi', $sesi, Request::get('sesi'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('sesi') ? 'is-invalid':''),'id'=>'sesi' ]) }}
                                            @error('sesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
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
        function remove(id){
            Swal.fire({
                title: 'Are you sure you want to delete this data?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
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
        $(document).ready(function () {
            if($("#kursus").val() != null || $("#kursus").val() != '')
            {
                $("#sesi").select2({
                    ajax: {
                        url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                        type: "POST",
                        data: {
                                    kursus_id: $("#kursus").val(),
                                    _token: '{{csrf_token()}}'
                                },
                        dataType: 'json',
                        processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data
                        };
                        }
                    }
                })
            }

            $("#kursus").on('change', function(){
                var kursus_id = this.value;

                $("#sesi").val('');
                $("#sesi").select2({
                    ajax: {
                        url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                        type: "POST",
                        data: {
                                    kursus_id: kursus_id,
                                    _token: '{{csrf_token()}}'
                                },
                        dataType: 'json',
                        processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data
                        };
                        }
                    }
                })
            })
        });
        </script>

    {!! $dataTable->scripts() !!}



@endpush
