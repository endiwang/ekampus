@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        @if(!empty($model->id))
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
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Maklumat Pelajar</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('nama', 'Nama :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mb-0">
                                    <p class="form-control form-control-sm" style="border: none">{{ $pelajar->nama }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('ic_no', 'No IC :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mb-0">
                                    <p class="form-control form-control-sm" style="border: none">{{ $pelajar->no_ic }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_telefon', 'No Telefon :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mb-0">
                                    <p class="form-control form-control-sm" style="border: none">{{ $pelajar->no_tel}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!--end::Row-->

        @if(!empty($pinjaman_denda))
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
        @else
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Deklarasi Pelajar</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="d-flex">
                                    <button type="button" onclick="sahkan()" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                        <i class="fa fa-save" style="vertical-align: initial"></i>Sahkan
                                    </button>
                                    <a href="{{ route('pengurusan.perpustakaan.deklarasi.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                </div>
                            </div>
                        </div>
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
        function sahkan(){
        Swal.fire({
            title: 'Adakah anda pasti?',
            text: '',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, Sahkan Pelajar Ini',
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
                        $.ajax({
                        url: '{{route('pengurusan.perpustakaan.deklarasi.sahkan_pelajar')}}',
                        type: 'post',
                        data: {
                                    pelajar_id: '{{ $pelajar->id }}',
                                    _token: '{{csrf_token()}}'
                                },
                        dataType: 'json',
                        success: function(data){
                        location.reload();
                        },error: function(data){
                            alert('error');
                        }
                    });

                }
            })
        }

</script>


{!! $dataTable->scripts() !!}

@endpush
