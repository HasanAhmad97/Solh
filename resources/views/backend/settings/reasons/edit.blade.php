@extends('backend.layouts.app')

@section('title', 'تعديل أسباب القضايا')

@section('settings', 'here show')
@section('settings_reasons', 'active')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-edit fa-fw mx-2"></i>تعديل أسباب القضايا
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.reasons.update', $reason->reason_id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">عنوان الحالة</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{old('title', $reason->title)}}">
                                    @error('title')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="default_complainant">المدعي الافتراضي</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="default_complainant" id="default_complainant" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="unknown">بدون تحديد</option>
                                            <option value="husband" @if(old('default_complainant', $reason->default_complainant) == 'husband') selected @endif>الزوج</option>
                                            <option value="wife" @if(old('default_complainant', $reason->default_complainant) == 'wife') selected @endif>الزوجة</option>
                                            <option value="husband_agent" @if(old('default_complainant', $reason->default_complainant) == 'husband_agent') selected @endif>وكيل الزوج</option>
                                            <option value="wife_agent" @if(old('default_complainant', $reason->default_complainant) == 'wife_agent') selected @endif>وكيل الزوجة</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="closed">الحالة</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="closed" id="closed" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="0" @if(old('closed', $reason->closed) == 0) selected @endif>فعال</option>
                                            <option value="1" @if(old('closed', $reason->closed) == 1) selected @endif>غير فعال</option>
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
