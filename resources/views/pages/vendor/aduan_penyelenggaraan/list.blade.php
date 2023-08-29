@extends('layouts.master.main')
@section('css')
<style>
table, th, td {
  vertical-align: top;
  text-align: left;
}
</style>
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
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('status_vendor', 'Status Kerja', ['class' => 'col-lg-4 fs-6 fw-semibold form-label mt-2']) }}                                
                                <div class="col-lg-8">
                                    <div class="d-flex">
                                    {{ Form::select('status_vendor',  \App\Models\AduanPenyelenggaraan::getStatusVendorSelection(), (!empty(\Request()->stv)) ? \Request()->stv : '', ['placeholder' => 'Semua', 'class' => 'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('', '&nbsp;', ['class' => 'col-lg-4 fs-6 fw-semibold form-label mt-2']) }}                                
                                <div class="col-lg-8">
                                    <div class="d-flex">                                
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
        <!--end::Row-->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showAduanPenyelenggaraan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    var myModal = new bootstrap.Modal(document.getElementById('showAduanPenyelenggaraan'), {})
    $('table').on('click', '.btn-show-aduan', function(){
        $('#showAduanPenyelenggaraan').find('.modal-body').html('Loading...');
        myModal.show();
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(this).data('url'),
            data: {},
            success: function (data) {
                $('#showAduanPenyelenggaraan').find('.modal-body').html(data);
            },
            error: function (data) {
                //                
            }
        });
    })
    $('#btnFilter').on('click', function(){
        $('#dataTableBuilder').DataTable().ajax.reload();
    })
</script>

{!! $dataTable->scripts() !!}

@endpush
