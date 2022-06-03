@extends('backend.layouts.app')

@section('title', 'أرشيف القضايا')

@section('archive_request', 'active')

@section('toolbar')
    <div class="m-0 d-flex">
        
        <div class = "me-7">
            <form method="post" action="{{route('admin.archive.request.search')}}">
               @csrf
                <div class="input-group rounded">
                  <input type="search" name="result" class="form-control rounded" placeholder="بحث:اسم،هاتف،هوية" aria-label="Search" aria-describedby="search-addon" />
                  <span class="input-group-text border-0" id="search-addon">
                  <button type="submit" class="btn btn-sm"><i class="fas fa-search"></i></button>
                  </span>
                </div>
            </form>
        </div>
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
                    <input type="hidden" name="archive_type" value = "request" >
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
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="f_name">نتيجة الإغلاق</label>
                                <select name="close_result"  class = "form-select" >
                                <option value="-10">--اختر--</option>

                                @foreach($casesclosestatus as $status)
                                  <option value="{{$status->close_status_id}}">{{$status->title}}</option>
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
                    <i class="fas fa-list fa-fw mx-2"></i>أرشيف القضايا
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">بيانات مقدم الطلب</th>
                        <th class="min-w-125px text-center">تاريخ الاضافة</th>
                        <th class="min-w-125px text-center">نوع القضية</th>
                        <th class="min-w-125px text-center">الحالة</th>
                        <th class="min-w-125px text-center">نتيجة الإغلاق</th>
                        <th class="min-w-125px text-center">خيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                
                @if($requests ?? '')
                    @foreach($requests as $key => $request)
                        @php
                          foreach($casesclosestatus as $status)
                            if($status->close_status_id == $request->close_status_id) 
                              {
                               $closetitle = $status->title;
                               break;
                               }
                            else
                            {
                              $closetitle = 'غير منتهي';
                             }
                       @endphp 
                        <tr>
                            <td>{{($key+1) + ($requests->currentPage() - 1)*$requests->perPage()}}</td>
                            <td class="text-center">
                                <span class="text-dark fw-bolder mb-1 fs-6">
                                    {{$request->name}}
                                </span>
                                <span class="text-muted fw-bold text-muted d-block fs-7">
                                        <a href="tel:{{shortPhone($request->phone_number)}}">{{shortPhone($request->phone_number)}}</a>
                                </span>
                            </td>
                            <td class="text-center">{{date('Y-m-d', $request->dateadd)}}</td>
                            <td class="text-center">{{ getRequestType($request->req_type) }}</td>
                            <td class="text-center">{!! getRequestStatus($request->status) !!}</td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{$closetitle}}</span>
                                </td>
                            <td class="text-center">
                                <a href="{{route('admin.session.approve',['id'=>$request->reqid])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black"/>
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"/>
                                        </svg>
                                    </span>
                                </a>
                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </a>
                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21 18H3C2.4 18 2 17.6 2 17V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V17C22 17.6 21.6 18 21 18Z" fill="black"/>
                                            <path d="M11.4 13.5C11.8 13.8 12.3 13.8 12.6 13.5L21.6 6.30005C21.4 6.10005 21.2 6 20.9 6H2.99998C2.69998 6 2.49999 6.10005 2.29999 6.30005L11.4 13.5Z" fill="black"/>
                                        </svg>
                                    </span>
                                </a>
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

