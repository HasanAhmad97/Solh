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
                    <a class="menu-link @yield('dashboard')" href="{{route('admin.dashboard')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">الصفحة الرئيسية</span>
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
                @if(auth()->user()->usergroup == 10 )
                    <div class="menu-item">
                        <a class="menu-link @yield('request_selfwaiting')" href="{{route('admin.request.selfwaiting')}}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 svg-icon-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                        <path d="M11.276 13.654C11.276 13.2713 11.3367 12.9447 11.458 12.674C11.5887 12.394 11.738 12.1653 11.906 11.988C12.0833 11.8107 12.3167 11.61 12.606 11.386C12.942 11.1247 13.1893 10.896 13.348 10.7C13.5067 10.4947 13.586 10.2427 13.586 9.944C13.586 9.636 13.4833 9.356 13.278 9.104C13.082 8.84267 12.69 8.712 12.102 8.712C11.486 8.712 11.066 8.866 10.842 9.174C10.6273 9.482 10.52 9.82267 10.52 10.196L10.534 10.574H8.826C8.78867 10.3967 8.77 10.2333 8.77 10.084C8.77 9.552 8.90067 9.07133 9.162 8.642C9.42333 8.20333 9.81067 7.858 10.324 7.606C10.8467 7.354 11.4813 7.228 12.228 7.228C13.1987 7.228 13.9687 7.44733 14.538 7.886C15.1073 8.31533 15.392 8.92667 15.392 9.72C15.392 10.168 15.322 10.5507 15.182 10.868C15.042 11.1853 14.874 11.442 14.678 11.638C14.482 11.834 14.2253 12.0533 13.908 12.296C13.544 12.576 13.2733 12.8233 13.096 13.038C12.928 13.2527 12.844 13.528 12.844 13.864V14.326H11.276V13.654ZM11.192 15.222H12.928V17H11.192V15.222Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">استشارات ذاتية</span>
                            <span class="badge badge-danger fw-bolder fs-8 px-2 py-1 ms-2">
                                {{\App\Models\Request::where('status', 'WAITING')->where('transaction_number','0')->count()}}
                            </span>
                        </a>
                    </div>
                @endif
                @if(auth()->user()->usergroup == 10)
                    <div class="menu-item">
                        <a class="menu-link @yield('request_waiting')" href="{{route('admin.request.waiting')}}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 svg-icon-muted">
                                   <i class="fas fa-business-time"></i>
                                </span>
                            </span>
                            <span class="menu-title">طلبات قيد الانتظار</span>
                            <span class="badge badge-danger fw-bolder fs-8 px-2 py-1 ms-2">
                                {{\App\Models\Request::where('status', 'WAITING')->where('transaction_number','!=','0')->count()}}
                            </span>
                        </a>
                    </div>
                @endif
                @if(auth()->user()->usergroup == 10)
                    <div class="menu-item">
                        <a class="menu-link @yield('request_waiting_approve')" href="{{route('admin.request.waiting.approve')}}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 svg-icon-muted">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                        <path d="M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">طلبات بانتظار الاعتماد</span>
                            <span class="badge badge-success fw-bolder fs-8 px-2 py-1 ms-2">
                                {{\App\Models\Request::where('status', 'WAITING_APPROVE')->count()}}
                            </span>
                        </a>
                    </div>
                @endif
                @if(auth()->user()->usergroup != 1)
                 <div class="menu-item">
                    <div class="menu-content pt-8 pb-0">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">إدارة الوقت</span>
                    </div>
                </div>
                 <div class="menu-item">
                    <a class="menu-link @yield('request_session')" href="{{route('admin.request.session')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="black"/>
                                    <rect x="7" y="17" width="6" height="2" rx="1" fill="black"/>
                                    <rect x="7" y="12" width="10" height="2" rx="1" fill="black"/>
                                    <rect x="7" y="7" width="6" height="2" rx="1" fill="black"/>
                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title"> تحديد الجلسات للقضايا</span>
                        <span class="badge badge-primary fw-bolder fs-8 px-2 py-1 ms-2">
                            {{\App\Models\Request::whereIn('status', ['APPROVED','RESCHEDULED'])->count()}}
                        </span>
                    </a>
                </div>
                @endif
                 @if(Auth::user()->usergroup == 10)
                    <div class="menu-item">
                        <a class="menu-link @yield('request_attendance')" href="{{route('admin.request.attendance')}}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 svg-icon-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21ZM16 11V9C16 6.8 14.2 5 12 5C9.8 5 8 6.8 8 9V11C7.2 11 6.5 11.7 6.5 12.5C6.5 13.3 7.2 14 8 14V15C8 17.2 9.8 19 12 19C14.2 19 16 17.2 16 15V14C16.8 14 17.5 13.3 17.5 12.5C17.5 11.7 16.8 11 16 11ZM13.4 15C13.7 15 14 15.3 13.9 15.6C13.6 16.4 12.9 17 12 17C11.1 17 10.4 16.5 10.1 15.7C10 15.4 10.2 15 10.6 15H13.4Z" fill="black"/>
                                        <path d="M9.2 12.9C9.1 12.8 9.10001 12.7 9.10001 12.6C9.00001 12.2 9.3 11.7 9.7 11.6C10.1 11.5 10.6 11.8 10.7 12.2C10.7 12.3 10.7 12.4 10.7 12.5L9.2 12.9ZM14.8 12.9C14.9 12.8 14.9 12.7 14.9 12.6C15 12.2 14.7 11.7 14.3 11.6C13.9 11.5 13.4 11.8 13.3 12.2C13.3 12.3 13.3 12.4 13.3 12.5L14.8 12.9ZM16 7.29998C16.3 6.99998 16.5 6.69998 16.7 6.29998C16.3 6.29998 15.8 6.30001 15.4 6.20001C15 6.10001 14.7 5.90001 14.4 5.70001C13.8 5.20001 13 5.00002 12.2 4.90002C9.9 4.80002 8.10001 6.79997 8.10001 9.09997V11.4C8.90001 10.7 9.40001 9.8 9.60001 9C11 9.1 13.4 8.69998 14.5 8.29998C14.7 9.39998 15.3 10.5 16.1 11.4V9C16.1 8.5 16 8 15.8 7.5C15.8 7.5 15.9 7.39998 16 7.29998Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">تحضير المستفيدين</span>
                        </a>
                    </div>
                @endif
                 @if(Auth::user()->usergroup == 10)
                    <div class="menu-item">
                        <a class="menu-link @yield('session_management')" href="{{route('admin.session.management')}}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 svg-icon-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21ZM16 11V9C16 6.8 14.2 5 12 5C9.8 5 8 6.8 8 9V11C7.2 11 6.5 11.7 6.5 12.5C6.5 13.3 7.2 14 8 14V15C8 17.2 9.8 19 12 19C14.2 19 16 17.2 16 15V14C16.8 14 17.5 13.3 17.5 12.5C17.5 11.7 16.8 11 16 11ZM13.4 15C13.7 15 14 15.3 13.9 15.6C13.6 16.4 12.9 17 12 17C11.1 17 10.4 16.5 10.1 15.7C10 15.4 10.2 15 10.6 15H13.4Z" fill="black"/>
                                        <path d="M9.2 12.9C9.1 12.8 9.10001 12.7 9.10001 12.6C9.00001 12.2 9.3 11.7 9.7 11.6C10.1 11.5 10.6 11.8 10.7 12.2C10.7 12.3 10.7 12.4 10.7 12.5L9.2 12.9ZM14.8 12.9C14.9 12.8 14.9 12.7 14.9 12.6C15 12.2 14.7 11.7 14.3 11.6C13.9 11.5 13.4 11.8 13.3 12.2C13.3 12.3 13.3 12.4 13.3 12.5L14.8 12.9ZM16 7.29998C16.3 6.99998 16.5 6.69998 16.7 6.29998C16.3 6.29998 15.8 6.30001 15.4 6.20001C15 6.10001 14.7 5.90001 14.4 5.70001C13.8 5.20001 13 5.00002 12.2 4.90002C9.9 4.80002 8.10001 6.79997 8.10001 9.09997V11.4C8.90001 10.7 9.40001 9.8 9.60001 9C11 9.1 13.4 8.69998 14.5 8.29998C14.7 9.39998 15.3 10.5 16.1 11.4V9C16.1 8.5 16 8 15.8 7.5C15.8 7.5 15.9 7.39998 16 7.29998Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">إدارة الجلسات</span>
                        </a>
                    </div>
                @endif
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-0">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">القضايا</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link @yield('archive_request')" href="{{route('admin.archive.request')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"/>
                                    <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">أرشيف القضايا</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link @yield('archive_sessions')" href="{{route('admin.archive.sessions')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black"/>
                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">أرشيف الجلسات</span>
                    </a>
                </div>
                                    @if(auth()->user()->usergroup != 1)

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @yield('reports')">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M17.7 5.59999C16.7 5.19999 15.5 5.50003 14.8 6.20003L10.2 10.8C9.5 11.5 8.4 11.8 7.5 11.5L5.10001 10.8V18.9H20.1V6.40004L17.7 5.59999Z" fill="black"/>
                                    <path d="M21 18H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="black"/>
                                </svg>
                            </span>
                        </span>

                        <span class="menu-title">التقارير</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link @yield('reports_mslh')" href="{{route('admin.report.mslh')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">تقارير المصلحين</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('reports_incoming')" href="{{route('admin.report.incoming')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> وفقاً للمعاملات الواردة</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('reports_outgoing')" href="{{route('admin.report.outgoing')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> وفقاً للمعاملات الصادرة</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link  @yield('reports_categories')" href="{{route('admin.report.categories')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> وفقاً لتصنيف القضايا</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
              @if(auth()->user()->usergroup != 1)

                <div class="menu-item">
                    <div class="menu-content pt-8 pb-0">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">أخرى</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link @yield('zoom')" href="{{route('admin.zoom')}}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M10.6 10.7C13.3 8 16.9 6.3 20.9 6C21.5 6 21.9 5.5 21.9 4.9V3C21.9 2.4 21.4 2 20.9 2C15.8 2.3 11.2 4.4 7.79999 7.8C4.39999 11.2 2.2 15.8 2 20.9C2 21.5 2.4 21.9 3 21.9H4.89999C5.49999 21.9 6 21.5 6 20.9C6.2 17 7.90001 13.4 10.6 10.7Z" fill="black"/>
                                    <path opacity="0.3" d="M14.8 14.9C16.4 13.3 18.5 12.2 20.9 12C21.5 11.9 21.9 11.5 21.9 10.9V9C21.9 8.4 21.4 8 20.8 8C17.4 8.3 14.3 9.8 12 12.1C9.7 14.4 8.19999 17.5 7.89999 20.9C7.89999 21.5 8.29999 22 8.89999 22H10.8C11.4 22 11.8 21.6 11.9 21C12.2 18.6 13.2 16.5 14.8 14.9ZM16.2 16.3C17.4 15.1 19 14.3 20.7 14C21.3 13.9 21.8 14.4 21.8 15V17C21.8 17.5 21.4 18 20.9 18.1C20.1 18.3 19.5 18.6 19 19.2C18.5 19.8 18.1 20.4 17.9 21.1C17.8 21.6 17.4 22 16.8 22H14.8C14.2 22 13.7 21.5 13.8 20.9C14.2 19.1 15 17.5 16.2 16.3Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">اعدادات الاجتماع المرئي</span>
                    </a>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @yield('users')">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z" fill="black"/>
                                    <path d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">التحكم بالأعضاء</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link @yield('users_index')" href="{{route('admin.users')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التحكم بالمستخدمين</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('users_mslh')" href="{{route('admin.users.mslh')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التحكم بالمصلحين</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('users_staff')" href="{{route('admin.users.staff')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التحكم بالموظفين</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('users_admins')" href="{{route('admin.users.admins')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التحكم بالمدراء</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('users_create')" href="{{route('admin.users.create')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">إضافة مستخدم</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('users_staff_create')" href="{{route('admin.users.staff.create')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">إضافة موظف</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @yield('settings')">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M21 13H15V11H21C21.6 11 22 10.6 22 10C22 9.4 21.6 9 21 9H15V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V9H11V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V9H3C2.4 9 2 9.4 2 10C2 10.6 2.4 11 3 11H9V13H3C2.4 13 2 13.4 2 14C2 14.6 2.4 15 3 15H9V21C9 21.6 9.4 22 10 22C10.6 22 11 21.6 11 21V15H13V21C13 21.6 13.4 22 14 22C14.6 22 15 21.6 15 21V15H21C21.6 15 22 14.6 22 14C22 13.4 21.6 13 21 13Z" fill="black"/>
                                    <path d="M16 17H8C7.4 17 7 16.6 7 16V8C7 7.4 7.4 7 8 7H16C16.6 7 17 7.4 17 8V16C17 16.6 16.6 17 16 17ZM14 10H10V14H14V10Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">اعدادات النظام</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_setting')" href="{{route('admin.settings')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">اعدادات النظام العامة</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_study')" href="{{route('admin.settings.study')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">المستويات التعليمية</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_jobs')" href="{{route('admin.settings.jobs')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الوظائف والصلاحيات</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_referral')" href="{{route('admin.settings.referral')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الجهات المشاركة</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_nationality')" href="{{route('admin.settings.nationality')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الجنسيات</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_reasons')" href="{{route('admin.settings.reasons')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">أسباب القضايا</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_categories')" href="{{route('admin.settings.categories')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">تصنيفات القضايا</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_close')" href="{{route('admin.settings.close')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">حالات اغلاق القضايا</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_councils')" href="{{route('admin.settings.councils')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">مجالس الصلح</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @yield('settings_meeting')" href="{{route('admin.settings.meeting')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">مواعيد القضايا</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2 svg-icon-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M20.0381 4V10C20.0381 10.6 19.6381 11 19.0381 11H17.0381C16.4381 11 16.0381 10.6 16.0381 10V4C16.0381 2.9 16.9381 2 18.0381 2C19.1381 2 20.0381 2.9 20.0381 4ZM9.73808 18.9C10.7381 18.5 11.2381 17.3 10.8381 16.3L5.83808 3.29999C5.43808 2.29999 4.23808 1.80001 3.23808 2.20001C2.23808 2.60001 1.73809 3.79999 2.13809 4.79999L7.13809 17.8C7.43809 18.6 8.23808 19.1 9.03808 19.1C9.23808 19 9.53808 19 9.73808 18.9ZM19.0381 18H17.0381V20H19.0381V18Z" fill="black"/>
                                    <path d="M18.0381 6H4.03809C2.93809 6 2.03809 5.1 2.03809 4C2.03809 2.9 2.93809 2 4.03809 2H18.0381C19.1381 2 20.0381 2.9 20.0381 4C20.0381 5.1 19.1381 6 18.0381 6ZM4.03809 3C3.43809 3 3.03809 3.4 3.03809 4C3.03809 4.6 3.43809 5 4.03809 5C4.63809 5 5.03809 4.6 5.03809 4C5.03809 3.4 4.63809 3 4.03809 3ZM18.0381 3C17.4381 3 17.0381 3.4 17.0381 4C17.0381 4.6 17.4381 5 18.0381 5C18.6381 5 19.0381 4.6 19.0381 4C19.0381 3.4 18.6381 3 18.0381 3ZM12.0381 17V22H6.03809V17C6.03809 15.3 7.33809 14 9.03809 14C10.7381 14 12.0381 15.3 12.0381 17ZM9.03809 15.5C8.23809 15.5 7.53809 16.2 7.53809 17C7.53809 17.8 8.23809 18.5 9.03809 18.5C9.83809 18.5 10.5381 17.8 10.5381 17C10.5381 16.2 9.83809 15.5 9.03809 15.5ZM15.0381 15H17.0381V13H16.0381V8L14.0381 10V14C14.0381 14.6 14.4381 15 15.0381 15ZM19.0381 15H21.0381C21.6381 15 22.0381 14.6 22.0381 14V10L20.0381 8V13H19.0381V15ZM21.0381 20H15.0381V22H21.0381V20Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">الصيانة</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">عرض المتواجدين أونلاين</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> تحديث ملفات النظام</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> النسخ الاحتياطي للقاعدة</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> تنفيذ استعلام MySQL</span>
                            </a>
                        </div>
                    </div>
                </div>
                            @endif

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
</div>
