@extends('backend.layouts.app')

@section('title', 'اضافة حالة اغلاق القضايا')

@section('settings', 'here show')
@section('settings_close', 'active')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-plus fa-fw mx-2"></i>اضافة حالة اغلاق القضايا
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.close.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">عنوان الحالة</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
                                    @error('title')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="require_notification">يتطلب تنبيه ( ارسال اشعار للطرفين ) ؟</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="require_notification" id="require_notification" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="0" @if(old('require_notification') == 0) selected @endif>لا</option>
                                            <option value="1" @if(old('require_notification') == 1) selected @endif>نعم</option>
                                        </select>
                                    </div>
                                    @error('require_notification')<small class="text-danger">{{$message}}</small>@enderror
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
