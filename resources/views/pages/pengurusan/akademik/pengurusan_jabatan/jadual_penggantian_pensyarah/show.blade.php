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
                        <div class="card-header">
                            <h3 class="card-title">Senarai Pensyarah Tidak Hadir Bagi Tempoh 7 Hari</h3>
                        </div>
                        <div class="card-body py-5">
                            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" width="100%">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>Nama </th> 
                                        <th>Tarikh</th>
                                        <th>Subjek</th>   
                                        <th>Kelas</th>                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absent_datas as $data)
                                    <tr>
                                        <td class="text-center">
                                            {{ $data->staff->nama ?? null }}
                                        </td>
                                        <td class="text-center">
                                            {{ \App\Helpers\Utils::formatDate($data->tarikh) }}
                                        </td>
                                        <td class="text-center"> 
                                            {{ $data->subjek->nama ?? null }}
                                        </td>
                                        <td class="text-center">
                                            {{ $data->kelas->nama ?? null }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.show', $id)}}" method="get">
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('subjek', Request::get('subjek') ,['class' => 'form-control form-control-sm', 'id' =>'subjek','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('kelas', $kelas, Request::get('kelas'), ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jenis', 'Jenis', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('jenis', $jenis, Request::get('jenis'), ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
                                            <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.show', $id) }}" class="btn btn-sm btn-light">Set Semula</a>
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
    </script>

    {!! $dataTable->scripts() !!}
@endpush
