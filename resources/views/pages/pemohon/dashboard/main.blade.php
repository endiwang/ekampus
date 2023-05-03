@extends('layouts.public.main_inner_pemohon')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                    <div class="col-xl-7">
                        <!--begin::Table widget 14-->
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Senarai Permohonan Yang Dibuka</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                                <th class="p-0 pb-3 min-w-175px text-start">KURSUS</th>
                                                <th class="p-0 pb-3 min-w-100px text-center">SESI</th>
                                                <th class="p-0 pb-3 min-w-100px text-center">TARIKH BUKA</th>
                                                <th class="p-0 pb-3 min-w-175px text-center">TARIKH TUTUP</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @foreach ($permohonan as $data)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{-- <div class="symbol symbol-50px me-3">
                                                            <img src="assets/media/stock/600x600/img-49.jpg" class="" alt="" />
                                                        </div> --}}
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $data->kursus->nama }}</a>
                                                            <span class="text-gray-400 fw-semibold d-block fs-7">{{ $data->pusat_pengajian->nama }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">{{ $data->sesi->nama }}</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">{{ Carbon\Carbon::parse($data->mula_permohonan)->format('d/m/Y') }}</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">{{ Carbon\Carbon::parse($data->tutup_permohonan)->format('d/m/Y') }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>

                            <!--end: Card Body-->
                        </div>
                        <!--end::Table widget 14-->
                    </div>
                    <div class="col-xl-5">
                        <!--begin::Timeline-->
                        <div class="card">
                            <!--begin::Card head-->
                            <div class="card-header card-header-stretch">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Mula Memohon</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Card head-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                <form class="form" action="{{ route('pemohon.permohonan.index') }}" method="POST" id="pilih_kursus">
                                    @csrf
                                    <div class="mb-10">
                                        <label for="exampleFormControlInput1" class="form-label">Pilihan Kursus</label>
                                        <select class="form-select" name="kursus">
                                            <option>Sila Pilih</option>
                                            @foreach ($kursus_pilihan as $kursus)
                                            <option value="{{ $kursus->kursus_id }}">{{ $kursus->kursus->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer d-flex justify-content-center py-6">
                                <button type="submit" class="btn btn-primary" form="pilih_kursus">Memohon Sekarang</button>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Timeline-->
                    </div>
                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
