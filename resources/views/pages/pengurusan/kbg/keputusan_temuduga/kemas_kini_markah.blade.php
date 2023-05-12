@extends('layouts.master.main')
@section('css')
<style>
    .select-info{
        display: none
    }
</style>
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title">Maklumat Proses Temuduga</h3>
                    </div>
                    <div class="card-body py-4">

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Tajuk Borang Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ $temuduga->tajuk_borang }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Program Pengajian :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ $temuduga->kursus->nama }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Pilihan Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">@if ($temuduga->temuduga_type == 'B') Temuduga Pengambilan @elseif ($temuduga->temuduga_type == 'R') Temuduga Rayuan @else N/A @endif</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Pusat Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Tarikh Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ Carbon\Carbon::parse($temuduga->tarikh)->format('d-m-Y') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Masa Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ $temuduga->masa }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Nama Tempat Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ $temuduga->nama_tempat }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Alamat Tempat Temuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ $temuduga->alamat_temuduga }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Ketua Penemuduga :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800">{{ $temuduga->ketua->nama }}</span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-2">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold">Senarai Pemohon :</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-7 text-gray-800"></span>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="table-responsive">

                            <table id="senarai_pemohon_table" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                <thead>
                                <tr class="">
                                    <th class="w-2% pe-2">Bil</th>
                                    <th class="w-20%">Nama Pemohon</th>
                                    <th class="w-10% pe-2">L/P</th>
                                    <th class="text-center w-10%">Hafazan<br>(50%)</th>
                                    <th class="text-center w-10%">Tajwid<br>(20%)</th>
                                    <th class="text-center w-10%">Penampilan<br>(10%)</th>
                                    <th class="text-center w-10%">Pencapaian<br>Akademik<br>(20%)</th>
                                    <th class="text-center w-10%">Jumlah</th>
                                    <th class="text-center w-10%">%</th>
                                    <th class="text-center w-30%">Catatan / Ulasan
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($markah_temuduga as $index=>$data)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $data->pemohon->nama }}<br>{{ $data->pemohon->no_ic }}</td>
                                            <td>{{ $data->pemohon->jantina }}</td>
                                            <td><input type="text" size="5" name="hafazan" id="hafazan{{ $data->id }}" value="{{ $data->hafazan }}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="tajwid" id="tajwid{{ $data->id }}" value="{{ $data->tajwid}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="akhlak" id="akhlak{{ $data->id }}" value="{{ $data->akhlak}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="akademik" id="akademik{{ $data->id }}" value="{{ $data->akademik}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="jumlah" id="jumlah{{ $data->id }}" value="{{ $data->jumlah}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="percentage" id="percentage{{ $data->id }}" value="{{ $data->pcts}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" name="catatan" id="catatan{{ $data->id }}" value="{{ $data->catatan}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-start" data-kt-docs-table-toolbar="base">
                            <!--begin::Add customer-->
                            <button type="button" class="btn btn-sm btn-success me-5" data-bs-toggle="tooltip">
                                <i class="fa fa-print"></i>
                                Cetak Keputusan Temuduga
                            </button>

                            <a href="{{ route('pengurusan.kbg.pengurusan.keputusan_temuduga.index') }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
                                Kembali
                            </a>
                            <!--end::Add customer-->
                        </div>


                    </div>
                </div>
            </div>
        </div>
</div>

@endsection

@push('scripts')

<script>

function kira_markah(id)
    {
        var hafazan     =   parseInt($('#hafazan'+id).val());
        var tajwid      =   parseInt($('#tajwid'+id).val());
        var akhlak      =   parseInt($('#akhlak'+id).val());
        var akademik    =   parseInt($('#akademik'+id).val());
        var percentage  =   parseInt($('#percentage'+id).val());
        var catatan     =   parseInt($('#catatan'+id).val());

        var jumlah      = 0;

        if(hafazan > 50)

        jumlah = hafazan+tajwid+akhlak+akademik;
        $('#jumlah'+id).val(jumlah);


        console.log(hafazan)
        console.log(tajwid)
        console.log(akhlak)
        console.log(akademik)
        console.log(jumlah)
        console.log(percentage)
        console.log(catatan)
    }
</script>

@endpush
