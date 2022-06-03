@extends('backend.layouts.app')

@section('title', 'تعديل بيانات')

@section('settings', 'here show')
@section('settings_study', 'active')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-edit fa-fw mx-2"></i>تعديل بيانات
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.study.update', $level->study_id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">عنوان المستوى التعليمي</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{old('title', $level->title)}}">
                                    @error('title')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="closed">الحالة</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="closed" id="closed" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="0" @if(old('closed', $level->closed) == 0) selected @endif>فعال</option>
                                            <option value="1" @if(old('closed', $level->closed) == 1) selected @endif>غير فعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="add_by">مضاف بواسطة</label>
                                    <input type="text" id="add_by" disabled readonly class="form-control disabled" value="{{\App\Models\User::find($level->added_userid)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_add">تاريخ الاضافة</label>
                                    <input type="text" id="date_add" disabled readonly class="form-control disabled" value="{{timer($level->dateadd, "d/m/Y H:i:s")}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="update_by">اخر تعديل بواسطة</label>
                                    <input type="text" id="update_by" disabled readonly class="form-control disabled"
                                           value="{{$level->edited_userid == 0 || $level->edited_userid == '' || $level->edited_userid == null ? '---' : \App\Models\User::find($level->edited_userid)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_update">آخر تعديل</label>
                                    <input type="text" id="date_update" disabled readonly class="form-control disabled"
                                           value="{{$level->date_updated == 0 || $level->date_updated == '' || $level->date_updated == null ? '---' : timer($level->date_updated, "d/m/Y H:i:s")}}">
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
