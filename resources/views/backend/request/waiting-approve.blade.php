@extends('backend.layouts.app')

@section('title', 'طلبات بانتظار الاعتماد')

@section('request_waiting_approve', 'active')

@section('toolbar')
    <div class="m-0 d-flex">
        <div class = "me-7">
            <form method="post" action="{{route('admin.request.waiting.filter')}}">
               @csrf
                <input type="hidden" name="filter_type" value = "waiting_approve" >
                <div class="input-group rounded">
                  <input type="search" name="result" class="form-control rounded" placeholder="بحث:اسم،هاتف،هوية" aria-label="Search" aria-describedby="search-addon" />
                  <span class="input-group-text border-0" id="search-addon">
                  <button type="submit" class="btn btn-sm"><i class="fas fa-search"></i></button>
                  </span>
                </div>
            </form>
        </div>
    </div>
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">أضافة جديد</a>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-list fa-fw mx-2"></i>طلبات بانتظار الاعتماد
                </span>
                <small class="text-danger d-block">
                    ملاحظة: الطلبات الواردة في هذه الصفحة هي الطلبات التي تم اكمال بياناتها ولم يتم اعتمادها. لتحديد الجلسات للطلبات المعتمدة أو المعاد جدولتها فضلاً توجه الى صفحة
                    <a href="#">تحديد الطلبات للجلسات</a>
                </small>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">رقم الطلب</th>
                        <th class="min-w-125px text-center">بيانات الطرف الأول</th>
                        <th class="min-w-125px text-center">بيانات الطرف الثاني</th>
                        <th class="min-w-125px text-center">نوع القضية</th>
                        <th class="min-w-125px text-center">الحالة</th>
                        <th class="min-w-125px text-center">خيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $key => $request)
                        <tr>
                            <td>{{($key+1) + ($requests->currentPage() - 1)*$requests->perPage()}}</td>
                            <td>
                                {{$request->reqid}}
                            </td>
                            <td class="text-center">
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->husband_complate_info == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        @if($request->request_info != '')
                                            {{$request->request_info->husband_name}}
                                        @endif
                                    </span>
                                <span class="text-muted fw-bold text-muted d-block fs-7">
                                        @if($request->request_info != '')
                                        <a href="tel:{{shortPhone($request->request_info->husband_phone)}}">{{shortPhone($request->request_info->husband_phone)}}</a>
                                    @endif
                                    </span>
                                @if($request->husband_complate_info == 0)
                                    <a href="#" class="badge badge-warning">ارسال تذكير</a>
                                @endif
                            </td>
                            <td class="text-center">
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->wife_complate_info == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        @if($request->request_info != '')
                                            {{$request->request_info->wife_name}}
                                        @endif
                                    </span>
                                <span class="text-muted fw-bold text-muted d-block fs-7">
                                        @if($request->request_info != '')
                                        <a href="tel:{{shortPhone($request->request_info->wife_phone)}}">{{shortPhone($request->request_info->wife_phone)}}</a>
                                    @endif
                                    </span>
                                @if($request->wife_complate_info == 0)
                                    <a href="#" class="badge badge-warning">ارسال تذكير</a>
                                @endif
                            </td>
                            <td class="text-center">{{ getRequestType($request->req_type) }}</td>
                            <td class="text-center">{!! getRequestStatus($request->status) !!}</td>
                            <td class="text-center">
                                <a href="{{route('admin.request.view',['id'=>$request->reqid,'status'=>'Waiting_Approve'])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black"/>
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"/>
                                        </svg>
                                    </span>
                                </a>
                                <a href="{{route('admin.request.delete',[$request->reqid])}}" onclick="return confirm('هل أنت متأكد من حذف الطلب')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
            {!! $requests->links() !!}
        </div>
    </div>
@endsection
