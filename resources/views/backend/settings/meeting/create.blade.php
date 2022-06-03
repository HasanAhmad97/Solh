@extends('backend.layouts.app')

@section('title', 'اضافة موعد للقضايا')

@section('settings', 'here show')
@section('settings_meeting', 'active')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-plus fa-fw mx-2"></i>اضافة موعد للقضايا
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.meeting.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">العنوان</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="مثلاً: 1 الظهر" value="{{old('title')}}">
                                    @error('title')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="order_level">الترتيب في الأولوية</label>
                                    <input type="number" name="order_level" id="order_level" class="form-control" value="{{old('order_level', \App\Models\RequestMeetingTime::count() + 1)}}">
                                    @error('order_level')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="session_time_start">وقت بداية الجلسة</label>
                                    <input type="number" name="session_time_start" id="session_time_start" class="form-control" value="{{old('session_time_start')}}">
                                    @error('session_time_start')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="session_time_end">وقت نهاية الجلسة</label>
                                    <input type="number" name="session_time_end" id="session_time_end" class="form-control" value="{{old('session_time_end')}}">
                                    @error('session_time_end')<small class="text-danger">{{$message}}</small>@enderror
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
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#session_time_start").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i K",
            time_24hr: false,
            defaultDate: "{{old('session_time_start')}}"
        });
        $("#session_time_end").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i K",
            time_24hr: false,
            defaultDate: "{{old('session_time_end')}}"
        });
    </script>
@endsection
