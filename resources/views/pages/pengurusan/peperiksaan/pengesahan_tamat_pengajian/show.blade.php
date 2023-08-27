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
                        <div class="card-body py-5">
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody>
                                    <tr>
                                        <td>Nama Pelajar</td>
                                        <td>{{ $model->nama ?? null }}</td>
                                        <td>Program</td>
                                        <td>{{ $model->kursus->nama ?? null }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. KP</td>
                                        <td>{{ $model->no_ic ?? null }}</td>
                                        <td>Sesi Kemasukan</td>
                                        <td>{{ $model->sesi->nama ?? null }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Matrik</td>
                                        <td>{{ $model->no_matrik ?? null }}</td>
                                        <td>Jam Kredit</td>
                                        <td>{{ $model->jam_kredit ?? null }}</td>
                                    </tr>
                                    <tr>
                                        <td>Semester</td>
                                        <td>{{ $model->semester ?? null }}</td>
                                        <td>Guru Tasmik</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Status Belajar</td>
                                        <td>
                                            @if($model->is_tamat == 1)
                                                TAMAT PENGAJIAN
                                            @else
                                                DALAM PENGAJIAN
                                            @endif
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        @if($model->is_tamat != 1)
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-end">
                                <a class="btn btn-sm btn-primary" onclick="validate({{ $model->id }})" data-bs-toggle="tooltip" title="Sah Tamat Belajar">
                                    Sah Tamat Belajar
                                </a>
                                <form id="validate-{{ $model->id }}" action="{{ route('pengurusan.peperiksaan.pengesahan_tamat_pengajian.validate_student', $model->id) }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                    <input type="hidden" name="_method" value="POST">
                                </form>
                            </div>
                        </div>
                        @endif
                        <div class="card-body py-5">
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!--end::Row-->
            <div class="modal fade modal-lg" tabindex="-1" id="no_matrik">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" form="tamat_pengajian" class="btn btn-primary" data-bs-dismiss="modal">Kemaskini</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Row - all semester data-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Semester dan Subjek yang Telah diambil</h3>
                        </div>
                        <div class="card-body py-5">
                            @forelse ($all_semesters as $semester)
                            <p>Semester : {{ $semester->semester ?? null }} / Sesi : {{ $semester->sesi->nama ?? null }}</p>
                            <table class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <td>Bil</td>
                                        <td>Subjek</td>
                                        <td>Kod Subjek</td>
                                        <td class="text-center">Jam Kredit</td>
                                        <td class="text-center">Mata</td>
                                        <td class="text-center">Gred</td>
                                        <td class="text-center">Markah</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $bil = 1; @endphp
                                    @forelse ($semester->pelajarSemesterDetails as $detail)
                                    <tr>
                                        <td>{{ $bil++ }}</td>
                                        <td>{{ $detail->subjek->nama ?? null }}</td>
                                        <td>{{ $detail->subjek->kod_subjek ?? null }}</td>
                                        <td class="text-center">{{ $detail->subjek->kredit ?? null }}</td>
                                        <td class="text-center">{{ !empty($detail->pointer) ? number_format($detail->pointer,2) : null }}</td>
                                        <td class="text-center">{{ $detail->gred ?? null }}</td>
                                        <td class="text-center">{{ !empty($detail->pointer) ? number_format($detail->markah,2) : null }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tiada Maklumat</td>
                                    </tr>
                                    @endforelse 
                                    <tr>
                                        <td colspan="3" style="text-align: right;">Jam kredit bagi (TD, TK & TL) tidak dikira sebagai jumlah Jam Kredit</td>
                                        <td class="text-center">{{ $semester->jam_kredit_keseluruhan ?? '0'}}</td>
                                        <td class="text-center">{{ $semester->jam_markah_keseluruhan ?? '0' }}</td>
                                        <td colspan="2" style="color: red; text-align:right;">Jumlah GPA : {{ number_format($semester->pngk,2) ?? null }}</td>
                                    </tr>
                                </tbody>    
                            </table>
                            <hr/>
                            @empty
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody>
                                    <tr>
                                        <td class="text-center">Tiada Maklumat</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforelse
                        </div>
                        <div class="card-footer">
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody>
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td style="color: red; text-align:right;">Jumlah Jam Kredit : {{ $model->jumlah_jam_kredit ?? 0 }}</td>
                                        <td style="color: red; text-align:right;">Jumlah CGPA : {{ $model->mata_akhir ?? 0 }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row fv-row mb-2 mt-2" >
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('pengurusan.peperiksaan.pengesahan_tamat_pengajian.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function getMaklumatSubjekPelajar(d){
            var dataId = d.getAttribute("data-id");
            var pelajarId = d.getAttribute("pelajar-id");
            $.ajax({
               url: '{{ route('pengurusan.peperiksaan.pengesahan_tamat_pengajian.getMaklumatSubjekPelajar') }}',
               type: 'post',
               data: {
                            id_pelajar: pelajarId,
                            id_data: dataId,
                            _token: '{{csrf_token()}}'
                        },
               success: function(response){
                    // Add response in Modal body
                    $('.modal-body').html(response);

                    // Display Modal
                    $('#no_matrik').modal('show');
               }
            });
        }

    </script>
    <script>
        function validate(id){
            Swal.fire({
                title: 'Adakah anda pasti untuk mengesahkan pelajar ini telah tamat pengajian',
                text: 'Tindakan ini tidak boleh dibatalkan',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Sah',
                reverseButtons: true,
                customClass: {
                    title: 'swal-modal-delete-title',
                    htmlContainer: 'swal-modal-delete-container',
                    cancelButton: 'btn btn-light btn-sm mr-1',
                    confirmButton: 'btn btn-primary btn-sm ml-1'
                },
                buttonsStyling: false
            })
                .then((result) => {
                    if(result.isConfirmed){
                        console.log(`validate-${id}`);
                        document.getElementById(`validate-${id}`).submit();
                    }
                })
        }
    </script>

    {!! $dataTable->scripts() !!}

@endpush
