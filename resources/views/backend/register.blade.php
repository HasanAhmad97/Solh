<!DOCTYPE html>
<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <title>تسجيل حساب جديد</title>
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
            <div class="w-lg-850px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form"  method="post" action="{{route('admin.postRegistration')}}">
                    @csrf
                    <div class="mb-10 text-center">
                        <h1 class="text-dark mb-3">تسجيل حساب جديد</h1>
                        <div class="text-gray-400 fw-bold fs-4">لديك حساب بالفعل ؟
                            <a href="{{route('admin.login')}}" class="link-primary fw-bolder">تسجيل الدخول</a>
                        </div>
                    </div>
                    <div class="row fv-row mb-7">
                        <div class="col-lg-6">
                            <label class="form-label fw-bolder text-dark fs-6">الاسم الرباعي</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="name" autocomplete="off" />
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-bolder text-dark fs-6">رقم الوية الوطنية / هوية مقيم </label>
                            <input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="id_number" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row fv-row mb-7">
                        <div class="col-lg-6">
                            <label class="form-label fw-bolder text-dark fs-6">البريد الإلكتروني</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" placeholder="" name="email" autocomplete="off" />
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-bolder text-dark fs-6">رقم الهاتف</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="phone" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row mb-10 fv-row" data-kt-password-meter="true">
                        <div class="col-lg-6">
                            <div class="mb-1">
                                <label class="form-label fw-bolder text-dark fs-6">كلمة المرور</label>
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
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
                            <div class="text-muted">استخدم 8 أحرف أو أكثر مع مزيج من الأحرف والأرقام والرموز.</div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-bolder text-dark fs-6">تأكيد كلمة المرور</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_password" autocomplete="off" />
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">تسجيل حساب جديد</span>
                            <span class="indicator-progress">الرجاء الاننتظار...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
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
<script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>
</body>
</html>
