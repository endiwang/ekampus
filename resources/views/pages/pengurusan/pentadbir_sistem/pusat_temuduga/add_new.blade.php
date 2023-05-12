@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body py-5">
                            <form class="form" action="{{ route('pengurusan.pentadbir_sistem.pusat_temuduga.store')}}" method="post">
                                @csrf
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('Pusat', 'Nama Pusat Temuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_pusat_temuduga','',['class' => 'form-control form-control-sm']) }}
                                            @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                                {{ Form::checkbox('status', '0', true, ['class' => 'form-check-input h-25px w-60px']); }}
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
                                            <a href="{{ route('pengurusan.pentadbir_sistem.pusat_temuduga.index') }}" class="btn btn-sm btn-light">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection

{{-- @push('scripts')
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

    {!! $dataTable->scripts() !!}

@endpush --}}
