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
                                    {{ Form::label('surah', 'Surah', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('surah', $model->surah ?? old('surah') ,['class' => 'form-control form-control-sm', 'id' =>'surah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('surah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
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
                                    {{ Form::label('ayat_akhir', 'Ayat Akhir', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('ayat_akhir', $model->ayat_akhir ?? old('ayat') ,['class' => 'form-control form-control-sm', 'id' =>'ayat_akhir','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('ayat_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('mukasurat_mula', 'Muka Surat Mula', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('mukasurat_mula', $model->page_start ?? old('mukasurat_mula') ,['class' => 'form-control form-control-sm', 'id' =>'mukasurat_mula','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('mukasurat_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('mukasurat_akhir', 'Muka surat Akhir', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('mukasurat_akhir', $model->page_end ?? old('mukasurat_akhir') ,['class' => 'form-control form-control-sm', 'id' =>'mukasurat_akhir','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('mukasurat_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jumlah_mukasurat', 'Jumlah Muka Surat', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('jumlah_mukasurat', $model->total_page ?? old('jumlah_mukasurat') ,['class' => 'form-control form-control-sm', 'id' =>'jumlah_mukasurat','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jumlah_mukasurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index') }}" class="btn btn-sm btn-light">Batal</a>
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
