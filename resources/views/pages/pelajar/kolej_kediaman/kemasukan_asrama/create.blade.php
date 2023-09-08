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
                        <h3 class="card-title">{{ $page_title }}</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card" id="formPermohonanG">
                                <div class="card-header border-0">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-dark">PERAKUAN PELAJAR</span>
                                    </h3>
                                </div>
                                <div id="kt_account_settings_profile_details" class="collapse show">
                                    {{-- <form id="kt_account_profile_details_form" class="form"> --}}
                                        <div class="card-body border-top p-9">

                                            <div class="row mb-6">
                                                <div class="col-lg-12">
                                                    {{ Form::label('', 'Sila tandakan kotak ini jika anda sudah mengemaskini profil anda.', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <div class="col-lg-12">
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        {{-- {{ Form::checkbox('status_'.$permohonan_data->id, '1', false, ['class' => 'form-check-input h-25px w-60px','id'=>'status_'.$permohonan_data->id, 'onclick' => 'status'.$permohonan_data->id.'()' ]); }} --}}
                                                        <input class="form-check-input" id="status_profile"  name="status_profile" type="checkbox" value="1"/>
                                                        <span class="form-check-label fs-6 fw-semibold ">
                                                            Saya mengaku bahawa semua maklumat peribadi saya telah dikemaskini. Saya akui bahawa pihak Darul Quran berhak menolak permohonan ini sekiranya mana-mana maklumat didapati tidak benar.                            </span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-11 offset-md-1">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Hantar
                                        </button>
                                        <a href="{{ route('pelajar.permohonan.kemasukan_asrama.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')

@endpush
