@extends('backend.layouts.app')

@section('title', 'تعديل جنسية')

@section('settings', 'here show')
@section('settings_nationality', 'active')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-edit fa-fw mx-2"></i>تعديل جنسية
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.nationality.update', $nationality->nationality_id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">الجنسية</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{old('title', $nationality->title)}}">
                                    @error('title')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title_female">للمؤنث</label>
                                    <input type="text" name="title_female" id="title_female" class="form-control" value="{{old('title_female', $nationality->title_female)}}">
                                    @error('title_female')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="country">اسم الدولة</label>
                                    <input type="text" name="country" id="country" class="form-control" value="{{old('country', $nationality->country)}}">
                                    @error('country')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="closed">الحالة</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="closed" id="closed" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="0" @if(old('closed', $nationality->closed) == 0) selected @endif>فعال</option>
                                            <option value="1" @if(old('closed', $nationality->closed) == 1) selected @endif>غير فعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="add_by">مضاف بواسطة</label>
                                    <input type="text" id="add_by" disabled readonly class="form-control disabled" value="{{\App\Models\User::find($nationality->added_userid)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_add">تاريخ الاضافة</label>
                                    <input type="text" id="date_add" disabled readonly class="form-control disabled" value="{{timer($nationality->dateadd, "d/m/Y H:i:s")}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="update_by">اخر تعديل بواسطة</label>
                                    <input type="text" id="update_by" disabled readonly class="form-control disabled"
                                           value="{{$nationality->edited_userid == 0 || $nationality->edited_userid == '' || $nationality->edited_userid == null ? '---' : \App\Models\User::find($nationality->edited_userid)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_update">آخر تعديل</label>
                                    <input type="text" id="date_update" disabled readonly class="form-control disabled"
                                           value="{{$nationality->date_updated == 0 || $nationality->date_updated == '' || $nationality->date_updated == null ? '---' : timer($nationality->date_updated, "d/m/Y H:i:s")}}">
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
