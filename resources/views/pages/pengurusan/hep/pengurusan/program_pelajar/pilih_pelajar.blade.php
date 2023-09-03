@extends('layouts.master.main')
@section('css')
<style>
    .select-info{
        display: none
    }
</style>
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <form class="form" action="{{ route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar', $model->id)}}" method="get">
                    <div class="card">
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kursus', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kursus', $kursus, Request::get('kursus'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kursus') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sesi', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('sesi',[],Request::get('sesi') , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('sesi1') ? 'is-invalid':''),'id'=>'sesi', 'data-control'=>'select2' ]) }}
                                        @error('sesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0">
                                            <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        <a type="button" class="btn btn-sm btn-success me-5" data-kt-docs-table-select="simpan-selected" onclick="submit()" data-bs-toggle="tooltip" title="Simpan">
                            <i class="fa fa-save"></i>
                            Simpan
                        </a>

                        <a href="{{ route('pengurusan.hep.pengurusan.program_pelajar.index') }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
                            Kembali
                        </a>

                    </div>
                </div>
            </div>
        </div>
</div>



@endsection

@push('scripts')

<script>

    function submit () {
            console.log('ok')
            // Toggle selected action toolbar
            // Select all checkboxes
            const container = document.querySelector('#dataTableBuilder');
            const checkboxes = container.querySelectorAll('[type="checkbox"]');
            const processSelected = document.querySelector('[data-kt-docs-table-select="simpan-selected"]');


            // Toggle delete selected toolbar
            checkboxes.forEach(c => {
                // Checkbox on click event
                c.addEventListener('click', function () {
                    setTimeout(function () {
                        toggleToolbars();
                    }, 50);
                });
            });


            processSelected.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var id = [];
                $('.pemohon_checkbox:checked').each(function(){
                    id.push($(this).val());
                });

                $.ajax({
                    url: "{!! route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar_store',$model->id)!!}",
                    type: "POST",
                    data: {
                                ids: id,
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    success: function(data){
                        location.reload();
                    }
                });

            });


        }
    </script>

<script>
    $(document).ready(function () {
        if($("#kursus").val() != null || $("#kursus").val() != '')
        {
            $("#sesi").select2({
                ajax: {
                    url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                    type: "POST",
                    data: {
                                kursus_id: $("#kursus").val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                }
            })
        }

        $("#kursus").on('change', function(){
            var kursus_id = this.value;

            $("#sesi").val('');
            $("#sesi").select2({
                ajax: {
                    url: "{{route('pengurusan.pentadbir_sistem.permohonan_pelajar.fetchSesi')}}",
                    type: "POST",
                    data: {
                                kursus_id: kursus_id,
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                }
            })
        })
    });
    </script>

{!! $dataTable->scripts() !!}


@endpush


