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
                                    <th class="pe-2">Bil</th>
                                    <th class="">Nama Pemohon</th>
                                    <th class=" pe-2">L/P</th>
                                    <th class="text-center">Hafazan<br>(50%)</th>
                                    <th class="text-center">Tajwid<br>(20%)</th>
                                    <th class="text-center">Penampilan<br>(10%)</th>
                                    <th class="text-center">Pencapaian<br>Akademik<br>(20%)</th>
                                    <th class="text-center">Jumlah<br>(100%)</th>
                                    {{-- <th class="text-center w-10%">%</th> --}}
                                    <th class="text-center">Catatan / Ulasan
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($markah_temuduga as $index=>$data)
                                        <input type="hidden" size="5" name="id" id="data_id{{ $data->id }}" value="{{ $data->id }}">

                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $data->pemohon->nama }}<br>{{ $data->pemohon->no_ic }}</td>
                                            <td>{{ $data->pemohon->jantina }}</td>
                                            <td><input type="text" size="5" name="hafazan" id="hafazan{{ $data->id }}" value="{{ $data->hafazan }}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="tajwid" id="tajwid{{ $data->id }}" value="{{ $data->tajwid}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="akhlak" id="akhlak{{ $data->id }}" value="{{ $data->akhlak}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="akademik" id="akademik{{ $data->id }}" value="{{ $data->akademik}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td>
                                            <td><input type="text" size="5" name="jumlah" id="jumlah{{ $data->id }}" value="{{ $data->jumlah}}" style="text-align:center" class="form-control form-control-sm" disabled></td>
                                            {{-- <td><input type="text" size="5" name="percentage" id="percentage{{ $data->id }}" value="{{ $data->pcts}}" style="text-align:center" class="form-control form-control-sm" onchange="kira_markah({{ $data->id }})"></td> --}}
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
        var jumlah      =   $('#jumlah'+id).val();

        var hafazan = parseInt($('#hafazan'+id).val());
        $('#hafazan'+id).val($('#hafazan'+id).val().replace(/[^0-9]/g, ''));

        if(hafazan > 50 )
        {
            alert('Hafazan tidak boleh melebihi 50%')
            $('#hafazan'+id).val(0);
            hafazan = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else if(isNaN(hafazan))
        {
            $('#hafazan'+id).val(0);
            hafazan = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);

        }else{

            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);

            $.ajax({
                    url: "{{route('pengurusan.kbg.keputusan_temuduga.store')}}",
                    type: "POST",
                    data: {
                                id: id,
                                hafazan: $('#hafazan'+id).val(),
                                tajwid: $('#tajwid'+id).val(),
                                akhlak: $('#akhlak'+id).val(),
                                akademik: $('#akademik'+id).val(),
                                jumlah: isNaN($('#jumlah'+id).val()) ? 0 :$('#jumlah'+id).val(),
                                catatan: $('#catatan'+id).val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                })

        }

        var tajwid      =   parseInt($('#tajwid'+id).val());
        $('#tajwid'+id).val($('#tajwid'+id).val().replace(/[^0-9]/g, ''));

        if(tajwid > 20 )
        {
            alert('Tajwid tidak boleh melebihi 20%')
            $('#tajwid'+id).val(0);
            tajwid = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else if(isNaN(tajwid))
        {
            $('#tajwid'+id).val(0);
            tajwid = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else{

            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);

            $.ajax({
                    url: "{{route('pengurusan.kbg.keputusan_temuduga.store')}}",
                    type: "POST",
                    data: {
                                id: id,
                                hafazan: $('#hafazan'+id).val(),
                                tajwid: $('#tajwid'+id).val(),
                                akhlak: $('#akhlak'+id).val(),
                                akademik: $('#akademik'+id).val(),
                                jumlah: isNaN($('#jumlah'+id).val()) ? 0 :$('#jumlah'+id).val(),
                                catatan: $('#catatan'+id).val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                })

            }

        var akhlak      =   parseInt($('#akhlak'+id).val());
        $('#akhlak'+id).val($('#akhlak'+id).val().replace(/[^0-9]/g, ''));

        if(akhlak > 10 )
        {
            alert('Akhlak tidak boleh melebihi 10%')
            $('#akhlak'+id).val(0);
            akhlak = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else if(isNaN(akhlak))
        {
            $('#akhlak'+id).val(0);
            akhlak = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else{

            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);

            $.ajax({
                    url: "{{route('pengurusan.kbg.keputusan_temuduga.store')}}",
                    type: "POST",
                    data: {
                                id: id,
                                hafazan: $('#hafazan'+id).val(),
                                tajwid: $('#tajwid'+id).val(),
                                akhlak: $('#akhlak'+id).val(),
                                akademik: $('#akademik'+id).val(),
                                jumlah: isNaN($('#jumlah'+id).val()) ? 0 :$('#jumlah'+id).val(),
                                catatan: $('#catatan'+id).val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                })

            }

        var akademik    =   parseInt($('#akademik'+id).val());
        $('#akademik'+id).val($('#akademik'+id).val().replace(/[^0-9]/g, ''));

        if(akademik > 20 )
        {
            alert('Akademik tidak boleh melebihi 20%')
            $('#akademik'+id).val(0);
            akademik = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else if(isNaN(akademik))
        {
            $('#akademik'+id).val(0);
            akademik = 0;
            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);


        }else{

            jumlah      =   hafazan+tajwid+akhlak+akademik;
            $('#jumlah'+id).val(jumlah);

            $.ajax({
                    url: "{{route('pengurusan.kbg.keputusan_temuduga.store')}}",
                    type: "POST",
                    data: {
                                id: id,
                                hafazan: $('#hafazan'+id).val(),
                                tajwid: $('#tajwid'+id).val(),
                                akhlak: $('#akhlak'+id).val(),
                                akademik: $('#akademik'+id).val(),
                                jumlah: isNaN($('#jumlah'+id).val()) ? 0 :$('#jumlah'+id).val(),
                                catatan: $('#catatan'+id).val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                })

            }
    }


</script>

@endpush
