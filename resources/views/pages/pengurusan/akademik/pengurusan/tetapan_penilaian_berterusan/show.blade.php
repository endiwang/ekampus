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
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_subjek', 'Nama Subjek', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_subjek', $subjek->nama ?? null ,['class' => 'form-control form-control-sm', 'id' =>'markah','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kod_subjek', 'Kod Subjek', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('kod_subjek', $subjek->kod_subjek ?? null ,['class' => 'form-control form-control-sm', 'id' =>'kod_subjek','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('markah_aktiviti', 'Markah Keseluruh Aktiviti (%)', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::number('markah_aktiviti', $model->peratus_aktiviti ?? old('markah_aktiviti') ,['class' => 'form-control form-control-sm', 'id' =>'markah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            @error('markah_aktiviti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('markah_peperiksaan', 'Markah Keseluruh Peperiksaan (%)', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::number('markah_peperiksaan', $model->peratus_peperiksaan ?? old('markah_peperiksaan') ,['class' => 'form-control form-control-sm', 'id' =>'markah_peperiksaan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            @error('markah_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="subjek_id" value="{{ $subjek->id }}">
                            
                            <div class="row py-3">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
       <!--begin::Row-->
       <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Komponen Penilaian</h3>
                    </div>
                    <div class="card-body py-5">
                        <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" width="100%">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Nama Item</th> 
                                    <th>Peratus Pemarkahan (%)</th>
                                    <th>Komponen & Peratus Markah</th>                       
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $item->item ?? null }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->peratus_markah ?? null }}
                                    </td>
                                    <td> 
                                        @forelse ($item->components as $component)
                                            {{ $component->name ?? null }} : {{ $component->peratus_markah ?? null }} % <br/>
                                        @empty
                                            N/A 
                                        @endforelse 
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove({{ $item->id}})" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-{{ $item->id }}" action="{{ route('pengurusan.akademik.pengurusan.tetapan_penilaian_berterusan.destroy', $item->id) }}" method="POST">
                                            <input type="hidden" name="_token" value=" {{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
        
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function remove(id){
            Swal.fire({
                title: 'Are you sure you want to delete this data?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
                reverseButtons: true,
                customClass: {
                    title: 'swal-modal-delete-title',
                    htmlContainer: 'swal-modal-delete-container',
                    cancelButton: 'btn btn-light btn-sm mr-1',
                    confirmButton: 'btn btn-primary btn-sm ml-1'
                },
                buttonsStyling: false
            })
                .then((result) => {
                    if(result.isConfirmed){
                        document.getElementById(`delete-${id}`).submit();
                    }
                })
        }
    </script>
@endpush
