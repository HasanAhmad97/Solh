@extends('backend.layouts.app')

@section('title', 'أضف مجلس صلح جديد')

@section('settings', 'here show')
@section('settings_councils', 'active')


@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-plus fa-fw mx-2"></i>أضف مجلس صلح جديد
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.councils.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="room_code">رمز المجلس</label>
                                    <input type="text" name="room_code" id="room_code" class="form-control" value="{{old('room_code')}}">
                                    @error('room_code')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="level_code">رمز الدور</label>
                                    <input type="text" name="level_code" id="level_code" class="form-control" value="{{old('level_code')}}">
                                    @error('level_code')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="total_chairs">عدد المقاعد</label>
                                    <input type="number" name="total_chairs" id="total_chairs" class="form-control" value="{{old('total_chairs', '0')}}">
                                    @error('total_chairs')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="order_level">الترتيب <small>( الأولوية في الحجز )</small></label>
                                    <input type="number" name="order_level" id="order_level" class="form-control" value="{{old('order_level', '0')}}">
                                    <small class="text-danger">سيقوم النظام بتوزيع حجوزات الصلح بصورة تلقائية وفقاً للأولوية في الحجز</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="meeting_location">بيئة الانعقاد</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="meeting_location" id="meeting_location" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="inside_building" @if(old('meeting_location') == 'inside_building') selected @endif>داخل الجمعية</option>
                                            <option value="zoom_meeting" @if(old('meeting_location') == 'zoom_meeting') selected @endif>من على بعد</option>
                                            <option value="booth" @if(old('meeting_location') == 'booth') selected @endif>كلاهما</option>
                                        </select>
                                    </div>
                                    <small class="text-danger">سيتم ارسال رابط دعوة اجتماع اونلاين في حالة الانعقاد خارج الجمعية</small>
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
