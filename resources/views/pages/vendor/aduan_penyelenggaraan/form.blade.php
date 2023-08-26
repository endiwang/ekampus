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
                    <form id="formKerja" class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        @if(count($aduan_penyelenggaraan_details) > 0)
                        <div class="card-body py-5">
                            <table class="table table-bordered table-condensed table-striped">
                            @foreach($aduan_penyelenggaraan_details as $aduan_penyelenggaraan_detail)
                            <tr>
                                <td style="width:15% !important;">{{ $aduan_penyelenggaraan_detail->tarikh_kerja }}</td>
                                <td>
                                    {!! nl2br($aduan_penyelenggaraan_detail->butiran) !!}       
                                    <br>
                                    @php
                                        $images = (array) json_decode($aduan_penyelenggaraan_detail->gambar);
                                    @endphp
                                    @foreach($images as $key => $image)
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank">Gambar {{ $key }}</a><br>
                                    @endforeach                         
                                    @if(!empty($aduan_penyelenggaraan_detail->reject_reason))
                                    <br><br><span class="text-danger fw-bold">{!! nl2br($aduan_penyelenggaraan_detail->reject_reason) !!}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </table>
                        </div>
                        @if($aduan_penyelenggaraan->status == 2)                        
                        <hr>
                        @endif
                        @endif

                        @if($aduan_penyelenggaraan->status == 2)
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2">
                                {{ Form::label('tarikh_kerja', 'Tarikh Kerja', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::date('tarikh_kerja', @$model->tarikh_kerja, ['class' => 'form-control form-control-sm ' . ($errors->has('tarikh_kerja') ? 'is-invalid' : ''), 'required' => 'required', 'rows'=>'4', 'id' =>'tarikh_kerja']) }}
                                    @error('tarikh_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                {{ Form::label('butiran', 'Butiran Kerja', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::textarea('butiran', @$model->butiran, ['class' => 'form-control form-control-sm ' . ($errors->has('butiran') ? 'is-invalid' : ''), 'required' => 'required', 'rows'=>'4', 'id' =>'butiran']) }}
                                    @error('butiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                {{ Form::label('gambar', '', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    @php
                                        $check_required = 'required';
                                    @endphp
                                    @if(!empty($model->gambar))
                                        @php
                                            $images = (array) json_decode($model->gambar);
                                            $check_required = '';
                                        @endphp
                                        @foreach($images as $key => $image)
                                        <a href="{{ asset('storage/' . $image) }}" target="_blank">Gambar {{ $key }}</a><br>
                                        @endforeach
                                        <br>
                                    @endif
                                    {{ Form::file('gambar[]', ['class' => 'form-control form-control-sm ' . ($errors->has('gambar') ? 'is-invalid' : ''), $check_required, 'id' =>'gambar', 'multiple', 'accept' => 'image/*']) }}
                                    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>                        
                        @endif
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            @if($aduan_penyelenggaraan->status == 2)
                            <button id="btnSubmit2" type="button" data-kt-ecommerce-settings-type="submit" class="btn btn-primary btn-sm me-3">
                                <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Hantar Kelulusan
                            </button>
                            <button id="btnSubmit" type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            @endif
                            <a href="{{ route('vendor.aduan_penyelenggaraan.index') }}" class="btn btn-sm btn-light">Batal</a>
                        </div>
                        <input type="hidden" name="is_submit" value="0">
                    </form>
                </div>
            </div>
        </div>
        <!--end::Row-->

    </div>
</div>
@endsection

@push('scripts')
<script>
$('#btnSubmit2').on('click', function(){
    Swal.fire({
        icon: 'info',
        title: 'Pasti hantar kelulusan kerja?',
        showCancelButton: true,
        confirmButtonText: 'Hantar',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $('[name="is_submit"]').val('1');
            $('#formKerja').submit();
        }
    })

})
</script>
@endpush
