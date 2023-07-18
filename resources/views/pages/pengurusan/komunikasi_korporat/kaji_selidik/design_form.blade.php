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
                        {{ Form::model($form, ['route' => ['pengurusan.komunikasi_korporat.kaji_selidik.design_update', $form->id], 'data-validate', 'method' => 'PUT', 'id' => 'design-form']) }}
                        {!! Form::hidden('json', $form->json, ['class' => '']) !!}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="form_editor"></div>

                                        {{-- @php
                                            $array = json_decode($form->json);
                                        @endphp
                                        <ul id="tabs"
                                            class="nav nav-tabs mb-3 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                                            @if (!empty($form->json))
                                                @foreach ($array as $key => $data)
                                                    @php
                                                        $key = $key + 1;
                                                    @endphp
                                                    <li
                                                        class="nav-item ui-state-default ui-corner-top ui-state-focus">
                                                        {!! Html::link("#page-$key", __('Page') . $key, ['class' => 'nav-link']) !!}
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>
                                                    {!! Html::link('#page-1', __('Page1'), []) !!}
                                                </li>
                                            @endif
                                            <li id="add-page-tab">

                                                {!! Html::link('#new-page', __('+Page'), [
                                                    'class' => 'nav-link']) !!}
                                            </li>
                                        </ul>
                                        @if (!empty($form->json))
                                            @foreach ($array as $key => $data)
                                                <div id="page-{{ $key + 1 }}" class="build-wrap"></div>
                                            @endforeach
                                        @else
                                            <div id="page-1" class="build-wrap"></div>
                                        @endif

                                        <div id="new-page"></div>
                                        {!! Form::hidden('json', $form->json, ['class' => '']) !!}
                                        <br>
                                        <div class="action-buttons">
                                            {!! Form::button(__('Show Data'), ['class' => 'd-none', 'id' => 'showData']) !!}
                                            {!! Form::button(__('Clear All Fields'), ['class' => 'd-none', 'id' => 'clearFields']) !!}
                                            {!! Form::button(__('Get Data'), ['class' => 'd-none', 'id' => 'getData']) !!}
                                            {!! Form::button(__('Get XML Data'), ['class' => 'd-none', 'id' => 'getXML']) !!}
                                            {!! Form::button(__('Update'), ['class' => 'btn btn-primary', 'id' => 'getJSON']) !!}
                                            {!! Form::button(__('Back'), [
                                                'class' => 'd-none',
                                                'onClick' => 'javascript:history.go(-1)',
                                                'id' => 'getJSONs',
                                            ]) !!}
                                            {!! Form::button(__('Get JS Data'), ['class' => 'd-none', 'id' => 'getJS']) !!}
                                            {!! Form::button(__('Set Data'), ['class' => 'd-none', 'id' => 'setData']) !!}
                                            {!! Form::button(__('Add Field'), ['class' => 'd-none', 'id' => 'addField']) !!}
                                            {!! Form::button(__('Remove Field'), ['class' => 'd-none', 'id' => 'removeField']) !!}
                                            {!! Form::submit(__('Test Submit'), ['class' => 'd-none', 'id' => 'testSubmit']) !!}
                                            {!! Form::button(__('Reset Demo'), ['class' => 'd-none', 'id' => 'resetDemo']) !!}
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-9">
                                <div class="d-flex">
                                    <button type="button" id="getJSON" class="btn btn-success btn-sm me-3">
                                        <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                    </button>
                                    <a href="{{ route('pelajar.penilaian_pensyarah.index') }}" class="btn btn-sm btn-light">Batal</a>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script>

    // jQuery(function($) {
    // var formBuilder = document.getElementById('form_editor');
    // var options = {
    //     disabledActionButtons: ['data','clear']
    // };
    // $(formBuilder).formBuilder(options);

    // $(document.getElementById("getJSON")).click(function() {
    //     console.log('ok');
    //     var id;
    //     var json = formBuilder.actions.save();

    //     var allData = JSON.stringify(json);

    //     console.log(allData);

    //     $("input[name='json']").val("[" + allData + "]");
    //     $("#design-form").submit();
    // });

    // });

    jQuery(($) => {




        const fbEditor = document.getElementById("form_editor");
        var options = {
            disabledActionButtons: ['data','clear','save'],
            disableFields: ['autocomplete','file','hidden','button'],
            formData: '{!! json_encode($form_array) !!}'
        };

        document.getElementById("getJSON").addEventListener("click", () => {
            const result = formBuilder.actions.save();
            var allData = JSON.stringify(result);
            $("input[name='json']").val("[" + allData + "]");
            $("#design-form").submit();
            console.log(allData);
        });

        var setFormData = $("input[name='json']").val();
        if (setFormData.length) {
            setFormData = JSON.parse(setFormData);
            console.log(setFormData);

        }

        var json = setFormData;
        if (json.length != 0) {
            $(json).each(function(index, data) {
                setTimeout(function() {
                    options.formData = data;
                }, index * 1000)

                console.log(options);


            });
        }

        const formBuilder = $(fbEditor).formBuilder(options);

        console.log(json);



    });




    </script>



{{-- {!! $dataTable->scripts() !!} --}}

@endpush
