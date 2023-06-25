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
                            <hr>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('hafazan_sehingga', 'Hafazan Sehingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    
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
                                    {{ Form::label('maqra', 'maqra', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('maqra', $model->maqra ?? old('maqra') ,['class' => 'form-control form-control-sm', 'id' =>'maqra','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('maqra') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('ayat_awal', 'Ayat Awal', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('ayat_awal', $model->ayat_awal ?? old('ayat_awal') ,['class' => 'form-control form-control-sm', 'id' =>'ayat_awal','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('ayat_awal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('ayat_akhir', 'Ayat Akhir', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('ayat_akhir', $model->ayat_akhir ?? old('ayat_akhir') ,['class' => 'form-control form-control-sm', 'id' =>'ayat_akhir','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('ayat_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('muka_surat_semasa', 'Nombor Muka Surat Semasa', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('muka_surat_semasa', $model->current_page ?? old('muka_surat_semasa') ,['class' => 'form-control form-control-sm', 'id' =>'muka_surat_semasa','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('muka_surat_semasa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('muka_surat_akhir', 'Nombor Muka Surat Akhir Ditetapkan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('muka_surat_akhir', $model->page_end ?? old('muka_surat_akhir') ,['class' => 'form-control form-control-sm', 'id' =>'muka_surat_akhir','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('muka_surat_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('catatan_tambahan', 'Catatan Tambahan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('catatan_tambahan', $model->remarks ?? old('catatan_tambahan') ,['class' => 'form-control form-control-sm', 'id' =>'catatan_tambahan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('catatan_tambahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('baki_tasmik', 'Jumlah Baki Muka Surat Yang Belum Ditasmik', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('baki_tasmik', $model->page_remaining ?? old('baki_tasmik') ,['class' => 'form-control form-control-sm', 'id' =>'baki_tasmik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('baki_tasmik') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.rekod_hafazan_shafawi.index') }}" class="btn btn-sm btn-light">Batal</a>
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
