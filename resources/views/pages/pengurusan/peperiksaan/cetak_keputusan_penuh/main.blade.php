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
                        <div class="card-header">
                            <h3 class="card-title">Proses Cetakan Keputusan Penuh Peperiksaan</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" width="100%">
                                    <thead class="thead-light">
                                    <!--begin::Table head-->
                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                        <th>Nama Laporan</th>
                                        <th width="2%">Tindakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $report)
                                            <tr class="fw-bold border-bottom-0">
                                                <td>{{ $report['name']}}</td>
                                                <td class="text-center">{!! $report['action'] !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->  
        </div>
    </div>
@endsection

