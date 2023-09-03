@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('vendor.aduan_penyelenggaraan.index') . '?stv=1' }}">
                    <div class="card card-flush shadow-sm bg-danger">
                        <div class="card-header">
                            <h3 class="card-title text-white">Aduan Baru</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $aduan_new }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('vendor.aduan_penyelenggaraan.index') . '?stv=2' }}">
                    <div class="card card-flush shadow-sm bg-warning">
                        <div class="card-header">
                            <h3 class="card-title text-white">Aduan Dalam Proses</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $aduan_process }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('vendor.aduan_penyelenggaraan.index') . '?stv=3' }}">
                    <div class="card card-flush shadow-sm bg-success">
                        <div class="card-header">
                            <h3 class="card-title text-white">Aduan Selesai</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $aduan_done }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>        
</div>
@endsection