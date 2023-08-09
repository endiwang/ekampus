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
                    <form id="formAduan" class="form" action="{{ $action }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="card-body py-5">
                            <div class="row mb-2">                                
                                {{ Form::label('no_siri', 'No Siri Aduan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::text('no_siri', @$model->no_siri, ['class' => 'form-control form-control-sm', 'id' => 'no_siri', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required', 'disabled' => 'disabled']) }}
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-2">                                
                                {{ Form::label('pengadu', 'Nama Pengadu', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::text('pengadu', @$model->user_name, ['class' => 'form-control form-control-sm ', 'id' =>'pengadu', 'onkeydown' =>'return true', 'autocomplete' => 'off', 'required' => 'required', 'disabled' => 'disabled']) }}
                                </div>
                            </div>

                            <div class="row mb-2">                                
                                {{ Form::label('jenis_pengadu', 'Staff / Pelajar', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::radio('jenis_pengadu', 'value', ((@$model->user->is_staff) ? true : false), ['disabled' => 'disabled']) }} Staff
                                    <br>{{ Form::radio('jenis_pengadu', 'value', ((@$model->user->is_student) ? true : false), ['disabled' => 'disabled']) }} Pelajar
                                </div>
                            </div>

                            <div class="row mb-2">                                
                                {{ Form::label('kategori', 'Kategori', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('kategori', $kategori_aduan, @$model->kategori, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('kategori') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('type', 'Lokasi', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('type', $lokasi, @$model->type, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('type') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('blok_id', 'Bangunan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('blok_id', [], @$model->blok_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('blok_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('blok_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('tingkat_id', 'Tingkat', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('tingkat_id', $tingkat, @$model->tingkat_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('tingkat_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('tingkat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('bilik_id', 'Bilik', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('bilik_id', [], @$model->bilik_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('bilik_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('bilik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('jenis_kerosakan', 'Jenis Kerosakan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::text('jenis_kerosakan', @$model->jenis_kerosakan ?? old('jenis_kerosakan'), ['class' => 'form-control form-control-sm ' . ($errors->has('jenis_kerosakan') ? 'is-invalid' : ''), 'id' =>'jenis_kerosakan', 'onkeydown' =>'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('jenis_kerosakan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row fv-row mb-2">                                
                                {{ Form::label('butiran', 'Butiran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::textarea('butiran', @$model->butiran, ['class' => 'form-control form-control-sm ' . ($errors->has('jenis_kerosakan') ? 'is-invalid' : ''), 'rows'=>'10', 'required' => 'required', 'id' =>'butiran']) }}
                                    @error('butiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-2">                                
                                {{ Form::label('vendor_id', 'Vendor', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('vendor_id', $vendor, @$model->vendor_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('vendor_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                {{ Form::label('butiran_vendor', 'Nota ke Vendor', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::textarea('butiran_vendor', @$model->butiran_vendor, ['class' => 'form-control form-control-sm ', 'rows'=>'10', 'id' =>'butiran_vendor']) }}
                                    @error('butiran_vendor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        
                        </div>


                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            @if($model->status == 1)
                            <input type="hidden" name="is_submit" value="0">
                            <button id="btnSubmit2" type="button" data-kt-ecommerce-settings-type="submit" class="btn btn-primary btn-sm me-3">
                                <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Hantar
                            </button>
                            @endif
                            <button id="btnSubmit" type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') }}" class="btn btn-sm btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@if(count($aduan_penyelenggaraan_details) > 0)
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Kemaskini Kerja Vendor</h3>
                    </div>
                    <div class="card-body py-5">
                        <table class="table table-bordered table-condensed table-striped">
                        @foreach($aduan_penyelenggaraan_details as $aduan_penyelenggaraan_detail)
                        <tr>
                            <td style="width:15% !important;">{{ $aduan_penyelenggaraan_detail->tarikh_kerja }}</td>
                            <td>
                                {!! nl2br($aduan_penyelenggaraan_detail->butiran) !!}
                                @if(!empty($aduan_penyelenggaraan_detail->reject_reason))
                                <br><br><span class="text-danger fw-bold">{!! nl2br($aduan_penyelenggaraan_detail->reject_reason) !!}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        @if($model->status == 3)
                        <form id="formApprove" action="{{ $action }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="is_approve" value="1">
                        </form>
                        <button id="btnApprove" type="button" class="btn btn-success btn-sm me-3">
                            <i class="fa fa-save" style="vertical-align: initial"></i>Terima
                        </button>
                        <form id="formReject" action="{{ $action }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="is_reject" value="1">
                            <input type="text" name="reject_reason">
                        </form>
                        <button id="btnReject" type="button" class="btn btn-danger btn-sm me-3">
                            <i class="fa fa-cancel" style="vertical-align: initial"></i>Baiki
                        </button>
                        @endif
                        <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') }}" class="btn btn-sm btn-light">Batal</a>
                    </div>
                    
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>

$(document).ready(function(){
    $('[name="type"]').change();
});

$('[name="type"]').on('change', function(){
    if($(this).val())
    {
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            url: "{{ route('aduan_penyelenggaraan.get_block') }}",
            data: {
                type: $(this).val(),
            },
            success: function (data) {

                var $select = $('[name="blok_id"]');                        
                $select.find('option').remove();

                $select.append(`<option value="">Sila Pilih</option>`);
                $.each(data.blok, function(key, value) {
                    $select.append(`<option value="${key}">${value}</option>`);
                });

                @if(!empty($model->blok_id))
                    $('[name="blok_id"] option[value="{{ $model->blok_id }}"]').attr('selected', 'selected');
                    $('[name="blok_id"]').change();
                @endif
            },
            error: function (data) {
                //                
            }
        });
    }
})
$('[name="blok_id"], [name="tingkat_id"]').on('change', function(){
    if($('[name="blok_id"]').val() && $('[name="tingkat_id"]').val())
    {
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            url: "{{ route('aduan_penyelenggaraan.get_bilik') }}",
            data: {
                blok_id: $('[name="blok_id"]').val(),
                tingkat_id: $('[name="tingkat_id"]').val(),
            },
            success: function (data) {
                
                var $select = $('[name="bilik_id"]');                        
                $select.find('option').remove();

                $select.append(`<option value="">Sila Pilih</option>`);
                $.each(data.bilik, function(key, value) {
                    $select.append(`<option value="${key}">${value}</option>`);
                });

                @if(!empty($model->bilik_id))
                    $('[name="bilik_id"] option[value="{{ $model->bilik_id }}"]').attr('selected', 'selected');
                    $('[name="bilik_id"]').change();
                @endif
            },
            error: function (data) {
                //                
            }
        });
    }
})

$('#btnSubmit2').on('click', function(){
    Swal.fire({
        icon: 'info',
        title: 'Pasti hantar aduan ke vendor?',
        showCancelButton: true,
        confirmButtonText: 'Hantar',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            if($("#formAduan")[0].reportValidity())
            {
                $('[name="is_submit"]').val('1');
                $('#formAduan').submit();
            }
        }
    })
})

$('#btnApprove').on('click', function(){
    Swal.fire({
        icon: 'info',
        title: 'Pasti kerja vendor selesai?',
        showCancelButton: true,
        confirmButtonText: 'Pasti',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $('#formApprove').submit();
        }
    })
})

$('#btnReject').on('click', function(){
    Swal.fire({
        input: 'textarea',
        inputPlaceholder: 'Type your message here...',
        inputAttributes: {
            'aria-label': 'Type your message here'
        },
        title: 'Kembali aduan kerja semula ke vendor?',
        showCancelButton: true,
        confirmButtonText: 'Pasti',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $('[name="reject_reason"]').val($('.swal2-textarea').val());
            $('#formReject').submit();
        }
    })
})
</script>
@endpush
