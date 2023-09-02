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
                                        <td>{{ $current_sem->semester_no ?? null }}</td>
                                        <td>Guru Tasmik</td>
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
                        <div class="card-body py-5">
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <div class="modal fade modal-lg" tabindex="-1" id="maklumatPelajar">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" form="no_matrik" class="btn btn-primary" data-bs-dismiss="modal">Kemaskini</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function getMaklumatSubjekPelajar(d){
            var dataId = d.getAttribute("data-id");
            var pelajarId = d.getAttribute("pelajar-id");
            $.ajax({
               url: '{{ route('pengurusan.peperiksaan.calon_peperiksaan.getMaklumatSubjekPelajar') }}',
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
                    $('#maklumatPelajar').modal('show');
               }
            });
        }

    </script>

    {!! $dataTable->scripts() !!}

@endpush
