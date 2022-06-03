@extends('backend.layouts.app')

@section('title', 'التحكم بالمستخدمين')

@section('users', 'here show')
@section('users_index', 'active')

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
                                <label class="form-label fw-bold" for="name">الاسم</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="phone">رقم الهاتف</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{$phone}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="email">البريد</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{$email}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="status">الحالة</label>
                                <select class="form-select form-select-solid" name="status" id="status" data-control="select2" data-placeholder="حدد خيار" data-allow-clear="true">
                                    <option></option>
                                    <option value="email_confirm" @if($status == 'email_confirm') selected @endif>العضوية بحاجة للتأكيد عبر البريد</option>
                                    <option value="closed1" @if($status == 'closed1') selected @endif>العضوية مغلقة</option>
                                    <option value="closed0" @if($status == 'closed0') selected @endif>العضوية نشيطة</option>
                                </select>
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
    <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-primary">أضافة جديد</a>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-users fa-fw mx-2"></i>التحكم بالعضويات
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-around mb-3">
                <span class="badge badge-warning"><i class="fas fa-envelope fa-fw mx-1 text-white"></i> العضوية بحاجة للتأكيد عبر البريد</span>
                <span class="badge badge-danger"><i class="fas fa-exclamation-triangle fa-fw mx-1 text-white"></i> العضوية مغلقة</span>
                <span class="badge badge-success"><i class="fas fa-check fa-fw mx-1 text-white"></i> العضوية نشيطة.</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">الإسم</th>
                        <th class="text-center">رقم الهاتف</th>
                        <th class="text-center">البريد</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الأيبي</th>
                        <th class="text-center">خيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{($key+1) + ($users->currentPage() - 1)*$users->perPage()}}</td>
                                <td>{{$user->name}}</td>
                                <td class="text-center">{{$user->phone}}</td>
                                <td class="text-center">{{$user->email}}</td>
                                <td class="text-center">
                                    @if($user->closed == 1)
                                        <i class="fas fa-exclamation-triangle fa-fw mx-1 text-danger"></i>
                                    @else
                                        <i class="fas fa-check fa-fw mx-1 text-success"></i>
                                    @endif
                                    @if($user->emailconfirm == 0)
                                        <i class="fas fa-envelope fa-fw mx-1 text-warning"></i>
                                    @endif
                                </td>
                                <td class="text-center">{{$user->useradress}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.users.edit', $user->userid)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black"></path>
                                                <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    <a href="javascript:void(0);" onclick="deleteModal('{{route('admin.users.delete', $user->userid)}}')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    @if($user->closed == 0)
                                        <a href="javascript:void(0);" onclick="closeModal('{{route('admin.users.close', $user->userid)}}')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black"/>
                                                    <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black"/>
                                                </svg>
                                            </span>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" onclick="activeModal('{{route('admin.users.active', $user->userid)}}')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="black"/>
                                                    <path d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="black"/>
                                                </svg>
                                            </span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! $users->links() !!}
        </div>
    </div>
@endsection
