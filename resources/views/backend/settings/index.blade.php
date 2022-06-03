@extends('backend.layouts.app')

@section('title', 'إضافة مستخدم')

@section('settings', 'here show')
@section('settings_setting', 'active')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column mb-1">
                <span class="card-label fw-bolder fs-3 mb-1">
                    <i class="fas fa-cogs fa-fw mx-2"></i>إعدادات الموقع العامة
                </span>
                <small class="text-danger d-block">
                    برجاء الحذر عند التعامل مع خيارات النظام حيث أن أي خطأ سيؤثر علي أداء التطبيق وربما يؤدي لتوقفه عن العمل
                </small>
            </h3>
        </div>
        <div class="card-body">
            <form action="{{route('admin.settings.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">تنشيط سيرفر الرسائل القصيرة ( SMS )</label>
                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-30px" name="close_sms_server" type="checkbox" value="1" id="closeSmsServer"
                                    @if(\App\Models\Setting::where('varname', 'closeSmsServer')->first()->value == 0) checked @endif/>
                                <label class="form-check-label" for="closeSmsServer">تنشيط السيرفر</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="update_request_complete_timer">عدد الساعات قبل وضع طلب وارد في قائمة الانتظار حال عدم اكمال بياناته</label>
                            <input type="number" name="update_request_complate_timer" id="update_request_complete_timer" class="form-control" value="{{\App\Models\Setting::where('varname', 'update_request_complate_timer')->first()->value}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="update_request_complete_reminder_timer">عدد الساعات قبل وضع طلب وارد في قائمة الانتظار في حالة عدم تجاوب الطرف بعد التنبيه</label>
                            <input type="number" name="update_request_complate_reminder_timer" id="update_request_complete_reminder_timer" class="form-control" value="{{\App\Models\Setting::where('varname', 'update_request_complate_reminder_timer')->first()->value}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="max_daily_requests">أقصى عدد من القضايا يمكن استقبالها خلال اليوم</label>
                            <input type="number" name="max_daily_requests" id="max_daily_requests" class="form-control" value="{{\App\Models\Setting::where('varname', 'max_daily_requests')->first()->value}}">
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
