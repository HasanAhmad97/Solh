<!DOCTYPE html>
<html lang="ar" direction="rtl" dir="rtl" style="direction: rtl">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME')}} | @yield('title')</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('backend.inc.style')
    @yield('style')
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('backend.inc.aside')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('backend.inc.header')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @include('backend.inc.toolbar')
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl">
                            @yield('content')
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
