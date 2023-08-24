@extends('layouts.master.main')
@section('css')
@endsection
@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') }}">
                    <div class="card card-flush shadow-sm bg-primary">
                        <div class="card-header">
                            <h3 class="card-title text-white">Bilangan Keseluruhan Aduan</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $aduan_all }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') . '?st=1' }}">
                    <div class="card card-flush shadow-sm bg-warning">
                        <div class="card-header">
                            <h3 class="card-title text-white">Bilangan Aduan Baru</h3>
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
                <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') . '?st=3' }}">
                    <div class="card card-flush shadow-sm bg-danger">
                        <div class="card-header">
                        <h3 class="card-title text-white">Bilangan Aduan Perlu Diproses</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $aduan_to_process }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') . '?st=4' }}">
                    <div class="card card-flush shadow-sm bg-success">
                        <div class="card-header">
                            <h3 class="card-title text-white">Bilangan Aduan Selesai</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $aduan_complete }}</span>
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
@section('script')
@endsection

@push('scripts')
@endpush
