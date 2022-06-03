@extends('backend.layouts.app')

@section('title', 'تعديل مجلس صلح')

@section('settings', 'here show')
@section('settings_councils', 'active')


@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                    <span class="card-label fw-bolder fs-3 mb-1">
                        <i class="fas fa-edit fa-fw mx-2"></i>تعديل مجلس صلح
                    </span>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.settings.councils.update', $council->council_id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="room_code">رمز المجلس</label>
                                    <input type="text" name="room_code" id="room_code" class="form-control" value="{{old('room_code', $council->room_code)}}">
                                    @error('room_code')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="level_code">رمز الدور</label>
                                    <input type="text" name="level_code" id="level_code" class="form-control" value="{{old('level_code', $council->level_code)}}">
                                    @error('level_code')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="total_chairs">عدد المقاعد</label>
                                    <input type="number" name="total_chairs" id="total_chairs" class="form-control" value="{{old('total_chairs', $council->total_chairs)}}">
                                    @error('total_chairs')<small class="text-danger">{{$message}}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="order_level">الترتيب <small>( الأولوية في الحجز )</small></label>
                                    <input type="number" name="order_level" id="order_level" class="form-control" value="{{old('order_level', $council->order_level)}}">
                                    <small class="text-danger">سيقوم النظام بتوزيع حجوزات الصلح بصورة تلقائية وفقاً للأولوية في الحجز</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="meeting_location">بيئة الانعقاد</label>
                                    <div>
                                        <select class="form-select form-select-solid" name="meeting_location" id="meeting_location" data-kt-select2="true" data-placeholder="حدد خيار">
                                            <option value="inside_building" @if(old('meeting_location', $council->meeting_location) == 'inside_building') selected @endif>داخل الجمعية</option>
                                            <option value="zoom_meeting" @if(old('meeting_location', $council->meeting_location) == 'zoom_meeting') selected @endif>من على بعد</option>
                                            <option value="booth" @if(old('meeting_location', $council->meeting_location) == 'booth') selected @endif>كلاهما</option>
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
                                            <option value="0" @if(old('closed', $council->closed) == 0) selected @endif>فعال</option>
                                            <option value="1" @if(old('closed', $council->closed) == 1) selected @endif>غير فعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="add_by">مضاف بواسطة</label>
                                    <input type="text" id="add_by" disabled readonly class="form-control disabled" value="{{\App\Models\User::find($council->added_userid)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_add">تاريخ الاضافة</label>
                                    <input type="text" id="date_add" disabled readonly class="form-control disabled" value="{{timer($council->dateadd, "d/m/Y H:i:s")}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="update_by">اخر تعديل بواسطة</label>
                                    <input type="text" id="update_by" disabled readonly class="form-control disabled"
                                           value="{{$council->edited_userid == 0 || $council->edited_userid == '' || $council->edited_userid == null ? '---' : \App\Models\User::find($council->edited_userid)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_update">آخر تعديل</label>
                                    <input type="text" id="date_update" disabled readonly class="form-control disabled"
                                           value="{{$council->date_updated == 0 || $council->date_updated == '' || $council->date_updated == null ? '---' : timer($council->date_updated, "d/m/Y H:i:s")}}">
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
