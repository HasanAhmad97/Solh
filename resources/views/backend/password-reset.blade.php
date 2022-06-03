<!DOCTYPE html>
<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <title>استعادة كلمة المرور</title>
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
                <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">هل نسيت كلمة السر ؟</h1>
                        <div class="text-gray-400 fw-bold fs-4">أدخل بريدك الإلكتروني أو رقم الهاتف لإعادة تعيين كلمة المرور الخاصة بك.</div>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fw-bolder text-gray-900 fs-6">البريد الإلكتروني أو رقم الهاتف</label>
                        <input class="form-control form-control-solid" type="text" placeholder="" name="email" autocomplete="off" />
                    </div>
                    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                        <button type="button" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                            <span class="indicator-label">استعادة كلمة المرور</span>
                            <span class="indicator-progress">الرجاء الانتظار...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <a href="{{route('admin.getLogin')}}" class="btn btn-lg btn-light-primary fw-bolder">الغاء</a>
                    </div>
                    <div class="separator my-2"></div>
                    <p class="text-center my-2">جميع الحقوق محفوظة {{date('Y')}}@ نفذ بواسطة <a href="https://www.facebook.com/mostafa.eid.942/" target="_blank">مصطفى عيد</a>.</p>
                </form>
            </div>
        </div>
    </div>
</div>
<script>var hostUrl = "{{asset('assets/')}}";</script>
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/authentication/password-reset/password-reset.js')}}"></script>
</body>
</html>
