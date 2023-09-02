
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
                    <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        @if($model->id) @method('PUT') @endif
                        @csrf
                        <div class="card-body py-5">
                            @if($model->id)
                            <div class="row mb-2">
                                {{ Form::label('no_dokumen', 'No Bil', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 ' . (($model->id) ? '' : 'required')]) }}
                                <div class="col-lg-8">
                                    {{ Form::label('no_dokumen', $model->doc_no, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                </div>
                            </div>
                            @endif
                            <div class="row mb-2">
                                {{ Form::label('pelajar_id', 'Pelajar', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 ' . (($model->id) ? '' : 'required')]) }}
                                <div class="col-lg-8">
                                    @if($model->id)
                                    {{ Form::label('pelajar_id', $model->pelajar_nama, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    @else
                                    {{ Form::select('pelajar_id', [], $model->pelajar_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('pelajar_id') ? 'is-invalid' : ''), 'id' => 'pelajar_id', 'required' => 'required']) }}
                                    @error('pelajar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-2">
                                {{ Form::label('amaun', 'Amaun Yuran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 ' . (($model->id) ? '' : 'required')]) }}
                                <div class="col-lg-8">
                                    @if($model->id)
                                    {{ Form::label('amaun', $model->amaun, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    @else
                                    {{ Form::number('amaun', $yuran->amaun ?? old('amaun'), ['class' => 'form-control form-control-sm ' . ($errors->has('amaun') ? 'is-invalid':''), 'id' => 'amaun', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('amaun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            @if($model->id)
                                <hr>
                                <div class="row mb-2">
                                    {{ Form::label('status', 'Status Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    <div class="col-lg-8">
                                        {{ Form::label('status', $model->status_name, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    </div>
                                </div>
                                @if($model->status == 2)
                                <div class="row mb-2">
                                    {{ Form::label('doc_no', 'Resit Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    <div class="col-lg-8">
                                        <a href="{{ route('public.yuran.resit', Crypt::encryptString($bayaran->id)) }}" target="_blank">{{ $bayaran->doc_no }}</a><br>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    {{ Form::label('bayaran_date', 'Tarikh Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    <div class="col-lg-8">
                                        {{ Form::label('bayaran_date', $bayaran->date, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    {{ Form::label('bayaran_description', 'Keterangan Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    <div class="col-lg-8">
                                        {{ Form::label('bayaran_description', $bayaran->description, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    {{ Form::label('bayaran_description', 'Resit / Gambar Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    <div class="col-lg-8">
                                        @if(!empty($bayaran->gambar))
                                        @php
                                            $gambar = (array) json_decode($bayaran->gambar);
                                        @endphp
                                        <a href="{{ asset('storage/' . $gambar['image_path']) }}" target="_blank">{{ $gambar['image_name'] }}</a><br>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @if($model->status == 3)                        
                                <div class="row mb-2">
                                    {{ Form::label('remarks', 'Keterangan Pembatalan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    <div class="col-lg-8">
                                        {{ Form::label('remarks', $model->remarks, ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        @if(!$model->id)
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            <a href="{{ route('pengurusan.kewangan.yuran.index', $yuran->id) }}" class="btn btn-sm btn-light">Batal</a>
                        </div>
                        @endif
                    </form>

                    @if($model->id)
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        @if($model->status == 1)
                        <button id="btnApprove" type="button" class="btn btn-success btn-sm me-3" data-bs-toggle="modal" data-bs-target="#bayaranModal">
                            <i class="fa fa-save" style="vertical-align: initial"></i>Bayaran Selesai
                        </button>
                        <form id="formReject" action="{{ $action }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="status" value="3">
                            <input type="hidden" name="reject_reason">
                        </form>
                        <button id="btnReject" type="button" class="btn btn-danger btn-sm me-3">
                            <i class="fa fa-cancel" style="vertical-align: initial"></i>Batal Bil
                        </button>
                        @endif
                        <a href="{{ route('pengurusan.kewangan.yuran.index', $yuran->id) }}" class="btn btn-sm btn-light">Batal</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!--end::Row-->

    </div>
</div>
@if($model->id && $model->status == 1)
<div class="modal fade" id="bayaranModal" tabindex="-1" aria-labelledby="bayaranModalLabel" aria-hidden="true">
    <form id="formReject" action="{{ $action }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayaranModalLabel">Bayaran Bil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        {{ Form::label('status', 'Tarikh Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                        <div class="col-lg-4"> 
                            {{ Form::date('bayaran_date', @$bayaran->date, ['class' => 'form-control form-control-sm ' . ($errors->has('bayaran_date') ? 'is-invalid':''), 'id' => 'bayaran_date', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        {{ Form::label('status', 'Keterangan Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                        <div class="col-lg-6">
                            {{ Form::text('bayaran_description', ($bayaran) ? $bayaran->description : 'Bayaran ' . $yuran->nama, ['class' => 'form-control form-control-sm ' . ($errors->has('bayaran_description') ? 'is-invalid':''), 'id' => 'bayaran_description', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => "Keterangan Bayaran"]) }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        {{ Form::label('bayaran_gambar', 'Resit / Gambar Bayaran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                        <div class="col-lg-6">
                            {{ Form::file('bayaran_gambar', ['class' => 'form-control form-control-sm ' . ($errors->has('bayaran_gambar') ? 'is-invalid' : ''), 'rows'=>'4', 'id' =>'bayaran_gambar', 'accept' => 'image/*']) }}
                        </div>
                    </div>
                </div>
                <input type="hidden" name="status" value="2">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endif

@endsection

@push('scripts')
<script>

$('#btnReject').on('click', function(){
    Swal.fire({
        icon: 'warning',
        title: 'Pasti batal bil?',
        input: 'textarea',
        inputPlaceholder: 'Keterangan pembatalan...',
        inputAttributes: {
            'aria-label': 'Keterangan pembatalan'
        },
        showCancelButton: true,
        confirmButtonColor: 'red',
        confirmButtonText: 'Pasti',
        cancelButtonText: 'Kembali',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $('[name="reject_reason"]').val($('.swal2-textarea').val());
            $('#formReject').submit();
        }
    })
})
$('#pelajar_id').select2({
    ajax: {
        url: "{{ route('public.pelajar.find') }}",
        data: function (params) {
            var query = {
                search: params.term,
            }
            return query;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (value, key) {
                    return {
                        text: value,
                        id: key
                    }
                })
            };
        }
    }
});
</script>
@endpush