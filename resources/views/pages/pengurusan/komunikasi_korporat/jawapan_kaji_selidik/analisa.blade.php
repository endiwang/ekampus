@extends('layouts.master.main')
@section('css')
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>

@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body py-5">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @php($key = 1)
                @foreach ($chartData as $chart)
                    <div class="col-md-6 mb-5" data-id="1">
                        <div class="card card-flush h-xl-100">
                                <div class="card-header pt-7 mb-7">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">{{ $chart['label'] }}</span>
                                    </h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <a href="../../demo1/dist/apps/ecommerce/catalog/add-product.html" class="btn btn-sm btn-light">PDF Report</a>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <div class="card-body">
                                    <div id="chartDive-{{ $key }}" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>


                @php($key++)
                @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

{{-- <script>

var element = document.getElementById('kt_apexcharts_1');

var height = parseInt(KTUtil.css(element, 'height'));
var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
var baseColor = KTUtil.getCssVariableValue('--kt-primary');
var secondaryColor = KTUtil.getCssVariableValue('--kt-gray-300');


var options = {
    series: [{
        name: 'Net Profit',
        data: [44, 55, 57, 56, 61, 58]
    }, {
        name: 'Revenue',
        data: [76, 85, 101, 98, 87, 105]
    }],
    chart: {
        fontFamily: 'inherit',
        type: 'bar',
        height: height,
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: ['30%'],
            endingShape: 'rounded'
        },
    },
    legend: {
        show: false
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false
        },
        labels: {
            style: {
                colors: labelColor,
                fontSize: '12px'
            }
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: labelColor,
                fontSize: '12px'
            }
        }
    },
    fill: {
        opacity: 1
    },
    states: {
        normal: {
            filter: {
                type: 'none',
                value: 0
            }
        },
        hover: {
            filter: {
                type: 'none',
                value: 0
            }
        },
        active: {
            allowMultipleDataPointsSelection: false,
            filter: {
                type: 'none',
                value: 0
            }
        }
    },
    tooltip: {
        style: {
            fontSize: '12px'
        },
        y: {
            formatter: function (val) {
                return '$' + val + ' thousands'
            }
        }
    },
    colors: [baseColor, secondaryColor],
    grid: {
        borderColor: borderColor,
        strokeDashArray: 4,
        yaxis: {
            lines: {
                show: true
            }
        }
    }
};

var chart = new ApexCharts(element, options);
chart.render();
</script> --}}


@php($key_script = 1)
@foreach ($chartData as $chart)
<script>
var element = document.querySelector("#chartDive-{{ $key_script }}");
console.log(element);

var height = parseInt(KTUtil.css(element, 'height'));
var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
var baseColor = KTUtil.getCssVariableValue('--kt-primary');
var secondaryColor = KTUtil.getCssVariableValue('--kt-gray-300');


var options = {

    series: [{
        data:@json(array_values($chart['options']))
        }],
    chart: {
        fontFamily: 'inherit',
        type: 'bar',
        height: height,
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: ['30%'],
            endingShape: 'rounded'
        },
    },
    legend: {
        show: false
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: @json(array_keys($chart['options'])),
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false
        },
        labels: {
            style: {
                colors: labelColor,
                fontSize: '12px'
            }
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: labelColor,
                fontSize: '12px'
            }
        }
    },
    fill: {
        opacity: 1
    },
    states: {
        normal: {
            filter: {
                type: 'none',
                value: 0
            }
        },
        hover: {
            filter: {
                type: 'none',
                value: 0
            }
        },
        active: {
            allowMultipleDataPointsSelection: false,
            filter: {
                type: 'none',
                value: 0
            }
        }
    },
    tooltip: {
        style: {
            fontSize: '12px'
        },
        y: {
            formatter: function (val) {
                return '$' + val + ' thousands'
            }
        }
    },
    colors: [baseColor, secondaryColor],
    grid: {
        borderColor: borderColor,
        strokeDashArray: 4,
        yaxis: {
            lines: {
                show: true
            }
        }
    }
};

// console.log(document.querySelector("#chartDive-{{ $key_script }}"));

var chart = new ApexCharts(element, options);
chart.render();

</script>
@php($key_script++)
@endforeach


<script src="assets/plugins/global/plugins.bundle.js"></script>



@endpush
