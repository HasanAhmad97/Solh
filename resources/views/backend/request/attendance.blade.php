@extends('backend.layouts.app')

@section('title', 'تحضير المستفيدين')
@section('request_attendance', 'active')
@section('toolbar')
    <div class="m-0">
        <div class = "me-7">
            <form method="post" action="{{route('admin.request.attendance.filter')}}">
               @csrf
                <input type="hidden" name="filter_type" value = "waiting" >
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
            <h3 class="card-title"><i class="fas fa-list fa-fw mx-2"></i>جلسات اليوم</h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">المكان</th>
                        <th class="min-w-125px">الزمان</th>
                        <th class="min-w-125px">تحضير المصلح</th>
                        <th class="min-w-125px">تحضير الطرف الأول</th>
                        <th class="min-w-125px">تحضير الطرف الثاني</th>
                    </tr>
                    </thead>
                    <tbody>
                @if($requests ?? '')
                    @foreach($requests as $key => $request)
                        <tr>
                            <td>{{($key+1) + ($requests->currentPage() - 1)*$requests->perPage()}}</td>
                            <td>
                                {{__('room_code')}} ( {{$request->council->room_code}} ) {{__('level_code')}} ( {{$request->council->level_code}} )
                            </td>
                            <td>{{$request->time->title}}</td>
                            <td>
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->moslh_present_date == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        {{$request->moslh_name->name}}
                                    </span>
                                <span class="text-muted fw-bold text-muted d-block fs-7">{{$request->moslh_name->phone}}</span>
                                  @if($request->moslh_present_date == 0)
                                            <a href="{{route('admin.request.getattendance',[$request->sessionid,'mos'])}}" class="badge badge-warning">تحضير</a>
                                        @else
                                         <span  class="badge badge-success">تم التحضير</span>
                                        @endif
                               
                            </td>
                            <td>
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->husband_present_date == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        {{$request->request->request_info->husband_name}}
                                    </span>
                                <span class="text-muted fw-bold text-muted d-block fs-7">{{$request->request->request_info->husband_phone}}</span>
                                 @if($request->husband_present_date == 0)
                                     <a href="{{route('admin.request.getattendance',[$request->sessionid,'first'])}}" class="badge badge-warning">تحضير</a>
                                @else
                                    <span  class="badge badge-success">تم التحضير</span>
                                @endif
                               
                            </td>
                            <td>
                                    <span class="text-dark fw-bolder mb-1 fs-6">
                                        @if($request->wife_present_date == 0)
                                            <i class="fas fa-times fa-fw mx-1 text-danger"></i>
                                        @else
                                            <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                        @endif
                                        {{$request->request->request_info->wife_name}}
                                    </span>
                                <span class="text-muted fw-bold text-muted d-block fs-7">{{$request->request->request_info->wife_phone}}</span>
                                      @if($request->wife_present_date == 0)
                                         <a href="{{route('admin.request.getattendance',[$request->sessionid,'second'])}}" class="badge badge-warning">تحضير</a>
                                        @else
                                          <span  class="badge badge-success">تم التحضير</span>
                                        @endif
                                
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
            {!! $requests->links() !!}
            @endif
        </div>
    </div>
@endsection
