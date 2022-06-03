@extends('backend.layouts.app')

@section('title', 'مجالس الصلح')

@section('settings', 'here show')
@section('settings_councils', 'active')

@section('toolbar')
    <a href="{{route('admin.settings.councils.create')}}" class="btn btn-sm btn-primary">أضافة جديد</a>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-building fa-fw mx-2"></i>التحكم بمجالس الصلح المضافة
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">رمز المجلس</th>
                        <th class="min-w-125px">رمز الدور</th>
                        <th class="min-w-125px">عدد المقاعد</th>
                        <th class="min-w-125px">الترتيب</th>
                        <th class="min-w-125px">مكان الانعقاد</th>
                        <th class="min-w-125px text-end">خيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($councils as $key => $council)
                        <tr>
                            <td>{{($key+1) + ($councils->currentPage() - 1)*$councils->perPage()}}</td>
                            <td>
                                @if($council->closed == 1)
                                    <i class="fas fa-times fa-fw mx-2 text-danger"></i>
                                @else
                                    <i class="fas fa-check fa-fw mx-2 text-success"></i>
                                @endif
                                {{$council->room_code}}
                            </td>
                            <td>{{$council->level_code}}</td>
                            <td>{{$council->total_chairs}}</td>
                            <td>{{$council->order_level}}</td>
                            <td>{{getMeetingLocation($council->meeting_location)}}</td>
                            <td class="text-end">
                                <a href="{{route('admin.settings.councils.edit', $council->council_id)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black"></path>
                                            <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </a>
                                <a href="javascript:void(0);" onclick="deleteModal('{{route('admin.settings.councils.delete', $council->council_id)}}');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
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
            {!! $councils->links() !!}
        </div>
    </div>
@endsection
