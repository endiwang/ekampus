@extends('layouts.master.main')
@section('css')
@endsection
@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.index') }}">
                    <div class="card card-flush shadow-sm bg-primary">
                        <div class="card-header">
                            <h3 class="card-title text-white">Bilangan Permohonan Baru</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $permohonan_all }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="#">
                    <div class="card card-flush shadow-sm bg-warning">
                        <div class="card-header">
                            <h3 class="card-title text-white">Bilangan Lulus Peperiksaan</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $lulus_all }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.index') . '?st=3' }}">
                    <div class="card card-flush shadow-sm bg-danger">
                        <div class="card-header">
                        <h3 class="card-title text-white">Bilangan Setuju Hadir Temuduga</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $hadir_temuduga_all }}</span>
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
                            <h3 class="card-title text-white">Bilangan Pemarkahan Yang Belum Disahkan</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ $markah_belum_disahkan }}</span>
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
