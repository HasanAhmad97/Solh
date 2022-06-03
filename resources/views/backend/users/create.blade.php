@extends('backend.layouts.app')

@section('title', 'إضافة مستخدم')

@section('users', 'here show')
@section('users_create', 'active')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column mb-1">
                        البيانات الشخصية
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.store')}}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">الإسم</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                            @error('name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <div class="fv-row" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <label class="form-label" for="password">كلمة المرور</label>
                                    <div class="position-relative mb-3">
                                        <input class="form-control" id="password" type="password" placeholder="" name="password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                            <i class="bi bi-eye-slash fs-2"></i>
                                            <i class="bi bi-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                </div>
                                <div class="text-muted">
                                    استخدم 8 أحرف أو أكثر مع مزيج من الأحرف والأرقام والرموز.
                                </div>
                                @error('password')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">أعد كتابة كلمة المرور</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            @error('password_confirmation')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                            @error('email')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="usergroup" class="form-label">الرتبة</label>
                            <select class="form-select form-select-solid" name="usergroup" id="usergroup" data-control="select2" data-placeholder="حدد خيار">
                                <option value="1" @if(old('usergroup') == 1) selected @endif>عضو</option>
                                <option value="2" @if(old('usergroup') == 2) selected @endif>مصلح</option>
                                <option value="3" @if(old('usergroup') == 3) selected @endif>موظف</option>
                                <option value="10" @if(old('usergroup') == 10) selected @endif>إداري</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="number" pattern="[0-9]*" onkeypress="return (event.charCode >= 65 &amp;&amp; event.charCode <= 90) || (event.charCode >= 97 &amp;&amp; event.charCode <= 122) || (event.charCode >= 48 &amp;&amp; event.charCode <= 57)" name="phone" value="{{old('phone')}}" class="form-control" id="phone" placeholder="966xxxxxxxxx">
                            <small>رقم الهاتف يجب أن يكون بالصيغة الدولية</small>
                            @error('phone')<small class="text-danger d-block">{{$message}}</small>@enderror
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary"> إضافة العضو</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
