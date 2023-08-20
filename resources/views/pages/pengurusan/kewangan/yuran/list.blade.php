@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <!-- SEARCH -->
                <div class="card" id="advanceSearch">
                    <div class="card-body py-5">
                        <form id="kt_ecommerce_settings_general_form" class="form" action="#">
                            <div class="row mb-2">
                                {{ Form::label('maklumat_carian', 'Maklumat Carian', ['class' => 'col-lg-4 fs-6 fw-semibold form-label mt-2']) }}                                
                                <div class="col-lg-8">
                                    <div class="d-flex">
                                        {{ Form::text('maklumat_carian','',['class' => 'form-control me-3 form-control-sm', 'id' => 'maklumat_carian']) }}
                                        <button type="button" id="btnFilter" class="btn btn-success btn-sm fw-bold flex-shrink-0"><i class="fa fa-search" style="vertical-align: initial"></i>Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection

@push('scripts')
<script>
    
    $('#btnFilter').on('click', function(){
        $('#dataTableBuilder').DataTable().ajax.reload();
    })
</script>
{!! $dataTable->scripts() !!}
@endpush
