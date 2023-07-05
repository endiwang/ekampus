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
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pelajar', 'Nama Pelajar [ No Matrik ]', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="pelajar" id="status">
                                        <option value="">Pilih Pelajar</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}" @if(!empty($model->pelajar->id) && $student->id == $model->pelajar->id) selected @endif>{{ $student->nama . '[' . $student->no_matrik . ']' }}</option>
                                        @endforeach
                                    </select>
                                    @error('pelajar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('juzuk', 'Juzuk', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('juzuk', $model->juzuk ?? old('juzuk') ,['class' => 'form-control form-control-sm', 'id' =>'juzuk','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('juzuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('ayat', 'Ayat', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('ayat', $model->ayat ?? old('ayat') ,['class' => 'form-control form-control-sm', 'id' =>'ayat','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('ayat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('mukasurat_semasa', 'Muka Surat Semasa', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('mukasurat_semasa', $model->current_page ?? old('mukasurat_semasa') ,['class' => 'form-control form-control-sm', 'id' =>'mukasurat_semasa','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('mukasurat_semasa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('mukasurat_sepatutnya', 'Mukasurat Sepatutnya', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('mukasurat_sepatutnya', $model->designated_page ?? old('mukasurat_sepatutnya') ,['class' => 'form-control form-control-sm', 'id' =>'mukasurat_sepatutnya','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('mukasurat_sepatutnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('baki', 'Baki', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('baki', $model->balance ?? old('baki') ,['class' => 'form-control form-control-sm', 'id' =>'baki','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('baki') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            @if(!empty($model->current_percentage))
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('current_percentage', 'Peratus Pencapaian Semasa', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-8">
                                    <div class="w-100">
                                        {{ Form::text('current_percentage', $model->current_percentage,['class' => 'form-control form-control-sm disabled', 'id' =>'current_percentage','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="w-100">
                                        <p class="mt-1">%</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.rekod_tahriri.index') }}" class="btn btn-sm btn-light">Batal</a>
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
