@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Laporan Aduan Penyelenggaraan</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="row fv-row mb-2" >
                            <form class="form" action="{{ $action }}" method="post">
                                @csrf

                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('date_start', 'Tarikh Mula Aduan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::date('date_start', Request::get('date_start'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm', 'required' => 'required' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('date_end', 'Tarikh Tamat Aduan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::date('date_end', Request::get('date_end'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm', 'required' => 'required' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Aduan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::select('status', \App\Models\AduanPenyelenggaraan::getStatusSelection(), Request::get('status'), ['placeholder' => 'Semua' , 'class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Cetak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection