@extends('backend.layouts.app')

@section('title', 'ادارة الجلسات')

@section('session_management', 'active')

@section('content')
  
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-building fa-fw mx-2"></i>مجالس الصلح</h3>
            <div class="card-toolbar">
                <a href="{{route('admin.settings.councils.create')}}" class="btn btn-sm btn-success">
                    اضافة جديد
                </a>
            
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-around mb-5">
                <span class="badge badge-success">مجلس شاغر</span>
                <span class="badge badge-danger">جلسة صلح لم تبدأ بعد</span>
                <span class="badge badge-primary">جلسة صلح منتهية</span>
            </div>
            <div class="row">
                @foreach($meetings as $council)
                    <div class="col-md-4">
                        <div class="card @if($council->sessionid == '' || $council->sessionid == null) bg-success @elseif($council->session_end_time == 0) bg-danger @else bg-primary @endif p-4 mb-3">
                            <p class="fs-2 mb-0 text-white">{{__('room_code')}} ( {{$council->room_code}} ) {{__('level_code')}} ( {{$council->level_code}} )</p>
                            @if($council->sessionid == '' || $council->sessionid == null)
                                <div class="text-white" style="padding: 50px 0;text-align: center;font-size: 35px">متوفر</div>
                            @else
                                <div class="d-flex align-items-center justify-content-between my-2">
                                    <p class="text-white">
                                        <i class="fas fa-clock mx-1 text-white"></i>
                                        @if($council->session_end_time != 0)
                                            مدة الجلسة
                                            {{formatSecondsFromTime($council->session_start_time, $council->session_end_time)}}
                                        @else
                                            بدأت منذ
                                            {{formatSecondsFromPast($council->session_start_time)}}
                                        @endif
                                    </p>
                                    <p class="text-white"># {{$council->council_id}}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-white">
                                        <i class="fas fa-clock fa-fw mx-1 text-white"></i>
                                        مواعيد الجلسة
                                    </p>
                                    <p class="text-white">
                                        [ {{timer($council->session_date, "H:i")}} - {{timer($council->session_date_end, "H:i")}} ]
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-white">
                                        @if($council->wife_present_date != 0)
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @else
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @endif
                                            الطرف الثاني:
                                    </p>
                                    <p class="text-white">
                                        {{$council->wife_name}}
                                        @if($council->wife_present_date == 0)
                                            متأخر
                                            <span class="mx-1">[ {{formatSecondsFromPast($council->session_date)}} ]<span>
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-white">
                                        @if($council->husband_present_date != 0)
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @else
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @endif
                                        الطرف الأول:
                                    </p>
                                    <p class="text-white">
                                        {{$council->husband_name}}
                                        @if($council->husband_present_date == 0)
                                            متأخر
                                            <span class="mx-1">[ {{formatSecondsFromPast($council->session_date)}} ]<span>
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-white">
                                        <i class="fas fa-user fa-fw mx-1 text-white"></i>
                                        المصلح الاساسي
                                    </p>
                                    <p class="text-white">
                            
                                        {{$council->moslh_name}} <br>
                                        @if($council->moslh_present_date == 0)
                                                متأخر
                                            {{formatSecondsFromPast($council->session_date)}}
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-white">
                                        <i class="fas fa-users fa-fw mx-1 text-white"></i>
                                        مصلحي الانتظار
                                    </p>
                                    <ul class="list-unstyled">
                                        <li>
                                            <p class="text-white">
                                                @if($council->moslh_extra_userid != 0)
                                                    @if($council->moslh_present_date != 0 && $council->moslh_session_userid == $council->moslh_extra_userid)
                                                        <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                                    @else
                                                        <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                                    @endif
                                                    {{\App\Models\User::find($council->moslh_extra_userid)->name}} <br>
                                                    @if($council->moslh_present_date == 0)
                                                        متأخر
                                                        {{formatSecondsFromPast($council->session_date)}}
                                                    @endif
                                                @endif
                                            </p>
                                        </li>
                                        @if($council->moslh_extra_second_userid != 0)
                                            <li>
                                                <p class="text-white">
                                                    @if($council->moslh_present_date != 0 && $council->moslh_session_userid == $council->moslh_extra_second_userid)
                                                        <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                                    @else
                                                        <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                                    @endif
                                                    {{\App\Models\User::find($council->moslh_extra_second_userid)->name}} <br>
                                                    @if($council->moslh_present_date == 0)
                                                        متأخر
                                                        {{formatSecondsFromPast($council->session_date)}}
                                                    @endif
                                                </p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var element = document.getElementById('kt_apexcharts_3');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-info');
        var lightColor = KTUtil.getCssVariableValue('--bs-light-info');

        var options = {
            series: [{
                name: 'القضايا',
                data: [30, 40, 40, 90, 90, 70, 70, 23,76,78,123,43]
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'area',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {

            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor]
            },
            xaxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
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
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: baseColor,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
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
            },
            colors: [lightColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    </script>
@endsection
