@extends('layouts.public.main_inner_pemohon')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                    <div class="col-xl-12">
                        <!--begin::Table widget 14-->
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Senarai Permohonan Yang Dihantar</span>
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
                                                <th class="p-0 pb-3 min-w-175px text-start">KURSUS & PUSAT PENGAJIAN</th>
                                                <th class="p-0 pb-3 min-w-100px text-center">SESI</th>
                                                <th class="p-0 pb-3 min-w-100px text-center">STATUS</th>
                                                <th class="p-0 pb-3 min-w-175px text-center">TINDAKAN</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @foreach ($permohonan as $data)
                                            <tr>
                                                <td>

                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $data->kursus->nama }}</a>
                                                            <span class="text-gray-400 fw-semibold d-block fs-7">{{  $data->pusat_pengajian->nama }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center pe-0">
                                                    <span class="text-gray-600 fw-bold fs-6">{{ $data->sesi->nama }}</span>
                                                </td>
                                                <td class="text-center pe-0">
                                                    @if($data->is_selected == 0 && $data->is_interview == 0 && $data->is_tawaran == 0)
                                                        <span class="badge py-3 px-4 fs-7 badge-light-primary">Berjaya Dihantar</span>
                                                    @elseif($data->is_selected == 1 && $data->is_interview == 0 && $data->is_tawaran == 0)
                                                        <span class="badge py-3 px-4 fs-7 badge-light-info">Sedang Diproses</span>
                                                    @elseif($data->is_selected == 1 && $data->is_interview == 1 && $data->is_tawaran == 0)
                                                        <span class="badge py-3 px-4 fs-7 badge-light-info">Dipanggil Temuduga</span>
                                                    @elseif($data->is_selected == 1 && $data->is_interview == 1 && $data->is_tawaran == 1)
                                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Ditawarkan</span>
                                                    @endif

                                                </td>
                                                <td class="text-center pe-0">
                                                    @if ($data->is_selected == 1 && $data->is_interview == 1 && $data->is_tawaran == 0)
                                                        <button type="button" class="btn btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="modal" data-bs-target="#maklumat_lanjut_{{ $data->id }}">
                                                            <i class="fa fa-eye"></i> Maklumat Lanjut
                                                        </button>

                                                        <div class="modal fade modal-lg" tabindex="-1" id="maklumat_lanjut_{{ $data->id }}">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title">Maklumat Lengkap Temuduga</h3>

                                                                        <!--begin::Close-->
                                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                                        </div>
                                                                        <!--end::Close-->
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="mb-10">
                                                                            <!--begin::Title-->
                                                                            <div class="fs-2 fw-bold text-gray-800 text-center mb-13">
                                                                                <span class="me-2">Tahniah!! </span> <br>
                                                                                <span class="me-2">Anda terpilih untuk menghadiri temuduga bagi kemasukan ke program : </span> <br>
                                                                                <span class="position-relative d-inline-block text-danger">
                                                                                    <span class="text-danger opacity-75-hover">{{ $data->kursus->nama }}</span>
                                                                                    <!--begin::Separator-->
                                                                                    <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                                                                    <!--end::Separator-->
                                                                                </span><br>
                                                                            </div>

                                                                            <div class="fs-3 fw-bold text-gray-800 text-left mb-13">

                                                                                <span class="me-2">Tarikh: </span>
                                                                                <span class="position-relative d-inline-block text-danger">
                                                                                    <span class="text-danger opacity-75-hover">{{ Carbon\Carbon::parse($data->proses_temuduga->tarikh)->format('d/m/Y') }}</span>
                                                                                    <!--begin::Separator-->
                                                                                    {{-- <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span> --}}
                                                                                    <!--end::Separator-->
                                                                                </span><br>
                                                                                <span class="me-2">Masa: </span>
                                                                                <span class="position-relative d-inline-block text-danger">
                                                                                    <span class="text-danger opacity-75-hover">{{ $data->proses_temuduga->masa }} {{ $data->proses_temuduga->waktu }}</span>
                                                                                    <!--begin::Separator-->
                                                                                    {{-- <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span> --}}
                                                                                    <!--end::Separator-->
                                                                                </span><br>
                                                                                <span class="me-2">Tempat Pusat Temuduga: </span><br>
                                                                                <span class="position-relative d-inline-block text-danger">
                                                                                    <span class="text-danger opacity-75-hover">{{ $data->proses_temuduga->nama_tempat }}</span>
                                                                                    <!--begin::Separator-->
                                                                                    {{-- <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span> --}}
                                                                                    <!--end::Separator-->
                                                                                </span><br>
                                                                                <span class="me-2">Alamat Pusat Temuduga: </span><br>
                                                                                <span class="position-relative d-inline-block text-danger">
                                                                                    <span class="text-danger opacity-75-hover">{{ $data->proses_temuduga->alamat_temuduga }}</span>
                                                                                    <!--begin::Separator-->
                                                                                </span><br>
                                                                            </div>
                                                                                                                                            </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @elseif($data->is_selected == 1 && $data->is_interview == 1 && $data->is_tawaran == 1)
                                                            <a href="{{ route('pemohon.tawaran.index',$data->id) }}" class="btn btn-success btn-sm hover-elevate-up mb-1">
                                                                <i class="fa fa-eye"></i> Maklumat Lanjut
                                                            </a>
                                                        @endif
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
                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>


@endsection
@section('script')

@endsection
