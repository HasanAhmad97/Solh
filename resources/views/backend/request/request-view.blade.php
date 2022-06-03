@extends('backend.layouts.app')

@section('title', 'استعراض بيانات الطلب')



@section('content')
    <style>
        .color-accordion-block a.ui-state-active, .color-accordion-block a:focus, .color-accordion-block a:hover 
        {
        color: #fff;
        background: #4680ff;
        }
        .accordion-msg 
        {
        display: block;
        color: #222222;
        padding: 14px 20px;
        border-top: 1px solid #ddd;
        font-weight: 600;
        cursor: pointer;
        }
        .card .card-header h5 
        {
        margin-bottom: 0;
        color: #505458;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
        margin-right: 10px;
        line-height: 1.4;
        }
        .card .card-header
        {
        background-color: transparent;
        border-bottom: none;
        padding: 25px 20px;
        
        }
      .col-md-6,.col-md-12

      {
          padding-top:15px;
      }

    </style>
    <div class="card shadow-sm mb-4">
        <div class="card-header">
              <div class="card-header-left">
            <h5><i class="fa fa-eye">
    		</i> بيانات الطلب [{{$getRequest->reqid}}#] [ {{date("Y",$getRequest->dateadd)}}/{{$getRequest->auto_number}} ]</h5>
            </div>
            <div class="card-header-right" style="left: 10px !important;">
                <ul class="list-unstyled card-option" style="width: auto; height: auto">
                    <li class=""><i class="icofont icofont-maximize full-card"></i></li>
                    <li><i class="icofont icofont-minus minimize-card"></i></li>
                    <li><i class="icofont icofont-error close-card"></i></li>
                     
                </ul> 
            </div>
        </div>
        <div class="card-body py-3">
            @if($status == 'Waiting_Approve') 
            <form method="post" action="{{route('admin.request.approve')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="reqid" value="{{$getRequest->reqid}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                              <label for="">السنة</label>
                              <input type="text" value="{{date("Y",$getRequest->dateadd)}}" disabled="" style="opacity: 1 !important;" class="form-control" name="" placeholder="">
                              
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                              <label for="transaction_number">رقم المعاملة</label>
                              <input type="text" value="1000" class="form-control" name="transaction_number" placeholder="">
                              
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                              <label for="">تاريخ المعاملة</label>
                              <input type="text" value="{{date("d/m/Y",$getRequest->dateadd)}}" disabled="" style="opacity: 1 !important;" class="form-control" name="" placeholder="">
                              
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>مستوى الأهمية</label>
                            <select class="form-control" name="importance_level">
                                <option selected="" value="normal">عادي</option>
                                <option value="important">هام</option>
                                <option value="very_important">هام ومستعجل</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الجهة الوارد منها</label>
                            <select class="form-select" name="referal_id" tabindex="-1" aria-hidden="true">
                                                    <option selected="" value="1">محكمة الأحوال الشخصية بالمدينة - الدائرة الخامسة</option>
                                                    <option value="2">إمارة منطقة المدينة المنورة</option>
                                                    <option value="3">مكتب الضمان الاجتماعي</option>
                                                    <option value="4">ذاتية</option>
                                                    <option value="5">محكمة الأحوال الشخصية بالمدينة - الدائرة الرابعة</option>
                                                    <option value="6">محكمة الأحوال الشخصية بالمدينة - الدائرة الثالثة</option>
                                                    <option value="7">محكمة الأحوال الشخصية بالمدينة - الدائرة الثانية</option>
                                                    <option value="8">محكمة الأحوال الشخصية بالمدينة - الدائرة الأولى</option>
                                                    <option value="9">محكمة الأحوال الشخصية بالمدينة - الدائرة السادسة</option>
                                                    <option value="10">محكمة الأحوال الشخصية بالمدينة - الدائرة السابعة</option>
                                                    <option value="11">محكمة الأحوال الشخصية بالمدينة - الدائرة الثامنة</option>
                                                    <option value="12">محكمة الأحوال الشخصية بالمدينة - الدائرة التاسعة</option>
                                                    <option value="13">محكمة الأحوال الشخصية بالمدينة - الدائرة العاشرة</option>
                                                    <option value="14">محكمة الأحوال الشخصية بالمدينة - الدائرة الحادية عشرة</option>
                                                    <option value="15">المحكمة الجزائية</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="col-md-6"></div>
                    <div class="col-md-2 col-md-offset-5">
                        <br>
                        <input type="submit" value="اعتماد الطلب" class="btn btn-flat btn-warning btn-block">
        
        
                    </div>
                </div>
            </form>
            @endif
            <div class="accordion-block color-accordion-block " style="border-top: #cbcbcb dashed 1px; padding-top: 10px;">
                <div class="color-accordion tab-accordion ui-accordion ui-widget ui-helper-reset" role="tablist">

                    <!-- Req Info -->
                        <a class="accordion-msg b-none scale_active ui-accordion-header ui-corner-top ui-state-default ui-accordion-header-active ui-state-active ui-accordion-icons" role="tab" id="ui-id-7"
                           aria-controls="ui-id-8" aria-selected="true"
                           aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon zmdi zmdi-chevron-up"></span>استعراض بيانات الطلب</a>
                        <div class="accordion-desc ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content ui-accordion-content-active" style="" id="ui-id-8" aria-labelledby="ui-id-7" role="tabpanel"
                             aria-hidden="false">
                            <div class="row">
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="id_number">رقم الهوية</label>
                                          <input type="text" value="{{$getRequest->id_number}}" disabled style='opacity: 1 !important;' class="form-control" name="id_number" placeholder="">
                                          
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="name">الإسم</label>
                                          <input type="text" value="{{$getRequest->name}}" disabled style='opacity: 1 !important;' class="form-control" name="name" placeholder="">
                                          
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="phone_number">رقم الجوال</label>
                                          <input type="text" value="{{$getRequest->husband_phone_number}}" disabled style='opacity: 1 !important;' class="form-control" name="phone_number" placeholder="">
                                          
                                      </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="email">البريد الإلكتروني <span class='red'>لإرسال دعوة الإجتماع عن بعد</span></label>
                                          <input type="text" value="" disabled style='opacity: 1 !important;' class="form-control" name="email" placeholder="">
                                          
                                      </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>نوع الطلب</label>
                                        <select class="form-control" disabled style='opacity: 1 !important;'>
                                            <option
                                             value="solh">صلح</option>
                                            <option
                                             value="family_council" >استشارة
                                            عائلية</option>
                                            <option
                                             value="others">أخرى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"
                                 style="display: none" id="otherInput">
                                <div class="form-group">
                                          <label for="req_type_others">اكتب نوع الطلب</label>
                                          <input type="text" value="" disabled style='opacity: 1 !important;' class="form-control" name="req_type_others" placeholder="">
                                          
                                      </div>
                               </div>
                             

                                @if($getRequest->second_part_type == 'husband')
                                    @php                                    $second_part = 'الزوج';
                                    @endphp
                                @elseif($getRequest->second_part_type == 'wife')
                                    @php                                        $second_part = 'الزوجة';
                                    @endphp
                                @else
                                    @php     
                                   $second_part = $getRequest->second_part_type;
                                    @endphp
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الطرف الثاني</label>
                                          <input type="text" value="{{$second_part}}" disabled style='opacity: 1 !important;' class="form-control" >
                                       
                                    </div>
                                </div>
                                @php
                                 $filepath = public_path('uploads') . '/' . $getRequest->additional_file;
                                 $file = 'uploads' . '/' . $getRequest->additional_file;
                                @endphp
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> <h5>مرفقات الطلب:</h5> </label>
                                        @if($getRequest->additional_file)
                                        <a class="btn btn-outline-primary fa-4x	" href="{{URL::asset($file)}}"><i class="fas fa-file-pdf"></i>مرفق الطلب</a>
                                        @else
                                         <h5> لا توجد مرفقات</h5>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>نقاط الخلاف والصلح</label>
                                    <textarea class="form-control" rows="5" disabled style='opacity: 1 !important;'></textarea>
                                </div>
                            </div>
                         </div>
                        @if($getRequest->request_info)
                            <!-- Husband Info -->
                        <a class="accordion-msg bg-dark-primary b-none scale_active ui-accordion-header ui-corner-top ui-accordion-header-collapsed ui-corner-all ui-state-default ui-accordion-icons" role="tab" id="ui-id-9"
                           aria-controls="ui-id-10"
                           aria-selected="false" aria-expanded="false" tabindex="-1"><span class="ui-accordion-header-icon ui-icon zmdi zmdi-chevron-down"></span>بيانات الطرف الاول
                        </a>
                        <div class="accordion-desc ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content" style="display: none;" id="ui-id-10" aria-labelledby="ui-id-9" role="tabpanel" aria-hidden="true">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الاسم</label>
                                              <input type="text" value="{{$getRequest->request_info->husband_name}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                @php 
                                        $hus_nationality = \App\Models\NationalityList::select(array("title","title_female"))
                                         ->where('is_deleted' , 0)->where('closed' , 0)->where('nationality_id' , $getRequest->request_info->husband_nationality_id)
                                         ->first();
                                        $hus_study_level = \App\Models\StudyLevel::select("title")
                                         ->where('is_deleted' , 0)->where('closed' , 0)->where('study_id' , $getRequest->request_info->husband_study_levelid)
                                         ->first();
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الجنسية</label>
                                              <input type="text" value="{{($getRequest->second_part_type == 'husband') ? $hus_nationality->title_female : $hus_nationality->title}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">رقم الهوية</label>
                                              <input type="text" value="{{$getRequest->request_info->husband_national_id}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">رقم الهاتف</label>
                                              <input type="text" value="{{$getRequest->request_info->husband_phone}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">العمر</label>
                                              <input type="text" value="{{$getRequest->request_info->husband_age}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>حالة العمل</label>
                                        <select class="form-control" disabled style='opacity: 1 !important;'>
                                            <option
                                             {{($getRequest->request_info->husband_work_status == "WORKING") ? 'selected':'' }}  value="WORKING">{{($getRequest->second_part_type != 'wife') ? 'تعمل' : 'يعمل'}}</option>
                                            <option
                                             {{($getRequest->request_info->husband_work_status == "NOT_WORKING") ? 'selected':'' }} value="NOT_WORKING">{{($getRequest->second_part_type != 'wife') ? 'لا تعمل' : 'لا يعمل'}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الحالة الصحية</label>
                                              <input type="text" value="{{$getRequest->request_info->husband_medical_condition ?? 'غير محدد'}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">المستوى العلمي</label>
                                              <input type="text" value="{{$hus_study_level->title ?? 'غير محدد'}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wife Info -->
                        <a class="accordion-msg bg-darkest-primary b-none scale_active ui-accordion-header ui-corner-top ui-accordion-header-collapsed ui-corner-all ui-state-default ui-accordion-icons" role="tab"
                           id="ui-id-11" aria-controls="ui-id-12"
                           aria-selected="false" aria-expanded="false" tabindex="-1"><span class="ui-accordion-header-icon ui-icon zmdi zmdi-chevron-down"></span>بيانات الطرف الثاني
                        </a>
                        <div class="accordion-desc ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content" style="display: none;" id="ui-id-12" aria-labelledby="ui-id-11" role="tabpanel" aria-hidden="true">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الاسم</label>
                                              <input type="text" value="{{$getRequest->request_info->wife_name}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                 @php 
                                        $wife_nationality = \App\Models\NationalityList::select(array("title","title_female"))
                                         ->where('is_deleted' , 0)->where('closed' , 0)->where('nationality_id' , $getRequest->request_info->wife_nationality_id)
                                         ->first();
                                        $wife_study_level = \App\Models\StudyLevel::select("title")
                                         ->where('is_deleted' , 0)->where('closed' , 0)->where('study_id' , $getRequest->request_info->wife_study_levelid)
                                         ->first();
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الجنسية</label>
                                              <input type="text" value="{{($getRequest->second_part_type != 'husband') ? $wife_nationality->title_female : $wife_nationality->title}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">رقم الهوية</label>
                                              <input type="text" value="{{$getRequest->request_info->wife_national_id}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">رقم الهاتف</label>
                                              <input type="text" value="{{$getRequest->request_info->wife_phone}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">العمر</label>
                                              <input type="text" value="{{$getRequest->request_info->wife_age}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>حالة العمل</label>
                                        <select class="form-control" disabled style='opacity: 1 !important;'>
                                            <option
                                                {{($getRequest->request_info->wife_work_status == "WORKING") ? 'selected':'' }}  value="WORKING">{{($getRequest->second_part_type == 'wife') ? 'تعمل' : 'يعمل'}}</option>
                                            <option
                                                {{($getRequest->request_info->husband_work_status == "NOT_WORKING") ? 'selected':'' }} value="NOT_WORKING">{{($getRequest->second_part_type == 'wife') ? 'لا تعمل' : 'لا يعمل'}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الحالة الصحية</label>
                                              <input type="text" value="{{$getRequest->request_info->husband_medical_condition ?? 'غير محدد'}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">المستوى العلمي</label>
                                              <input type="text" value="{{$hus_study_level->title ?? 'غير محدد'}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Marriage Info -->
                        <a class="accordion-msg bg-darkest-primary b-none scale_active ui-accordion-header ui-corner-top ui-accordion-header-collapsed ui-corner-all ui-state-default ui-accordion-icons" role="tab"
                           id="ui-id-12" aria-controls="ui-id-13"
                           aria-selected="false" aria-expanded="false" tabindex="-1"><span class="ui-accordion-header-icon ui-icon zmdi zmdi-chevron-down"></span>بيانات الزواج
                        </a>
                        <div class="accordion-desc ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content" style="display: none;" id="ui-id-13" aria-labelledby="ui-id-12" role="tabpanel" aria-hidden="true">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">فترة الزواج بالسنين</label>
                                              <input type="number" value="{{$getRequest->request_info->marriage_duration}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">عدد الأطفال</label>
                                              <input type="number" value="{{$getRequest->request_info->children_no}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">الصداق (المهر)</label>
                                              <input type="number" value="{{$getRequest->request_info->marriage_money_amount}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">قيمة الذهب</label>
                                              <input type="number" value="{{$getRequest->request_info->marriage_gold_amount}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">مؤخر الصداق (المهر) ان وجد</label>
                                              <input type="number" value="{{$getRequest->request_info->marriage_late_money_amount}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                              <label for="">عدد مرات الطلاق السابقة</label>
                                              <input type="number" value="{{$getRequest->request_info->total_previous_divorce_count}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                                              
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
@section('script')
    <script>
       let accordiondesc = document.querySelectorAll('.accordion-desc');
       let accordionmsg = document.querySelectorAll('.accordion-msg');
        accordionmsg.forEach(element => {
            element.onclick = ()=>
            {
                accordionmsg.forEach(el => {
                    console.log(el)
                let hidden = document.getElementById(el.getAttribute('aria-controls'));
                hidden.style.display = "none";
                 el.classList.remove("ui-state-active");
                el.classList.add("ui-state-default");

                });
                let block = document.getElementById(element.getAttribute('aria-controls'));
                block.style.display = "block";
                 element.classList.add("ui-state-active");
                element.classList.remove("ui-state-default");
            }
        });

    </script>
@endsection    
@endsection
