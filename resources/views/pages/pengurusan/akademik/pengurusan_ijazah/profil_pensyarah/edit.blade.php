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
                            <div class="row fv-row mb-2" >
                                <form class="form" action="{{ $action }}" method="post">
                                    @csrf
                                    @if($model->id) @method('PUT') @endif
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('nama_pensyarah', 'Nama Pensyarah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('nama_pensyarah', $model->lecturer_name ?? null,['class' => 'form-control form-control-sm '.($errors->has('nama_pensyarah') ? 'is-invalid':''), 'id' =>'nama_pensyarah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('nama_pensyarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('id_pensyarah', 'ID Pensyarah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('id_pensyarah', $model->lecturer_id ?? null,['class' => 'form-control form-control-sm '.($errors->has('id_pensyarah') ? 'is-invalid':''), 'id' =>'id_pensyarah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('id_pensyarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2">
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('jantina', 'Jantina', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            {{ Form::select('jantina', $genders, $model->gender, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ', 'data-control'=>'select2']) }}
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2">
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('warganegara', 'Jenis Kewarganegaraan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            {{ Form::select('warganegara', $nationalities, $model->nationality, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ', 'data-control'=>'select2']) }}
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('jawatan', 'Jawatan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('jawatan', $model->designation ?? null,['class' => 'form-control form-control-sm '.($errors->has('jawatan') ? 'is-invalid':''), 'id' =>'jawatan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('jawatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('gred', 'Gred', ['class' => 'fs-7 fw-semibold  form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('gred', $model->gred ?? null,['class' => 'form-control form-control-sm '.($errors->has('gred') ? 'is-invalid':''), 'id' =>'gred','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('gred') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('alamat_1', 'Alamat 1', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('alamat_1', $model->address_1 ?? null ,['class' => 'form-control form-control-sm '.($errors->has('alamat_1') ? 'is-invalid':''), 'id' =>'alamat_1','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('alamat_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('alamat_2', 'Alamat 2', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('alamat_2', $model->address_2 ?? null ,['class' => 'form-control form-control-sm '.($errors->has('alamat_2') ? 'is-invalid':''), 'id' =>'alamat_2','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('alamat_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('poskod', 'Poskod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('poskod', $model->postcode ?? null ,['class' => 'form-control form-control-sm '.($errors->has('poskod') ? 'is-invalid':''), 'id' =>'poskod','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('poskod') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('bandar', 'Bandar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('bandar', $model->city ?? null ,['class' => 'form-control form-control-sm '.($errors->has('bandar') ? 'is-invalid':''), 'id' =>'bandar','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('bandar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('negeri', 'Negeri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('negeri', $model->state ?? null ,['class' => 'form-control form-control-sm '.($errors->has('negeri') ? 'is-invalid':''), 'id' =>'negeri','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('negeri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('emel', 'Alamat Emel', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('emel', $model->email ?? null ,['class' => 'form-control form-control-sm '.($errors->has('emel') ? 'is-invalid':''), 'id' =>'emel','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('emel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('phone', 'No. Telefon (Bimbit)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('phone', $model->phone ?? null ,['class' => 'form-control form-control-sm '.($errors->has('phone') ? 'is-invalid':''), 'id' =>'phone','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('phone', 'No. Telefon (Rumah)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('home', $model->home ?? null ,['class' => 'form-control form-control-sm '.($errors->has('home') ? 'is-invalid':''), 'id' =>'home','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('home') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('office', 'No. Telefon (Pejabat)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('office', $model->office ?? null,['class' => 'form-control form-control-sm '.($errors->has('office') ? 'is-invalid':''), 'id' =>'office','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('office') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index') }}" class="btn btn-sm btn-light">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <h5 class="fw-bold">Fail-fail Dokumen Tambahan</h5>
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahFail" class="btn btn-sm btn-primary fw-bold" title="Tambah Fail Hebahan Aktiviti">
                                        <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah Dokumen Tambahan
                                    </a>
                                </div>
                            </div>
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tambahFail" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah Dokumen Tambahan</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.upload_file', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('file_name', 'Nama Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('file_name', old('file_name'),['class' => 'form-control form-control-sm '.($errors->has('file_name') ? 'is-invalid':''), 'id' =>'file_name','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('file_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('file', 'Pilih Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <input type="file" name="file" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            Simpan
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function remove(id){
            Swal.fire({
                title: 'Are you sure you want to delete this file?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
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
                        document.getElementById(`delete-${id}`).submit();
                    }
                })
        }

        const { createApp } = Vue

        createApp({
        data() {
            return {}
        },
        methods: {
            addNewField() {
                this.fields.push({
                    file_name: '',
                    file: '',
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
        },
        
    }).mount('#advanceSearch')


    </script>

    {!! $dataTable->scripts() !!}

@endpush