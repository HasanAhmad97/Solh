@extends('backend.layouts.app')

@section('title', 'أرشيف الجلسات')

@section('archive_sessions', 'active')

@section('toolbar')
    <div class="m-0">
        @if(auth()->user()->usergroup != 1)
        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                </svg>
            </span>
            تصفية
        </a>
                <div class="menu menu-sub menu-sub-dropdown w-150px w-md-400px" data-kt-menu="true" id="kt_menu_61de0c0cad61e">
            <div class="px-7 py-5">
                <div class="fs-5 text-dark fw-bolder">خيارات التصفية</div>
            </div>
            <div class="separator border-gray-200"></div>
            <div class="px-7 py-5">
                 <form method="post" action="{{route('admin.archive.request.filter')}}">
                    @csrf
                    <input type="hidden" name="filter_type" value = "approved" >
                    <input type="hidden" name="archive_type" value = "session" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="f_name">نوع القضية</label>
                                <select name="result"  class = "form-select" >
                                 <option value="-10">--اختر--</option>
                                @foreach($casesreasons as $reason)
                                  <option value="{{$reason->reason_id}}">{{$reason->title}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <label class="form-label fw-bold" for="f_name">حسب التاريخ</label>
                        <div class="col-md-6">
                            <div class="mb-10">
                                 <label class="form-label fw-bold" for="f_name">من</label>
                                <input  type="date" pattern="\d{4}-\d{2}-\d{2}"
                                value=""
                                class="form-control"
                                name="start_date" placeholder="">
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                 <label class="form-label fw-bold" for="f_name">إلى</label>
                                <input  type="date" pattern="\d{4}-\d{2}-\d{2}"
                                value=""
                                class="form-control"
                                name="end_date" placeholder="">
                             </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">موافق</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-list fa-fw mx-2"></i>أرشيف الجلسات
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">الحالة</th>
                        <th class="min-w-125px text-center">تاريخ الجلسة</th>
                        <th class="min-w-125px text-center">المصلح</th>
                        <th class="min-w-125px text-center">الزوج</th>
                        <th class="min-w-125px text-center">الزوجة</th>
                        <th class="min-w-125px text-center">القضية</th>
                    </tr>
                    </thead>
                    <tbody>
                     @if($requests ?? '')
                        @foreach($requests as $key => $request)
                            <tr>
                                <td>{{($key+1) + ($requests->currentPage() - 1)*$requests->perPage()}}</td>
                                <td>{!! getRequestSessionStatus($request->status) !!}</td>
                                <td class="text-center">{{timer($request->session_date)}} [ {{$request->time->title?? ''}} ]</td>
                                <td class="text-center">
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->moslh_present_date == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        {{$request->moslh_name->name??''}}
                                    </span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7">{{$request->moslh_name->phone??''}}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->husband_present_date == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        {{$request->request->request_info->husband_name??''}}
                                    </span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7">{{$request->request->request_info->husband_phone??''}}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->wife_present_date == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        {{$request->request->request_info->wife_name??''}}
                                    </span>
                                    <span class="text-muted fw-bold text-muted d-block fs-7">{{$request->request->request_info->wife_phone??''}}</span>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="badge badge-primary">أضغط هنا</a>
                                </td>
                            </tr>
                        @endforeach
                          @else
                            <tr>
                                <td>لا توجد نتائج</td>
                            </tr>
                            @endif
                    </tbody>
                </table>
            </div>
             @if($requests ?? '')
             {{ $requests->appends(Request::all())->links() }}

            @endif
        </div>
    </div>
@endsection
