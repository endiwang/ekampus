@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
             <!--begin::Row-->
             <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.jemputan.jemputan_majlis.index')}}" method="get">
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('carian', 'Maklumat Carian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('carian', Request::get('carian') ,['class' => 'form-control form-control-sm', 'id' =>'program_pengajian','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3">
                                                <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                            </button>
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.jemputan.jemputan_majlis.index') }}" class="btn btn-sm btn-light">Set Semula</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body py-5">
                            
                            <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.jemputan.jemputan_majlis.store')}}" method="post">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-2 text-md-end">
                                        {{ Form::label('tetapan_majlis_id', 'Majlis', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-5">
                                        <div class="w-100">
                                            {{ Form::select('tetapan_majlis_id', $majlis, old('tetapan_majlis_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('tetapan_majlis_id') ? 'is-invalid':''),'id'=>'tetapan_majlis_id' ]) }}
                                            @error('tetapan_majlis_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-2 text-md-end">
                                        {{ Form::label('template_id', 'Template Jemputan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-5">
                                        <div class="w-100">
                                            {{ Form::select('template_id', $template, old('template_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('template_id') ? 'is-invalid':''),'id'=>'template_id' ]) }}
                                            @error('template_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <a class="btn btn-sm btn-light me-3 btn-pilih" id="btn-pilih">Pilih Semua atau Reset</a>
                                        </div>
                                    </div>
                                </div>
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded', 'id'=>'senarai-table']) }}

                            <div class="card mt-2">
                                <div class="card-body py-5">
                                    
                                    <div class="row">
                                        <div class="col-md-3 offset-md-10">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Jana
                                                </button>
                                                <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.jemputan.jemputan_majlis.index') }}" class="btn btn-light btn-sm">Batal</a>
                                            </div>
                                        </div>
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
    {!! $dataTable->scripts() !!}

<script>
$().ready(function(){
    var table = window.LaravelDataTables['senarai-table'];

    $('#btn-pilih').click(function(){
        var checkboxes = table.column('select:name').nodes().to$();
        checkboxes.prop('checked', this.checked);
        // Handle parent elements
        checkboxes.closest('tr').toggleClass('selected', this.checked);
   });
   
})
    


</script>
@endpush
