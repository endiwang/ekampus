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
                        <p class="mt-3">Tarikh : {{ $date }}</p>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @php $bil = 1 @endphp
                        @foreach ($models as $model)
                        <div class="row mt-5">
                            <div class="col-md-5 text-md-end">
                                <span style="display: inline-block">
                                    <label class="fs-7 fw-semibold form-label mt-2 text-capitalize">{{ $bil++ }}. <span style="display:inherit;">{!! $model->name !!}</span></label>
                                </span>
                            </div>
                            <div class="col-md-7">
                                <div class="w-100">
                                    @if($model->question_type_id == 1)
                                        @foreach ($model->questionOptions as $option)
                                            <div class="row">
                                                <div class="col-md-1 text-md-end">
                                                    <input class="form-check-input mt-2" type="radio" name="data[radio_answer][{{$model->id}}]" value="{{ $option->id }}" />
                                                </div>
                                                <div class="col-md-11">
                                                    {{ Form::label('jawapan', $option->name, ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif($model->question_type_id == 2)
                                            @php $index = 1 @endphp
                                        @foreach ($model->questionOptions as $option)
                                            <div class="row">
                                                <label class="form-check form-check-custom form-check-inline mb-2" style="margin-left: 25px;">
                                                    <input class="form-check-input" name="data[checkboxanswer][{{$index++}}][{{$model->id}}]" type="checkbox" value="{{ $option->id }}" />
                                                    <span class="fw-semibold ps-2 fs-7 text-capitalize">{{ $option->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    @elseif($model->question_type_id == 3)
                                        @foreach ($model->questionOptions as $option)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{ Form::textarea("data[textanswer][$model->id]", '',['class' => 'form-control form-control-sm', 'id' => $option->name,'onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <input type="hidden" name="quiz_id" value={{ $quiz_data->id }}>

                        <div class="row mt-5">
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex">
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                        <i class="fa fa-save" style="vertical-align: initial"></i>Hantar
                                    </button>
                                    <a href="{{ route('pelajar.e_learning.ujian_atas_talian.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection
