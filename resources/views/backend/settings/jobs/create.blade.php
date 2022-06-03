@extends('backend.layouts.app')

@section('title', 'أضف وظيفة جديدة')

@section('settings', 'here show')
@section('settings_jobs', 'active')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-plus fa-fw mx-2"></i>أضف وظيفة جديدة
                </span>
            </h3>
        </div>
        <div class="card-body">
            <form action="{{route('admin.settings.jobs.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="title">المسمى الوظيفي</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
                            @error('title')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="closed">الحالة</label>
                            <div>
                                <select class="form-select form-select-solid" name="closed" id="closed" data-kt-select2="true" data-placeholder="حدد خيار">
                                    <option value="0" @if(old('closed') == 0) selected @endif>فعال</option>
                                    <option value="1" @if(old('closed') == 1) selected @endif>غير فعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator my-10"></div>
                <h3 class="mb-5 d-flex align-items-center">
                    <i class="fas fa-cogs fa-fw mx-3"></i>
                    صلاحيات المستخدم
                </h3>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_attendance" id="requests_attendance"/>
                            <label class="form-check-label" for="requests_attendance">
                                تحضير المستفيدين
                            </label>
                        </div>
                    </div>
                </div>
                <h5 class="mb-5">الطلبات قيد الانتظار</h5>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="waiting_review_requests" id="waiting_review_requests"/>
                            <label class="form-check-label" for="waiting_review_requests">
                                عرض الطلبات
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="waiting_review_requests_delete" id="waiting_review_requests_delete"/>
                            <label class="form-check-label" for="waiting_review_requests_delete">
                                حذف الطلبات
                            </label>
                        </div>
                    </div>
                </div>
                <h5 class="mb-5">الطلبات بإنتظار الاعتماد</h5>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="waiting_approved_requests" id="waiting_approved_requests"/>
                            <label class="form-check-label" for="waiting_approved_requests">
                                عرض الطلبات
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="waiting_approved_requests_delete" id="waiting_approved_requests_delete"/>
                            <label class="form-check-label" for="waiting_approved_requests_delete">
                                حذف الطلبات
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="waiting_approved_requests_approve" id="waiting_approved_requests_approve"/>
                            <label class="form-check-label" for="waiting_approved_requests_approve">
                                اعتماد الطلب
                            </label>
                        </div>
                    </div>
                </div>
                <h5 class="mb-5">تحديد الجلسات للقضايا</h5>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_sessions_set_session" id="requests_sessions_set_session"/>
                            <label class="form-check-label" for="requests_sessions_set_session">
                                اعتماد جلسة صلح جديدة
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_sessions_archive" id="requests_sessions_archive"/>
                            <label class="form-check-label" for="requests_sessions_archive">
                                أرشيف الجلسات للقضايا
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_sessions_delete" id="requests_sessions_delete"/>
                            <label class="form-check-label" for="requests_sessions_delete">
                                حذف القضايا
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="request_session_close" id="request_session_close"/>
                            <label class="form-check-label" for="request_session_close">
                                اغلاق القضايا
                            </label>
                        </div>
                    </div>
                </div>
                <h5 class="mb-5">التقارير</h5>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_reports_moslh" id="requests_reports_moslh"/>
                            <label class="form-check-label" for="requests_reports_moslh">
                                تقارير المصلحين
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_reports_incoming" id="requests_reports_incoming"/>
                            <label class="form-check-label" for="requests_reports_incoming">
                                التقارير وفقاً للمعاملات الواردة
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_reports_outgoing" id="requests_reports_outgoing"/>
                            <label class="form-check-label" for="requests_reports_outgoing">
                                التقارير وفقاً للمعاملات الصادرة
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="requests_reports_categories" id="requests_reports_categories"/>
                            <label class="form-check-label" for="requests_reports_categories">
                                التقارير وفقاً لتصنيف القضايا
                            </label>
                        </div>
                    </div>
                </div>
                <h5 class="mb-5">اعدادات النظام</h5>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_general" id="settings_general"/>
                            <label class="form-check-label" for="settings_general">
                                اعدادات النظام العامة
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_study_levels" id="settings_study_levels"/>
                            <label class="form-check-label" for="settings_study_levels">
                                المستويات التعليمية
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_request_referral" id="settings_request_referral"/>
                            <label class="form-check-label" for="settings_request_referral">
                                الجهات المشاركة
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_nationality_list" id="settings_nationality_list"/>
                            <label class="form-check-label" for="settings_nationality_list">
                                الجنسيات
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_cases_reasons" id="settings_cases_reasons"/>
                            <label class="form-check-label" for="settings_cases_reasons">
                                أسباب القضايا
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_cases_categories" id="settings_cases_categories"/>
                            <label class="form-check-label" for="settings_cases_categories">
                                تصنيفات القضايا
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_cases_close_status" id="settings_cases_close_status"/>
                            <label class="form-check-label" for="settings_cases_close_status">
                                حالات اغلاق القضايا
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_councils_locations" id="settings_councils_locations"/>
                            <label class="form-check-label" for="settings_councils_locations">
                                مجالس الصلح
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row my-10">
                    <div class="col-md-3">
                        <div class="form-check form-switch form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-20px w-30px" type="checkbox" name="permission[]" value="settings_cases_meeting_time" id="settings_cases_meeting_time"/>
                            <label class="form-check-label" for="settings_cases_meeting_time">
                                مواعيد القضايا
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
