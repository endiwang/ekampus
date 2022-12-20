@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{URL::asset('assets/media/avatars/300-1.jpg')}}" alt="image" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $staff->nama }}</a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z" fill="currentColor" />
                                            <path d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z" fill="currentColor" />
                                            <rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor" />
                                        </svg>
                                    </span>Kakitangan</a>
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                        </svg>
                                    </span>@if ($staff->pusat_pengajian_id != NULL && $staff->pusatPengajian != NULL){{ $staff->pusatPengajian->nama ?? '-' }}@endif</a>
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor" />
                                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor" />
                                        </svg>
                                    </span>{{ $staff->email ?? '-' }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal"><i class="fa fa-lock"></i> Reset Katalaluan</a>
                                    <a href="{{ route('pengurusan.pentadbir_sistem.kakitangan.edit',$staff->id) }}" class="btn btn-sm btn-primary me-2"><i class="fa fa-pencil"></i> Pinda Profil</a>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#profil">Profil</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#kebenaran">Kebenaran</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profil" role="tabpanel">
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h4 class="fw-bold m-0">Maklumat Am</h4>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Nama</label>

                            <div class="col-lg-9">
                                <span class="fw-bold fs-6 text-gray-800">{{ $staff->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">No. K/P</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">{{ $staff->no_ic }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Jantina</label>

                            <div class="col-lg-9">
                                <span class="fw-bold fs-6 text-gray-800">@if ($staff->jantina == 'L') Lelaki @elseif ($staff->jantina == 'P') Perempuan @else - @endif</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Alamat</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">{!! $staff->alamat !!}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">No. Telefon</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">{{ $staff->no_tel }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Emel</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">{{ $staff->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h4 class="fw-bold m-0">Maklumat Kerja</h4>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Pusat Pengajian</label>

                            <div class="col-lg-9">
                                <span class="fw-bold fs-6 text-gray-800">@if ($staff->pusat_pengajian_id != NULL && $staff->pusatPengajian != NULL){{ $staff->pusatPengajian->nama ?? '-' }}@endif</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Jawatan</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">
                                    <div class="d-flex flex-column">
                                        @if($staff->is_pensyarah == 'Y') <li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Pensyarah</li>@endif
                                        @if($staff->is_guru_tasmik == 'Y') <li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Pensyarah Tasmik</li>@endif
                                        @if($staff->is_guru_tasmik_jemputan == 'Y') <li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Pensyarah Tasmik Jemputan</li>@endif
                                        @if($staff->is_warden == 'Y') <li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Warden</li>@endif
                                        @if($staff->is_tutor == 'Y') <li class="d-flex align-items-center py-2"><span class="bullet me-5"></span> Tutor</li>@endif
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-3 fw-semibold text-muted">Status</label>
                            <div class="col-lg-9 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">
                                    @if ($staff->status == 0)
                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>
                                    @elseif ($staff->status == 1)
                                        <span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kebenaran" role="tabpanel">
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h4 class="fw-bold m-0">Kebenaran</h4>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h3 class="card-title">Pentadbir Sistem</h3>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-light">
                                                Semua
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table gy-7 gs-7">
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th class="">Sub Module</th>
                                                        <th class="">Semua</th>
                                                        <th class="">Tambah baru</th>
                                                        <th class="">Kemaskini</th>
                                                        <th class="">Pinda</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Pengurusan Sesi</td>
                                                        <td>System Architect</td>
                                                        <td>Edinburgh</td>
                                                        <td>61</td>
                                                        <td>$320,800</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Accountant</td>
                                                        <td>Tokyo</td>
                                                        <td>63</td>
                                                        <td>2011/07/25</td>
                                                        <td>$170,750</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h3 class="card-title">Title</h3>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-light">
                                                Semua
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        Lorem Ipsum is simply dummy text...
                                    </div>=
                                </div>

                            </div>
                        </div>
                        {{-- <form action="{{ route('testCheckbox') }}" method="POST">
                            @csrf
                            <div id="kt_docs_jstree_basic">
                                <ul>
                                    <li id="1" class="fs-5 pt-2 pb-2"> Pentadbir Sistem
                                        <ul>
                                            <li id="1.1" class="fs-5 pt-2 pb-2"> Pengurusan Sesi Pengajian
                                                <ul>
                                                    <li id="1.1.1" class="fs-6 pt-1 pb-1"> Papar (View) </li>
                                                    <li id="1.1.2" class="fs-6 pt-1 pb-1"> Tambah (Add New) </li>
                                                    <li id="1.1.3" class="fs-6 pt-1 pb-1"> Kemaskini (Update) </li>
                                                    <li id="1.1.4" class="fs-6 pt-1 pb-1"> Hapus (Delete) </li>
                                                </ul>
                                            </li>
                                            <li id="1.2" class="fs-5 pt-2 pb-2"> Pengurusan Kakitangan
                                                <ul>
                                                    <li id="1.2.1" class="fs-6 pt-1 pb-1"> Papar (View) </li>
                                                    <li id="1.2.2" class="fs-6 pt-1 pb-1"> Tambah (Add New) </li>
                                                    <li id="1.2.3" class="fs-6 pt-1 pb-1"> Kemaskini (Update) </li>
                                                    <li id="1.2.4" class="fs-6 pt-1 pb-1"> Hapus (Delete) </li>
                                                </ul>
                                            </li>
                                            <li id="1.3" class="fs-5 pt-2 pb-2"> Pengurusan Tetapan Permohonan
                                                <ul>
                                                    <li id="1.3.1" class="fs-6 pt-1 pb-1"> Papar (View) </li>
                                                    <li id="1.3.2" class="fs-6 pt-1 pb-1"> Tambah (Add New) </li>
                                                    <li id="1.3.3" class="fs-6 pt-1 pb-1"> Kemaskini (Update) </li>
                                                    <li id="1.3.4" class="fs-6 pt-1 pb-1"> Hapus (Delete) </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="2" class="fs-5 pt-2 pb-2"> Hal Ehwal Akademik
                                        <ul>
                                            <li id="2.1" class="fs-5 pt-2 pb-2"> Pengurusan Kelas
                                                <ul>
                                                    <li id="2.1.1" class="fs-6 pt-1 pb-1"> Papar (View) </li>
                                                    <li id="2.1.2" class="fs-6 pt-1 pb-1"> Tambah (Add New) </li>
                                                    <li id="2.1.3" class="fs-6 pt-1 pb-1"> Kemaskini (Update) </li>
                                                    <li id="2.1.4" class="fs-6 pt-1 pb-1"> Hapus (Delete) </li>
                                                </ul>
                                            </li>
                                            <li id="2.2" class="fs-5 pt-2 pb-2"> Pengurusan Kursus
                                                <ul>
                                                    <li id="2.2.1" class="fs-6 pt-1 pb-1"> Papar (View) </li>
                                                    <li id="2.2.2" class="fs-6 pt-1 pb-1"> Tambah (Add New) </li>
                                                    <li id="2.2.3" class="fs-6 pt-1 pb-1"> Kemaskini (Update) </li>
                                                    <li id="2.2.4" class="fs-6 pt-1 pb-1"> Hapus (Delete) </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" onclick="submitMe()" class="btn btn-secondary">Submit</button>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>



    function submitMe(){
        var checked_ids = [];
        $("#kt_docs_jstree_basic").jstree("get_checked",null,true).each
            (function () {
                checked_ids.push(this.id);
            });
           console.log(checked_ids)
        }


    </script>

    <script>
        jQuery(function ($) {
        $('#kt_docs_jstree_basic').jstree({

            "core": { "check_callback": false },

            "checkbox": { "keep_selected_style": false, "three_state": false, "tie_selection": false, "whole_node": false, },

            "plugins": ["checkbox"]

        }).bind("ready.jstree", function (event, data) {

            $(this).jstree("open_all");

        }).on("check_node.jstree uncheck_node.jstree", function (e, data) {

            var currentNode = data.node;

            var parent_node = $('#kt_docs_jstree_basic').jstree().get_node(currentNode).parents;

            console.log(currentNode);
            console.log(parent_node);

            if (data.node.state.checked)
                $('#kt_docs_jstree_basic').jstree().check_node(parent_node[0]);
            else
                $('#kt_docs_jstree_basic').jstree().uncheck_node(parent_node[0]);
        })

        });
    </script>
@endsection

@push('scripts')




@endpush
