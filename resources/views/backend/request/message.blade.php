<!DOCTYPE html>
<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME')}} |الحالة </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('backend.inc.style')
    @yield('style')
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="#">
            {{env('APP_NAME')}}
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black"/>
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black"/>
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a class="menu-link" href="{{route('admin.login')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <i class="fas fa-key"></i>
                            </span>
                        </span>
                        <span class="menu-title">تسجيل الدخول</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{route('admin.register')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <i class="fas fa-address-card"></i>                            
                            </span>
                        </span>
                        <span class="menu-title">تسجيل حساب جديد</span>
                    </a>
                </div>
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-0">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">الطلبات</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link @yield('request')" href="{{route('admin.request.create')}}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black"/>
                                    <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">أضف طلب جديد</span>
                    </a>
                </div>
                    </div>
                </div>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
</div>

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('backend.inc.header')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @include('backend.inc.toolbar')
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl">
                                <div class="card shadow-sm mb-4">
                                     <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-plus fa-fw mx-2"></i>حالة الطلب</h3>
                                    </div>
                                  <div class="card-body">
                                      ok  
                                    </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('flash::message')
    @include('backend.inc.script')
    @yield('script')
@if(Session::has('status'))
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        @if(Session::get('status') == 'success')
            toastr.success("{{Session::get('msg')}}");
        @elseif(Session::get('status') == 'error')
            toastr.error("{{Session::get('msg')}}");
        @endif
    </script>
@endif
<script>
    function deleteModal(red) {
        Swal.fire({
            title: 'تأكيد الحذف',
            text: "هل أنت متأكد من حذف هذا؟",
            icon: 'warning',
            confirmButtonText: 'حذف',
            cancelButtonText: 'الغاء',
            buttonsStyling: false,
            showCancelButton: true,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-primary'
            }
        }).then(function(result) {
            if (result.value) {
                window.location.href = red;
            }
        })
    }

    function closeModal(red) {
        Swal.fire({
            title: 'تأكيد الاغلاق',
            text: "هل أنت متأكد من اغلاق هذا؟",
            icon: 'warning',
            confirmButtonText: 'اغلاق',
            cancelButtonText: 'الغاء',
            buttonsStyling: false,
            showCancelButton: true,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-primary'
            }
        }).then(function(result) {
            if (result.value) {
                window.location.href = red;
            }
        })
    }
    function activeModal(red) {
        Swal.fire({
            title: 'تأكيد التفعيل',
            text: "هل أنت متأكد من تفعيل هذا؟",
            icon: 'warning',
            confirmButtonText: 'تفعيل',
            cancelButtonText: 'الغاء',
            buttonsStyling: false,
            showCancelButton: true,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: 'btn btn-primary'
            }
        }).then(function(result) {
            if (result.value) {
                window.location.href = red;
            }
        })
    }
</script>
</body>
</html>


