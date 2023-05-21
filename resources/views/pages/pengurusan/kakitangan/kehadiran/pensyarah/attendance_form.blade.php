@extends('layouts.public.main_inner_pemohon')
@section('content')
<div class="py-10 py-lg-20">
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kehadiran Pensyarah [Tarikh: {{ Utils::formatDate(now()) }}]</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ $action }}" method="post">
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('staff_id', 'Sila masukkan staff id', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('staff_id', old('staff_id'),['class' => 'form-control form-control-sm '.($errors->has('staff_id') ? 'is-invalid':''), 'id' =>'no_matrik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('staff_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="row mt-3">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Hantar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection