@extends('layouts.public.survey')

@section('content')
    <!--begin::How It Works Section-->
    {{-- <div class="mb-n10 mb-lg-n20">
        <!--begin::Container-->
        <div class="container">

        </div>
        <!--end::Container-->
    </div> --}}
    <!--end::How It Works Section-->
    <!--begin::How It Works Section-->
    {{-- <div class="mb-10 mb-lg-10 z-index-2 mt-10">
        <!--begin::Container-->
        <div class="container">
            <div class="row g-5 g-xl-8 justify-content-center">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <a href="{{ route('login_pemohon') }}" class="card card-xl-stretch mb-xl-8 card bg-light-primary shadow-sm">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <span class="fw-bold text-dark fs-4 mb-2 text-hover-primary">Log Masuk Pemohon</span>
                                <span class="fw-semibold text-muted fs-5">Pemohonan dan Semakan</span>
                            </div>
                            <img src="assets/media/svg/avatars/029-boy-11.svg" alt="" class="align-self-end h-100px">
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 2-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <a href="{{ route('login') }}" class="card card-xl-stretch mb-5 mb-xl-8 bg-light-primary shadow-sm">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <span class="fw-bold text-dark fs-4 mb-2 text-hover-primary">Log Masuk E-Kampus</span>
                                <span class="fw-semibold text-muted fs-5">Kakitangan, Pelajar dan Alumni</span>
                            </div>
                            <img src="assets/media/svg/avatars/004-boy-1.svg" alt="" class="align-self-end h-100px">
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 2-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div> --}}
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true"
        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px"
        data-kt-scroll-save-state="true"
        style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <!--begin::Email template-->
        <style>
            html,
            body {
                padding: 0;
                margin: 0;
                font-family: Inter, Helvetica, "sans-serif";
            }

            a:hover {
                color: #009ef7;
            }
        </style>
        <div id="#kt_app_body_content"
            style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div
                style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 940px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
                    style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <!--begin:Email content-->
                                <div style="text-align:center; margin:0 15px 34px 15px">
                                    <!--begin:Text-->
                                    <div
                                        style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                                            {{ $form->title }}</p>
                                    </div>
                                    <!--end:Text-->
                                </div>
                                <!--end:Email content-->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <!--begin:Email content-->
                                <div style="text-align:center; margin:0 30px 34px 30px">

                                    <form action="{{ route('public.kajian_graduan.fill_store', $form->id) }}" method="POST"
                                        enctype="multipart/form-data" id="fill-form">
                                        {{-- @method('PUT') --}}
                                        @if (isset($array))
                                            @foreach ($array as $keys => $rows)
                                                @foreach ($rows as $row_key => $row)
                                                    {{--  {{ dd($col) }}  --}}
                                                    @if ($row->type == 'checkbox-group')
                                                        <!--begin::Input wrapper-->
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <!--Checkbox-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                @foreach ($row->values as $key => $options)
                                                                    <label
                                                                        class="form-check form-check-custom form-check-inline form-check-solid me-5 is-valid">
                                                                        {{ Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, ['class' => 'form-check-input', 'id' => $row->name . '_' . $key, 'name' => $row->name . '[]']) }}
                                                                        <span class="fw-semibold ps-2 fs-6"
                                                                            for="{{ $row->name . '_' . $key }}">{{ $options->label }}</span>
                                                                    </label>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    @elseif($row->type == 'radio-group')
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <!--Checkbox-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                @foreach ($row->values as $key => $options)
                                                                    <label
                                                                        class="form-check form-check-custom form-check-inline form-check-solid me-5 is-valid">
                                                                        {{ Form::radio($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, ['class' => 'form-check-input', 'id' => $row->name . '_' . $key]) }}
                                                                        <span class="fw-semibold ps-2 fs-6"
                                                                            for="{{ $row->name . '_' . $key }}">{{ $options->label }}</span>
                                                                    </label>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    @elseif($row->type == 'date')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Date field-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                {{ Form::date($row->name, isset($row->value) ? $row->value : null, ['class' => 'form-control']) }}
                                                            </div>

                                                        </div>
                                                    @elseif($row->type == 'number')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Number-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                {{ Form::number($row->name, isset($row->value) ? $row->value : null, ['class' => 'form-control']) }}
                                                            </div>

                                                        </div>
                                                    @elseif($row->type == 'select')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Select-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                @php
                                                                    $values = [];
                                                                    $selected = [];
                                                                    foreach ($row->values as $options) {
                                                                        $values[$options->value] = $options->label;
                                                                        if (isset($options->selected) && $options->selected) {
                                                                            $selected[] = $options->value;
                                                                        }
                                                                    }
                                                                @endphp
                                                                {{ Form::select($row->name, $values, $selected, ['placeholder' => 'Sila Pilih', 'class' => 'form-control']) }}
                                                            </div>

                                                        </div>
                                                    @elseif($row->type == 'text')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Text-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                {{ Form::text($row->name, isset($row->value) ? $row->value : null, ['class' => 'form-control']) }}
                                                            </div>

                                                        </div>
                                                    @elseif($row->type == 'textarea')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Textarea-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                <span
                                                                    @if ($row->required) class="required" @endif>{{ $row->label }}</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <div class="d-flex align-items-center mt-3">
                                                                {{ Form::textarea($row->name, isset($row->value) ? $row->value : null, ['class' => 'form-control']) }}
                                                            </div>

                                                        </div>
                                                    @elseif($row->type == 'paragraph')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Paragraph-->
                                                            <div class="fs-6 fw-bold text-gray-800 mb-2"
                                                                style="text-align: initial">
                                                                <span
                                                                    class="me-2">{{ html_entity_decode($row->label) }}</span>
                                                            </div>

                                                        </div>
                                                    @elseif($row->type == 'header')
                                                        <div class="d-flex flex-column mb-8 fv-row">

                                                            <!--Header-->
                                                            <div class="fs-2hx fw-bold text-gray-800 mb-2"
                                                                style="text-align: initial">
                                                                <span
                                                                    class="me-2">{{ html_entity_decode($row->label) }}</span>
                                                            </div>

                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif



                                    </form>
                                    <!--end::Input wrapper-->
                                </div>
                                <!--end:Email content-->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:left; margin:0 15px 34px 15px">
                                    <button type="submit" class="btn btn-success" form="fill-form">Hantar</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Email template-->
    </div>
    <!--end::How It Works Section-->
@endsection
@section('script')
    <script>
        $(function() {
            $(document).on("submit", "#fill-form", function(e) {
                e.preventDefault();
                var formData = new FormData($('#fill-form')[0]);
                submitForm(formData);
            });
        });

        function submitForm(formData) {
            formData.append('ajax', true);
            formData.append('_token', $('meta[name="csrf-token"]').attr("content"));
            $.ajax({
                type: "POST",
                url: '{{ route('public.kajian_graduan.fill_store', $form->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.is_success) {
                        window.location.href = response.redirect;
                        // console.log(response.redirect);
                        // $('.form-card-body').html(
                        //     '<div class="text-center gallery" id="success_loader"><img src="{{ asset('assets/images/success.gif') }}" class="" /><br><br><h2 class="w-100 ">' +
                        //     response.message + '</h2></div>');
                        // $('#nextBtn').removeAttr('disabled');
                        // $('#nextBtn').html('Submit');
                        // console.log('ok');
                    } else {
                        // notifier.show('Error!', response.message, 'danger',
                        //     '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                        // $('#nextBtn').removeAttr('disabled');
                        // $('#nextBtn').html('Submit')
                        // showTab(0);
                        console.log('xok');

                    }
                },
                error: function(error) {}
            });
        }
    </script>
    {{-- <script>
        function submitForm(formData) {
            formData.append('ajax', true);
            $.ajax({
                type: "POST",
                url: '{{ route('forms.fill.store', $form->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.is_success) {
                        $('.form-card-body').html(
                            '<div class="text-center gallery" id="success_loader"><img src="{{ asset('assets/images/success.gif') }}" class="" /><br><br><h2 class="w-100 ">' +
                            response.message + '</h2></div>');
                        $('#nextBtn').removeAttr('disabled');
                        $('#nextBtn').html('Submit');
                    } else {
                        notifier.show('Error!', response.message, 'danger',
                            '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                        $('#nextBtn').removeAttr('disabled');
                        $('#nextBtn').html('Submit')
                        showTab(0);
                    }
                },
                error: function(error) {}
            });
        }
    </script> --}}
@endsection
