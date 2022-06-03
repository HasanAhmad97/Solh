<!DOCTYPE html>
<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <title>تسجيل الدخول</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <style>
        *{
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>
<body id="kt_body" class="bg-body">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url('{{asset('assets/images/bg.jpg')}}');background-size: cover;background-position: center center;">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <a href="#" class="mb-12">
                <img alt="Logo" src="{{asset('assets/images/horizental_logo_text.png')}}" class="h-60px" />
            </a>
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{route('admin.postLogin')}}">
                    @csrf
                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">تسجيل الدخول</h1>
                        <div class="text-gray-400 fw-bold fs-4">ليس لديك حساب ؟
                            <a href="{{route('admin.register')}}" class="link-primary fw-bolder">اضغط هنا</a>
                        </div>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bolder text-dark">البريد الإلكتروني أو رقم الهاتف</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
                        @error('email')<small class="text-danger">{{$message}}</small>@enderror
                    </div>
                    <div class="fv-row mb-10">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">كلمة المرور</label>
                            <a href="{{route('admin.password.reset')}}" class="link-primary fs-6 fw-bolder"> نسيت كلمة المرور ؟</a>
                        </div>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                        @error('password')<small class="text-danger">{{$message}}</small>@enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">تسجيل الدخول</span>
                            <span class="indicator-progress">الرجاء الانتظار...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <div class="separator my-2"></div>
                    <p class="text-center my-2">جميع الحقوق محفوظة {{date('Y')}}@ بدعم من <a href="https://www.alrajhiawqaf.sa/" target="_blank">أوقاف محمد بن عبدالعزيز الراجحي</a>.</p>
                </form>
            </div>
        </div>
    </div>
</div>
<script>var hostUrl = "{{asset('assets/')}}";</script>
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@if(Session::has('error'))
    <script>
        Swal.fire({
            text: "{{Session::get('msg')}}",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "حسنا",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
@endif
</body>
</html>
