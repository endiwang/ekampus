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
                        <div class="card-header">
                            <h3 class="card-title">Senarai Laporan Akademik</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" width="100%">
                                    <thead class="thead-light">
                                    <!--begin::Table head-->
                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                        <th>Nama Laporan</th>
                                        <th width="2%">Tindakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $report)
                                            <tr class="fw-bold border-bottom-0">
                                                <td>{{ $report['name']}}</td>
                                                <td class="text-center">{!! $report['action'] !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->  
        </div>
    </div>
    <!--start::senarai pendaftaran pelajar-->  
    <div class="modal fade" id="cetakPendaftaranPelajar" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Laporan Senarai Pendaftaran Pelajar</h3>
                    <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                </div>
                <form class="form-horizontal" action="{{ route('pengurusan.akademik.laporan.akademik.export_senarai_pendaftaran_pelajar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('file_name', 'Nama Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('file_name', old('file_name'),['class' => 'form-control form-control-sm '.($errors->has('file_name') ? 'is-invalid':''), 'id' =>'file_name','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('file_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('file', 'Pilih Dokumen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" name="file" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select class="form-control form-select form-select-sm" data-control="select2" name="status">
                                            <option data-display="Status*" value="">Status *</option>
                                            <option value="1">Aktif</option> 
                                            <option value="0">Tidak Aktif</option> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex">
                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                    Cetak
                                </button>
                                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::senarai pendaftaran pelajar-->
@endsection

