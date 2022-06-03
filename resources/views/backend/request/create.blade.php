@extends('backend.layouts.app')

@section('title', 'أضف طلب جديد')

@section('request', 'active')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus fa-fw mx-2"></i>أضف طلب جديد</h3>
        </div>
        <div class="card-body">
            <form action="{{route('admin.request.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <h3 class="text-primary mb-5">بيانات المعاملة:</h3>
                <div class="row" id = "req_data">
                   
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="auto_number">الرقم التلقائي</label>
                            <input type="text" name="auto_number" id="auto_number" class="form-control" readonly disabled value="{{date('Y')}}/{{$lastCaseNumber[0]->maxNumber+1}}">
                            @error('auto_number')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="req_type">سبب القضية</label>
                            <div>
                                <select class="form-select form-select-solid" onchange="req_type_change()" name="req_type" id="req_type" data-kt-select2="true" data-placeholder="حدد خيار" data-allow-clear="true">
                                    @foreach(\App\Models\CasesReason::all() as $reason)
                                        <option value="{{$reason->reason_id}}" @if(old('req_type') == $reason->reason_id) selected @endif>{{$reason->title}}</option>
                                    @endforeach
                                    <option value="other" @if(old('req_type') == 'other') selected @endif>آخرى</option>
                                </select>
                            </div>
                            @error('req_type')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="referral_id">الجهة الوارد منها</label>
                            <div>
                                <select class="form-select form-select-solid" name="referral_id" id="referral_id" data-kt-select2="true" data-placeholder="حدد خيار" data-allow-clear="true" id = "referral_id" onchange = "get_refferal();">
                                    <option></option>
                                    @foreach(\App\Models\RequestReferral::all() as $referral)
                                        <option value="{{$referral->referid}}" @if(old('referral_id') == $referral->referid) selected @endif>{{$referral->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('referral_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">البريد الإلكتروني <small class="text-danger">لإرسال دعوة الإجتماع عن بعد</small></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                            @error('email')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                     <div class="col-md-6" id="transaction">
                        <div class="form-group mb-3">
                            <label class="form-label" for="transaction_number">رقم الوارد (المعاملة)</label>
                            <input type="text" name="transaction_number" required id="transaction_number" class="form-control" value="{{old('transaction_number')}}">
                            @error('transaction_number')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
                 <div class="separator my-10"></div>
                <h3 class="text-primary mb-5">بيانات الدعوى:</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3" id = "second_part" >
                            <label class="form-label" for="second_part_type">الطرف الثاني</label>
                            <div id = "who_second_part">
                                <select class="form-select form-select-solid" name="second_part_type" id="second_part_type" data-kt-select2="true" data-placeholder="حدد خيار" data-allow-clear="true">
                                    <option value="husband" @if(old('second_part_type') == 'husband') selected @endif>الزوج</option>
                                    <option value="wife" @if(old('second_part_type') == 'wife') selected @endif>الزوجة</option>
                                    <option value="none" @if(old('second_part_type') == 'none') selected @endif>بدون</option>
                                </select>
                            </div>
                            @error('second_part_type')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-12" style="display: none" id="req_type_others_none">
                        <div class="form-group mb-3">
                            <label class="form-label" for="req_type_others">اكتب نوع الطلب</label>
                            <input type="text" name="req_type_others" id="req_type_others" class="form-control" value="{{old('req_type_others')}}">
                            @error('req_type_others')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label class="form-label" for="attachments">اضف مرفقات للطلب <small>( اختياري )</small></label>
                            <input type="file" name="attachments" id="attachments" class="form-control">
                            <small>الملفات المسموح برفعها: jpg,jpeg,png,gif,pdf,docs</small>
                            @error('attachments')<small class="text-danger d-block">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label text-danger" for="request_description">تفاصيل إضافية <small>(اختياري)</small></label>
                            <textarea name="request_description" id="request_description" class="form-control" rows="5">{{old('request_description')}}</textarea>
                            @error('request_description')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
                <div class="separator my-10"></div>
                <h3 class="text-primary mb-5">بيانات الطرف الاول:</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="husband_name">الاسم</label>
                            <input type="text" name="husband_name" id="husband_name" class="form-control" value="{{old('husband_name')}}">
                            @error('husband_name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="husband_nationality_id">الجنسية</label>
                            <div>
                                <select class="form-select form-select-solid" name="husband_nationality_id" id="husband_nationality_id" data-kt-select2="true" data-placeholder="حدد خيار" data-allow-clear="true">
                                    @foreach(\App\Models\NationalityList::all() as $nationality)
                                        <option value="{{$nationality->nationality_id}}" @if(old('husband_nationality_id') == $nationality->nationality_id) selected @endif>{{$nationality->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('husband_nationality_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="husband_national_id">رقم الهوية</label>
                            <input type="text" name="husband_national_id" id="husband_national_id" class="form-control" value="{{old('husband_national_id')}}">
                            @error('husband_national_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="husband_phone">رقم الهاتف</label>
                            <input type="text" name="husband_phone" id="husband_phone" class="form-control" value="{{old('husband_phone')}}">
                            @error('husband_phone')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
                <div class="separator my-10"></div>
                <h3 class="text-primary mb-5">بيانات الطرف الثاني:</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="wife_name">الاسم</label>
                            <input type="text" name="wife_name" id="wife_name" class="form-control" value="{{old('wife_name')}}">
                            @error('wife_name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="wife_nationality_id">الجنسية</label>
                            <div>
                                <select class="form-select form-select-solid" name="wife_nationality_id" id="wife_nationality_id" data-kt-select2="true" data-placeholder="حدد خيار" data-allow-clear="true">
                                    @foreach(\App\Models\NationalityList::all() as $nationality)
                                        <option value="{{$nationality->nationality_id}}" @if(old('wife_nationality_id') == $nationality->nationality_id) selected @endif>{{$nationality->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('wife_nationality_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="wife_national_id">رقم الهوية</label>
                            <input type="text" name="wife_national_id" id="wife_national_id" class="form-control" value="{{old('wife_national_id')}}">
                            @error('wife_national_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="wife_phone">رقم الهاتف</label>
                            <input type="text" name="wife_phone" id="wife_phone" class="form-control" value="{{old('wife_phone')}}">
                            @error('wife_phone')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                </div>
        
                <div>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let transaction = document.querySelector("#transaction");
        function req_type_change(el) {
            if ($(el).val() == 'other'){
                $('#req_type_others_none').fadeIn();
            }else{
                $('#req_type_others_none').fadeOut();
            }
        }
        function get_refferal()
        {
            let req_data = document.querySelector("#req_data");
            let referral = document.querySelector("#referral_id");
            let req_type = document.querySelector("#req_type");
            let who_second_part = document.querySelector("#who_second_part");
            let _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
                    url: 'http://solh.tawafoq.org.sa/getreferral',
                    type:"POST",
                    data:{
                      referral: referral.value,
                      req_type : req_type.value,
                      _token: _token
                    },
                    success:function(data)
                    {
                      if(data) {
                        $('.success').text(data.success);
                        //  $('#referral_id').find('option').remove();
                            if( data['referral']  == 4)
                            {
                                transaction.remove();
                            }
                            else
                            {
                                req_data.appendChild(transaction);
                            }
                      }
                    },
                    error: function(error) {
                     console.log(error);
                    }
                });
                
        }
        function req_type_change()
        {
            let referral = document.querySelector("#referral_id");
            let transaction = document.querySelector("#transaction");
            let req_type = document.querySelector("#req_type");
            let who_second_part = document.querySelector("#who_second_part");
            let _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
                    url: 'http://solh.tawafoq.org.sa/getreferral',
                    type:"POST",
                    data:{
                      referral: referral.value,
                      req_type : req_type.value,
                      _token: _token
                    },
                    success:function(data)
                    {
                      if(data) 
                      {
                        $('.success').text(data.success);
                        //  $('#referral_id').find('option').remove();
                             if(data['req_type']  == 6)
                            {
                                who_second_part.style.display = "none";
                                const divone = document.createElement("div");
                                divone.setAttribute("id", 'who_second_part_2');
                                const input = document.createElement("input");
                                input.setAttribute("class", 'form-control');
                                input.setAttribute("name", 'second_part_type');
                                input.setAttribute("placeholder", 'أدخل الطرف الثاني');
                                let second_part = document.querySelector("#second_part");

                                divone.appendChild(input);
                                second_part.appendChild(input);
                            }
                            else
                            {
                               $('#second_part').find('input').remove();
                               who_second_part.style.display = "block";
                            
                            }
                      }
                    },
                    error: function(error) {
                     console.log(error);
                    }
                });
                
        }
    </script>
@endsection
