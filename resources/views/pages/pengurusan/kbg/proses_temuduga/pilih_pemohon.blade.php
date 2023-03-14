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
                <div class="card" id="advanceSearch">
                    <div class="card-body py-5">
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('maklumat_carian', 'Carian Pantas', ['class' => 'fs-6 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid" placeholder="Tulis di sini"/>

                                {{-- <div class="d-flex">
                                    <input type="text" v-model="keyword.search" v-on:keyup.enter="search()" class="form-control me-3 form-control-sm">
                                    <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0" @click="search()">
                                        <i class="fa fa-search" style="vertical-align: initial"></i>Cari
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0 pt-6">
                <h3 class="card-title">{{ $page_title }}</h3>

                {{-- <div class="card-title"> --}}
                    {{-- <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Carian"/>
                    </div> --}}
                {{-- </div> --}}
                {{-- <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                        <!--begin::Add customer-->
                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" disabled>
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <!--end::Add customer-->
                    </div>
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-docs-table-select="selected_count"></span> Telah Dipilih
                        </div>

                        <button type="button" class="btn btn-success" data-bs-toggle="tooltip" title="Simpan">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </div> --}}
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
                        <th>Nama Pemohon</th>
                        <th>No IC</th>
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

                    <a href="{{ route('pengurusan.kbg.pengurusan.proses_temuduga.index') }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
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
                        Simpan
                    </button>

                    <a href="{{ route('pengurusan.kbg.pengurusan.proses_temuduga.index') }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip">
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
                    url: "{!! route('pengurusan.kbg.pengurusan.proses_temuduga.pilih_pemohon_api',1) !!}",
                },
                columns: [
                    { data: 'id' },
                    { data: 'nama', orderable: true, },
                    { data: 'no_ic', orderable: true, },
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

                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    // Swal.fire({
                    //     text: "Are you sure you want to delete " + customerName + "?",
                    //     icon: "warning",
                    //     showCancelButton: true,
                    //     buttonsStyling: false,
                    //     confirmButtonText: "Yes, delete!",
                    //     cancelButtonText: "No, cancel",
                    //     customClass: {
                    //         confirmButton: "btn fw-bold btn-danger",
                    //         cancelButton: "btn fw-bold btn-active-light-primary"
                    //     }
                    // }).then(function (result) {
                    //     if (result.value) {
                    //         // Simulate delete request -- for demo purpose only
                    //         Swal.fire({
                    //             text: "Deleting " + customerName,
                    //             icon: "info",
                    //             buttonsStyling: false,
                    //             showConfirmButton: false,
                    //             timer: 2000
                    //         }).then(function () {
                    //             Swal.fire({
                    //                 text: "You have deleted " + customerName + "!.",
                    //                 icon: "success",
                    //                 buttonsStyling: false,
                    //                 confirmButtonText: "Ok, got it!",
                    //                 customClass: {
                    //                     confirmButton: "btn fw-bold btn-primary",
                    //                 }
                    //             }).then(function () {
                    //                 // delete row data from server and re-draw datatable
                    //                 dt.draw();
                    //             });
                    //         });
                    //     } else if (result.dismiss === 'cancel') {
                    //         Swal.fire({
                    //             text: customerName + " was not deleted.",
                    //             icon: "error",
                    //             buttonsStyling: false,
                    //             confirmButtonText: "Ok, got it!",
                    //             customClass: {
                    //                 confirmButton: "btn fw-bold btn-primary",
                    //             }
                    //         });
                    //     }
                    // });
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
                    url: "{!! route('pengurusan.kbg.pengurusan.proses_temuduga.store_pemohon')!!}",
                    type: "POST",
                    data: {
                                ids: id,
                                proses_temuduga_id : {!! $proses_temuduga->id !!},
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
