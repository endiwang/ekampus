@extends('layouts.master.main')
@section('css')
<style>
table, th, td {
  vertical-align: top;
  text-align: left;
}
@media print {
          @page {
            margin:1cm !important;
          }
}
</style>
@endsection
@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Aduan Penyelenggaraan</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Aduan Penyelenggaraan</li>

            </ul>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('aduan_penyelenggaraan.create') }}" class="btn btn-sm btn-primary fw-bold">
                <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
                    <i class="fa fa-plus-circle"></i>
                </span>Tambah Aduan
            </a>
        </div>
    </div>
</div>
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <!-- SEARCH -->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
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
    const { createApp } = Vue

    createApp({
    data() {
        return {
            show_section_1: true,
            show_section_2: false,
        }
    },
    methods: {
            viewMore(){
                this.show_section_1 = false;
                this.show_section_2 = true;
            },
            hideMore(){
                this.show_section_1 = true;
                this.show_section_2 = false;
            },
        },
    mounted() {

        },
    }).mount('#advanceSearch')

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
                console.log(data);
               $('#showAduanPenyelenggaraan').find('.modal-body').html(data);
            },
            error: function (data) {
                //                
            }
        });
    })
</script>

{!! $dataTable->scripts() !!}

@endpush
