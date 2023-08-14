@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <form class="form" action="{{ $action }}" method="post">
                    @csrf
                    @if($model->id) @method('PUT') @endif
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page_title }}</h3>
                        </div>
                        <div class="card-body py-5">
                            <h5 class="fw-bold m-0">Maklumat Am</h5>
                            <br>
                            <div class="row fv-row mb-2">
                                <!--begin::Label-->
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gambar', 'Gambar', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                </div>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-md-9">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{URL::asset('assets/media/svg/avatars/blank.svg')}}')">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{URL::asset('assets/media/avatars/300-1.jpg')}})"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Tukar gambar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="avatar"  accept=".png, .jpg, .jpeg">
                                           
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
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama', 'Nama Penuh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama', $model->nama ?? old('nama'),['class' => 'form-control form-control-sm '.($errors->has('nama') ? 'is-invalid':''), 'id' =>'nama','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_ic', 'No. Kad Pengenalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_ic', $model->no_ic ?? old('no_ic'),['class' => 'form-control form-control-sm '.($errors->has('no_ic') ? 'is-invalid':''), 'id' =>'no_ic','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_ic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat', 'Alamat Surat-menyurat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat',$model->alamat,['class' => 'form-control form-control-sm'.($errors->has('nama') ? 'is-invalid':''), 'rows'=>'4']) }}
                                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_tel', 'No Telefon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_tel', $model->no_tel ?? old('no_tel'),['class' => 'form-control form-control-sm '.($errors->has('no_tel') ? 'is-invalid':''), 'id' =>'no_tel','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_tel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jantina', 'Jantina', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jantina', $genders, $model->jantina, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('jantina') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('jantina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('email', 'Alamat Emel', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('email', $model->email ?? old('email'),['class' => 'form-control form-control-sm '.($errors->has('email') ? 'is-invalid':''), 'id' =>'email','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body py-5">
                            <br/>
                            <h5 class="fw-bold m-0">Maklumat Kerja</h5>
                            <br/>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pusat_pengajian', 'Pusat Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('pusat_pengajian', $centers, $model->pusat_pengajian_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('pusat_pengajian') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('pusat_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jabatan', 'Jabatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('jabatan', $departments, $model->jabatan_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('jabatan') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_jawatan', 'Nama Jawatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_jawatan', $model->jawatan ?? old('nama_jawatan'),['class' => 'form-control form-control-sm '.($errors->has('nama_jawatan') ? 'is-invalid':''), 'id' =>'nama_jawatan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_jawatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gred', 'Gred Jawatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('gred', $greds, $model->gred, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('gred') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('gred') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            @if(!empty($model->id))
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jawatan', 'Jawatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <!--begin::Col-->
                                    <div class="col-md-9">
                                        <label class="form-check form-check-custom form-check-inline mb-2">
                                            <input class="form-check-input" name="is_pensyarah" type="checkbox" value="Y" @if(!empty($is_pensyarah) && $is_pensyarah == 'Y') checked @endif/>
                                            <span class="fw-semibold ps-2 fs-7 text-capitalize">Pensyarah</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-inline mb-2">
                                            <input class="form-check-input" name="is_tutor" type="checkbox" value="Y" @if(!empty($is_tutor) && $is_tutor == 'Y') checked @endif/>
                                            <span class="fw-semibold ps-2 fs-7 text-capitalize">Tutor</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-inline mb-2">
                                            <input class="form-check-input" name="is_warden" type="checkbox" value="Y" @if(!empty($is_warden) && $is_warden == 'Y') checked @endif/>
                                            <span class="fw-semibold ps-2 fs-7 text-capitalize">Penyelia Kolej Kediaman</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-inline mb-2">
                                            <input class="form-check-input" name="is_hep" type="checkbox" value="Y" @if(!empty($is_hep) && $is_hep == 'Y') checked @endif/>
                                            <span class="fw-semibold ps-2 fs-7 text-capitalize">Pegawai HEP</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-inline mb-2">
                                            <input class="form-check-input" name="is_pensyarah_tasmik" type="checkbox" value="Y" @if(!empty($is_pensyarah_tasmik) && $is_pensyarah_tasmik == 'Y') checked @endif/>
                                            <span class="fw-semibold ps-2 fs-7 text-capitalize">Pensyarah Tasmik</span>
                                        </label>
                                        
                                    </div>
                                    <!--end::Col-->
                                </div>
                            @else
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jawatan', 'Jawatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <!--begin::Col-->
                                    <div class="col-md-9">
                                        @foreach ($role_child_kakitangan as $role)
                                        <label class="form-check form-check-custom form-check-inline mb-2">
                                            <input class="form-check-input" name="jawatan[]" type="checkbox" value="{{ $role->id }}" @if(!empty($assignation)) checked @endif/>
                                            <span class="fw-semibold ps-2 fs-7 text-capitalize">{{ $role->display_name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <!--end::Col-->
                                </div>
                            @endif
                           
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::checkbox('status', '0', ($model->status == 0 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
                                            <span class="form-check-label fs-7 fw-semibold mt-2">
                                                Aktif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.guru_tasmik.index') }}" class="btn btn-sm btn-light">Batal</a>
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

@push('scripts')

@endpush