@extends('backend.layouts.app')

@section('title', 'تقارير المصلحين')

@section('reports', 'here show')
@section('reports_mslh', 'active')

@section('toolbar')
    <div class="m-0">
        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                </svg>
            </span>
            تصفية
        </a>
        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-800px" data-kt-menu="true" id="kt_menu_61de0c0cad61e">
            <div class="px-7 py-5">
                <div class="fs-5 text-dark fw-bolder">خيارات التصفية</div>
            </div>
            <div class="separator border-gray-200"></div>
            <div class="px-7 py-5">
                <form method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="start">من</label>
                                <input type="text" name="start" id="start" class="form-control" value="{{$start}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="end">إلى</label>
                                <input type="text" name="end" id="end" class="form-control" value="{{$end}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <a href="?period=today" class="btn btn-warning d-block">تقارير اليوم</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <a href="?period=yesterday" class="btn btn-warning d-block">تقارير الأمس</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">موافق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-users fa-fw mx-2"></i>التقارير حسب المصلحين
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">اسم المصلح</th>
                        <th class="min-w-125px">عدد المعاملات</th>
                        <th class="min-w-125px">عدد الجلسات</th>
                        <th class="min-w-125px">عدد الساعات</th>
                        <th class="text-center">صلح برجعة</th>
                        <th class="text-center">صلح بطلاق</th>
                        <th class="text-center">تحكيم</th>
                        <th class="text-center">تعذر الصلح</th>
                        <th class="text-center">المتبقي</th>
                        <th class="text-center">إجمالي المكافأت</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $allTotalSessions = 0;
                            $allTotalRequests = 0;
                            $allsolhrTotalDoneReq = 0;
                            $allsolhtTotalDoneReq = 0;
                            $allsolhhTotalDoneReq = 0;
                            $allsolhuTotalDoneReq = 0;
                            $allsolhrest = 0;
                            $allTotalRewards = 0;
                        @endphp
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$user->name}}</td>
                                <td class="text-center">
                                @php
                                     $totalreq = \App\Models\RequestSession::distinct('reqid')->where('is_deleted', 0)->where('moslh_userid', $user->userid)->count();
                                     echo $totalreq;
                                     $allTotalRequests = $allTotalRequests + $totalreq;
                                  @endphp
                                </td>
                                <td class="text-center">
                                    @php
                                          $totalsession = \App\Models\RequestSession::select('reqid')->where('is_deleted', 0)->where('moslh_userid', $user->userid)->count();
                                          echo $totalsession;
                                          $allTotalSessions = $allTotalSessions + $totalsession;
                                    @endphp
                                </td>
                                <td class="text-center">
                                  
                                </td>
                                <td class="text-center">
                                    @php
                                        $totaldonereq = \App\Models\Request::where('is_deleted', 0)->where('status', 'COMPLATED')->where('close_status_id',2)->get();
                                        $totaldonesession = array();
                                        foreach($totaldonereq as $totaldone)
                                        {   $total = \App\Models\RequestSession::where('is_deleted', 0)->where('reqid', $totaldone->reqid)->where('moslh_userid', $user->userid)->where('status','finish')->first();
                                            if($total)
                                            {  
                                              $totaldonesession[] = $total;
                                            }
                                        }
                                        echo count($totaldonesession);
                                        $allsolhrTotalDoneReq = $allsolhrTotalDoneReq + count($totaldonesession);
                                    @endphp
                                </td>
                                <td class="text-center">
                                          @php
                                                $totaldonereq = \App\Models\Request::where('is_deleted', 0)->where('status', 'COMPLATED')->where('close_status_id',1)->get();
                                                $totaldonesession = array();
                                                foreach($totaldonereq as $totaldone)
                                                {   $total = \App\Models\RequestSession::where('is_deleted', 0)->where('reqid', $totaldone->reqid)->where('moslh_userid', $user->userid)->where('status','finish')->first();
                                                    if($total)
                                                    {  
                                                      $totaldonesession[] = $total;
                                                    }
                                                }
                                                echo count($totaldonesession);
                                                $allsolhtTotalDoneReq = $allsolhtTotalDoneReq + count($totaldonesession);
                                            @endphp
                                     </td>
                                     <td class="text-center">
                                              @php
                                                $totaldonereq = \App\Models\Request::where('is_deleted', 0)->where('status', 'COMPLATED')->where('close_status_id',4)->get();
                                                $totaldonesession = array();
                                                foreach($totaldonereq as $totaldone)
                                                {   $total = \App\Models\RequestSession::where('is_deleted', 0)->where('reqid', $totaldone->reqid)->where('moslh_userid', $user->userid)->where('status','finish')->first();
                                                    if($total)
                                                    {  
                                                      $totaldonesession[] = $total;
                                                    }
                                                }
                                                echo count($totaldonesession);
                                                $allsolhhTotalDoneReq = $allsolhhTotalDoneReq + count($totaldonesession);

                                            @endphp                      
                                        <td class="text-center">
                                            @php
                                                $totaldonereq = \App\Models\Request::where('is_deleted', 0)->where('status', 'COMPLATED')->where('close_status_id',3)->get();
                                                $totaldonesession = array();
                                                foreach($totaldonereq as $totaldone)
                                                {   $total = \App\Models\RequestSession::where('is_deleted', 0)->where('reqid', $totaldone->reqid)->where('moslh_userid', $user->userid)->where('status','finish')->first();
                                                    if($total)
                                                    {  
                                                    $totaldonesession[] = $total;
                                                    }
                                                }
                                                echo count($totaldonesession);
                                                $allsolhuTotalDoneReq = $allsolhuTotalDoneReq + count($totaldonesession);
                                            @endphp
                     
                                       </td>
                                        <td class="text-center">
                                           @php
                                                $totalrestreq = \App\Models\Request::where('is_deleted', 0)->where('status', 'COMPLATED')->where('close_status_id','!=',2)->where('close_status_id','!=',1)->where('close_status_id','!=',4)->where('close_status_id','!=',3)->get();
                                                $totalsolhrest = array();
                                                foreach($totalrestreq as $totalrest)
                                                {   $total = \App\Models\RequestSession::where('is_deleted', 0)->where('reqid', $totalrest->reqid)->where('moslh_userid', $user->userid)->where('status','finish')->first();
                                                    if($total)
                                                    {  
                                                    $totalsolhrest[] = $total;
                                                    }
                                                }
                                                echo count($totaldonesession);
                                                $allsolhrest = $allsolhrest + count($totalsolhrest);
                                            @endphp
                     
                                       </td>
                                       
                                        <td class="text-center">
                                            @php
                                                $primarytotal = DB::table('mos_reward')->where('mosid', $user->userid)->sum('amount');
                                                $sectotal = DB::table('mos_reward')->where('sec_mosid', $user->userid)->sum('sec_amount');
                                                echo $primarytotal + $sectotal;
                                                $allTotalRewards = $allTotalRewards + $primarytotal + $sectotal;
                                            @endphp
                     
                                       </td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                    <hr>
                    <tfoot class = "bg-secondary text-primary">
                        <tr>
                            <th class="text-center" colspan="2"><strong>المجاميع</strong></th>
                            <th class="text-center"><strong>{{$allTotalRequests}}</strong></th>
                            <th class="text-center"><strong>{{$allTotalSessions}}</strong></th>
                            <th class="text-center"></th>
                            <th class="text-center"><strong>{{$allsolhrTotalDoneReq}}</strong></th>
                            <th class="text-center"><strong>{{$allsolhtTotalDoneReq}}</strong></th>
                            <th class="text-center"><strong>{{$allsolhhTotalDoneReq}}</strong></th>
                            <th class="text-center"><strong>{{$allsolhuTotalDoneReq}}</strong></th>
                            <th class="text-center"><strong>{{$allsolhrest}}</strong></th>
                            <th class="text-center"><strong>{{$allTotalRewards}}</strong></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#start").flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        });
        $("#end").flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        });
    </script>
@endsection

