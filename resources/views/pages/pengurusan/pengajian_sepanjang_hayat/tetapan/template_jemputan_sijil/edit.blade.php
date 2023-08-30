@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.update',$template->id)}}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('name', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('name',$template->name,['class' => 'form-control form-control-sm '.($errors->has('name') ? 'is-invalid':''), 'id' =>'name','autocomplete' => 'off']) }}
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('majlis_id', 'Majlis', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('majlis_id', $majlis_selection, $template->majlis_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('majlis_id') ? 'is-invalid':''),'id'=>'majlis_id' ]) }}
                                            @error('majlis_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('template', 'Template Sijil Tahfiz', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <!--begin::Alert-->
                                        <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10">
                                            <!--begin::Icon-->
                                            <i class="fa fa-exclamation fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            <!--end::Icon-->

                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                                <!--begin::Title-->
                                                <h5 class="mb-1">Notis Penggunaan</h5>
                                                <!--end::Title-->

                                                <!--begin::Content-->
                                                <span>Gunakan tag <b class="info">{NamaMajlis}</b> atau <b class="info">{LokasiMajlis}</b> atau <b class="info">{TarikhMajlis}</b>atau <b class="info">{MasaMajlis}</b>atau <b class="info">{PegawaiUntukDihubungi}</b>
                                                     bagi menggantikan Nama Majlis, Lokasi Majlis, Tarikh Majlis, Masa Majlis dan Pegawai untuk Dihubungi pada template jemputan.</span>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Alert-->
                                        <div class="w-100">
                                            <textarea class="{{ ($errors->has('template') ? 'is-invalid':'') }}" id="kt_docs_tinymce_basic" name="template">{{ $template->template }}</textarea>
                                            @error('template') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Permohonan Ujian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', 1, ($template->status == 0 ? 0:1), ['class' => 'form-check-input h-25px w-60px mt-1']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Aktif
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Batal</a>
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
<script>
    tinymce.init({
        selector: "#kt_docs_tinymce_basic", height : "300",
        plugins: "a11ychecker advcode advlist advtable anchor autocorrect autolink autoresize casechange charmap checklist code directionality editimage export footnotes formatpainter fullscreen help image importcss inlinecss insertdatetime link linkchecker lists media mediaembed mergetags nonbreaking pagebreak pageembed permanentpen powerpaste preview quickbars save searchreplace table tinycomments tinydrive tinymcespellchecker typography visualblocks visualchars wordcount",
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | indent outdent | image',
    });
</script>

@endpush
