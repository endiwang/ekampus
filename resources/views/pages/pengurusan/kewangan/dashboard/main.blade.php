@extends('layouts.master.main')
@section('css')
@endsection
@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10">
            @foreach($yuran_cached as $yuran)
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <a href="{{ route('pengurusan.kewangan.yuran.index', $yuran->id) . '?st=1' }}">
                    <div class="card card-flush shadow-sm ">
                        <div class="card-header">
                            <h3 class="card-title ">Bilangan {{ $yuran->nama }} Belum Selesai</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-1 text-dark opacity-75 w-100 mt-auto mb-2">
                                    <span>{{ (!empty($yuran_bil[$yuran->id])) ? $yuran_bil[$yuran->id] : '0' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
@section('script')
@endsection

@push('scripts')
@endpush
