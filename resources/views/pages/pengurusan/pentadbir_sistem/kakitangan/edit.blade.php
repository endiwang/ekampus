@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Maklumat Kakitangan</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <form id="kt_account_profile_details_form" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            {{ Form::label('gambar', 'Gambar', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}

                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{URL::asset('assets/media/svg/avatars/blank.svg')}}')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{URL::asset('assets/media/avatars/300-1.jpg')}})"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Tukar gambar">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('nama', 'Nama Penuh', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::text('nama',$staff->nama,['class' => 'form-control form-control-sm']) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('no_ic', 'No Mykad / Kad Pengenalan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::text('no_ic',$staff->no_ic,['class' => 'form-control form-control-sm']) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('alamat', 'Alamat', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::textarea('alamat',$staff->alamat,['class' => 'form-control form-control-sm', 'rows'=>'4']) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('no_tel', 'No Telefon', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::number('no_tel',$staff->no_tel,['class' => 'form-control form-control-sm']) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('emeil', 'Emel', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::email('emeil',$staff->email,['class' => 'form-control form-control-sm']) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('pusat_pengajian', 'Pusat Pengajian', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::select('pusat_pengajian', $pusat_pengajian, $staff->pusat_pengajian_id , ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm fw-semibold '.($errors->has('pusat_pengajian') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('jabatan', 'Jabatan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::select('jabatan', $jabatan,$staff->jabatan_id, ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm fw-semibold '.($errors->has('jabatan') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-2">
                            <!--begin::Label-->
                            {{ Form::label('gred', 'Gred', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                {{ Form::text('gred',$staff->gred,['class' => 'form-control form-control-sm']) }}
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-1">
                            <!--begin::Label-->
                            {{ Form::label('jawatan', 'Jawatan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <label class="form-check form-check-custom form-check-inline">
                                    <input class="form-check-input" name="jawatan[]" type="checkbox" value="1" @if($staff->is_pensyarah == 'Y') checked @endif>
                                    <span class="fw-semibold ps-2 fs-7">Pensyarah</span>
                                </label>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="offset-lg-4 col-lg-8">
                                <label class="form-check form-check-custom form-check-inline">
                                    <input class="form-check-input" name="jawatan[]" type="checkbox" value="1" @if($staff->is_guru_tasmik == 'Y') checked @endif/>
                                    <span class="fw-semibold ps-2 fs-7">Pensyarah Tasmik</span>
                                </label>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="offset-lg-4 col-lg-8">
                                <label class="form-check form-check-custom form-check-inline">
                                    <input class="form-check-input" name="jawatan[]" type="checkbox" value="1" @if($staff->is_guru_tasmik_jemputan == 'Y') checked @endif/>
                                    <span class="fw-semibold ps-2 fs-7">Pensyarah Tasmik Jemputan</span>
                                </label>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="offset-lg-4 col-lg-8">
                                <label class="form-check form-check-custom form-check-inline">
                                    <input class="form-check-input" name="jawatan[]" type="checkbox" value="1" @if($staff->is_warden == 'Y') checked @endif/>
                                    <span class="fw-semibold ps-2 fs-7">Warden</span>
                                </label>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-1">
                            <!--begin::Col-->
                            <div class="offset-lg-4 col-lg-8">
                                <label class="form-check form-check-custom form-check-inline">
                                    <input class="form-check-input" name="jawatan[]" type="checkbox" value="1" @if($staff->is_tutor == 'Y') checked @endif/>
                                    <span class="fw-semibold ps-2 fs-7">Tutor</span>
                                </label>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-0">
                            <!--begin::Label-->
                            {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                    {{ Form::checkbox('status', '0', true, ['class' => 'form-check-input h-25px w-60px']); }}
                                    <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                </div>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                        </button>
                        <a href="{{ route('pengurusan.pentadbir_sistem.kakitangan.index') }}" class="btn btn-light btn-sm">Batal</a>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Basic info-->
    </div>
</div>
@endsection
@section('script')
<script>



    function submitMe(){
        var checked_ids = [];
        $("#kt_docs_jstree_basic").jstree("get_checked",null,true).each
            (function () {
                checked_ids.push(this.id);
            });
           console.log(checked_ids)
        }


    </script>

    <script>
        jQuery(function ($) {
        $('#kt_docs_jstree_basic').jstree({

            "core": { "check_callback": false },

            "checkbox": { "keep_selected_style": false, "three_state": false, "tie_selection": false, "whole_node": false, },

            "plugins": ["checkbox"]

        }).bind("ready.jstree", function (event, data) {

            $(this).jstree("open_all");

        }).on("check_node.jstree uncheck_node.jstree", function (e, data) {

            var currentNode = data.node;

            var parent_node = $('#kt_docs_jstree_basic').jstree().get_node(currentNode).parents;

            console.log(currentNode);
            console.log(parent_node);

            if (data.node.state.checked)
                $('#kt_docs_jstree_basic').jstree().check_node(parent_node[0]);
            else
                $('#kt_docs_jstree_basic').jstree().uncheck_node(parent_node[0]);
        })

        });
    </script>
@endsection

@push('scripts')




@endpush
