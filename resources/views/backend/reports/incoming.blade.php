@extends('backend.layouts.app')

@section('title', 'وفقاً للمعاملات الواردة')

@section('reports', 'here show')
@section('reports_incoming', 'active')

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
                                <label class="form-label fw-bold" for="f_name">اسم الطرف الاول</label>
                                <input type="text" name="f_name" id="f_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="s_name">اسم الطرف الثاني</label>
                                <input type="text" name="s_name" id="s_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="f_phone">رقم هاتف الطرف الاول</label>
                                <input type="text" name="f_phone" id="f_phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="s_phone">رقم هاتف الطرف الثاني</label>
                                <input type="text" name="s_phone" id="s_phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="f_id">رقم هوية الطرف الاول</label>
                                <input type="text" name="f_id" id="f_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10">
                                <label class="form-label fw-bold" for="s_id">رقم هوية الطرف الثاني</label>
                                <input type="text" name="s_id" id="s_id" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">إعادة ضبط</button>
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
                    <i class="fas fa-cogs fa-fw mx-2"></i>التقارير حسب الوارد
                </span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>م</th>
                        <th class="min-w-125px">الجهة الوارد منها</th>
                        <th class="text-center">عدد قضايا الإدعاء من الزوج</th>
                        <th class="text-center">عدد قضايا الإدعاء من الزوجة</th>
                        <th class="text-center">إجمالي عدد المعاملات</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $allTotalRequestHusband = 0;
                            $allTotalRequestWife = 0;
                        @endphp
                        @foreach($dates as $key => $date)
                            <tr>
                                <td colspan="5" class="text-center bg-success fw-bolder fs-3">{{$date}}</td>
                            </tr>
                            @foreach($users as $key => $incoming)
                                @if($incoming->RequestDate == $date)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$incoming->title}}</td>
                                        <td>{{$incoming->totalHusbandRequests}}</td>
                                        <td>{{$incoming->totalWifeRequests}}</td>
                                        <td>{{$incoming->totalHusbandRequests+$incoming->totalWifeRequests}}</td>
                                    </tr>
                                    @php
                                        $allTotalRequestHusband += $incoming->totalHusbandRequests;
                                        $allTotalRequestWife += $incoming->totalWifeRequests;
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-primary">
                            <th colspan="2" class="fw-bolder fs-3">المجاميع</th>
                            <th class="fw-bolder fs-3">{{$allTotalRequestHusband}}</th>
                            <th class="fw-bolder fs-3">{{$allTotalRequestWife}}</th>
                            <th class="fw-bolder fs-3">{{$allTotalRequestHusband+$allTotalRequestWife}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
