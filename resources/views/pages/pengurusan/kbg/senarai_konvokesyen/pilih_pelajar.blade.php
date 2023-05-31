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

        <div class="row g-5 g-xl-10 mb-3 mb-xl-4" style="display:none">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-body py-5">
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('maklumat_carian', 'Carian Pantas', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-sm" placeholder="Tulis di sini"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0 pt-6">
                <h3 class="card-title">Maklumat Senarai Pelajar</h3>
            </div>
            <div class="card-body py-4">
                <table id="senarai_pemohon_table" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                    <thead>
                    <tr class="">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#senarai_pemohon_table .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th>Nama Pelajar</th>
                        <th>Program Pengajian</th>
                        <th>Sesi Kemasukan</th>
                        <th>No K/P</th>
                        <th>No Matrik</th>
                        <th>CGPA</th>
                    </tr>
                    </thead>
                    <tbody class="">
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-start" data-kt-docs-table-toolbar="base">
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-sm btn-secondary me-5" data-bs-toggle="tooltip" disabled>
                        <i class="fa fa-save"></i>
                        Simpan
                    </button>

                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
                        Kembali
                    </a>
                    <!--end::Add customer-->
                </div>
                <div class="d-flex justify-content-start align-items-center d-none" data-kt-docs-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-docs-table-select="selected_count"></span> Telah Dipilih
                    </div>

                    <button type="button" class="btn btn-sm btn-success me-5" data-kt-docs-table-select="simpan-selected" data-bs-toggle="tooltip" title="Simpan">
                        <i class="fa fa-save"></i>
                        Pilih
                    </button>

                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
                        Kembali
                    </a>
                </div>


            </div>
        </div>
</div>

@endsection

@push('scripts')
        <script>

// Class definition
    var KTDatatablesServerSide = function () {
        // Shared variables
        var table;
        var dt;
        var filterPayment;

        // Private functions
        var initDatatable = function () {
            dt = $("#senarai_pemohon_table").DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [[1, 'asc']],
                stateSave: false,
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    className: 'row-selected'
                },
                ajax: {
                    url: "{!! route('pengurusan.kbg.pengurusan.konvokesyen.pilih_pelajar_api', $konvo->id) !!}",
                },
                columns: [
                    { data: 'id' },
                    { data: 'nama', data:'nama', orderable: true, },
                    { data: 'kursus.nama', data:'kursus.nama', orderable: true, },
                    { data: 'sesi.nama', data:'sesi.nama', orderable: true, },
                    { data: 'no_ic', data:'no_ic', orderable: true, },
                    { data: 'no_matrik', data:'no_matrik', orderable: true, },
                    { data: 'mata_akhir', data:'mata_akhir', orderable: true, },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        render: function (data) {
                            return `
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input pemohon_checkbox" type="checkbox" value="${data}" />
                                </div>`;
                        }
                    },
                ],
                // Add data-filter attribute
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
                }
            });

            table = dt.$;

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            dt.on('draw', function () {
                initToggleToolbar();
                toggleToolbars();
                handleDeleteRows();
                KTMenu.createInstances();
            });
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = function () {
            const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                dt.search(e.target.value).draw();
            });
        }


        // Delete customer
        var handleDeleteRows = () => {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

            deleteButtons.forEach(d => {
                // Delete button on click
                d.addEventListener('click', function (e) {
                    e.preventDefault();
                    alert('ok')

                    // Select parent row
                    const parent = e.target.closest('tr');

                    // Get customer name
                    const customerName = parent.querySelectorAll('td')[1].innerText;

                })
            });
        }

        // Reset Filter
        var handleResetForm = () => {
            // Select reset button
            const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

            // Reset datatable
            resetButton.addEventListener('click', function () {
                // Reset payment type
                filterPayment[0].checked = true;

                // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                dt.search('').draw();
            });
        }

        // Init toggle toolbar
        var initToggleToolbar = function () {
            // Toggle selected action toolbar
            // Select all checkboxes
            const container = document.querySelector('#senarai_pemohon_table');
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
                    url: "{!! route('pengurusan.kbg.pengurusan.konvokesyen.store_pelajar')!!}",
                    type: "POST",
                    data: {
                                ids: id,
                                konvo_id : {!! $konvo->id !!},
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    success: function(data){
                        location.reload();
                    }
                });

            });


        }

        // Toggle toolbars
        var toggleToolbars = function () {
            // Define variables
            const container = document.querySelector('#senarai_pemohon_table');
            const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
            const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
            const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

            // Select refreshed checkbox DOM elements
            const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

            // Detect checkboxes state & count
            let checkedState = false;
            let count = 0;

            // Count checked boxes
            allCheckboxes.forEach(c => {
                if (c.checked) {
                    checkedState = true;
                    count++;
                }
            });

            // Toggle toolbars
            if (checkedState) {
                selectedCount.innerHTML = count;
                toolbarBase.classList.add('d-none');
                toolbarSelected.classList.remove('d-none');
            } else {
                toolbarBase.classList.remove('d-none');
                toolbarSelected.classList.add('d-none');
            }
        }

        // Public methods
        return {
            init: function () {
                initDatatable();
                handleSearchDatatable();
                initToggleToolbar();
                handleDeleteRows();
                // handleResetForm();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTDatatablesServerSide.init();
    });
        </script>
@endpush
