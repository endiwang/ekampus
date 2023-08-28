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
                                        <td>Tajuk Borang Temuduga</td>
                                        <td></td>
                                        <td>Program Pengajian</td>
                                        <td>Pensijilan Tahfiz al-Quran JAKIM-IIUM</td>
                                    </tr>
                                    <tr>
                                        <td>Pusat Temuduga</td>
                                        <td></td>
                                        <td>Tarikh & Masa</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Tempat Temuduga</td>
                                        <td></td>
                                        <td>Alamat Tempat Temuduga</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Ketua Penemuduga</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pelajar</td>
                                        <td>{{ $model->nama ?? null }}</td>
                                        <td>No. Kad Pengenalan</td>
                                        <td>{{ $model->ic_no ?? null }}</td>
                                    </tr>
                                </tbody>    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.peperiksaan.penilaian_lain.update', $id)}}" method="get">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kemaskini Markah</h3>
                            </div>
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('syafawi', 'Al-Quran Syafawi 100/100', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('syafawi', $model->markahPermohonan->al_quran_syafawi ??  '0.00',['class' => 'form-control form-control-sm', 'id' =>'syafawi','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahriri', 'Al-Quran Tahriri 80/80', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tahriri', $model->markahPermohonan->al_quran_tahriri ??  '0.00' ,['class' => 'form-control form-control-sm', 'id' =>'no_ic','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajwid', 'Tajwid 20/20', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tajwid', $model->markahPermohonan->tajwid ??  '0.00' ,['class' => 'form-control form-control-sm', 'id' =>'no_matrik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('fiqh', 'Fiqh 40/40', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('fiqh', $model->markahPermohonan->fiqh ??  '0.00' ,['class' => 'form-control form-control-sm', 'id' =>'fiqh','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
                                            <a href="{{ route('pengurusan.peperiksaan.kemaskini_markah.show', $id) }}" class="btn btn-sm btn-light">Set Semula</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Row-->

        </div>
    </div>
@endsection
