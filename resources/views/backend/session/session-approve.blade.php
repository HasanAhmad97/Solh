@extends('backend.layouts.app')

@section('title', 'تحديد جلسة للقضية')
 
@section('archive_request', 'active')
@section('content')
 <style>
     .row
     {
         margin-bottom: 10px;
     }
 </style>
  <div class="card shadow-sm mb-4">
        <div class="card-header">

            <div class="card-header">
                <div class="card-header-left">
                    <h5><i class="fa fa-plus">
        		</i> اعتماد جلسة صلح جديدة</h5>
                </div>
                <div class="card-header-right" style="left: 10px !important;">
                    <ul class="list-unstyled card-option" style="width: auto; height: auto">
                        <li class=""><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                         
                    </ul> 
                </div>
            </div>
        </div>

        <div class="card-body py-3">
                    
            <form method="post" enctype="multipart/form-data" action="{{route('admin.session.approve.post')}}">
                @csrf
                 <meta name="csrf-token" content="{{ Session::token() }}"> 
                <input type="hidden" name="reqid" value="{{$requests->reqid}}"/>
                <div class="row">
    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">الرقم الآلي للمعاملة</label>
                          <input type="text" value="{{$requests->reqid}}" disabled style='opacity: 1 !important;' class="form-control" name="" placeholder="">
                          
                      </div>
                    </div>
    
                    <div class="col-sm-6 form-group">
                        <label for="session_date">تاريخ الجلسة</label>
                        <input id="session_date" onchange="getAvailableMeetingTimeAndLocations(true);" type="date" pattern="\d{4}-\d{2}-\d{2}"
                               value=""
                               class="form-control"
                               name="session_date" placeholder="">
                        <small class="text-warning">سيتم تحديد غرفة ومواعيد الجلسة بصورة تلقائية بعد تغيير التاريخ</small>
                    </div>
    
    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>المصلح</label>
                            <select class="form-control select2-rtl" name="moslh_userid" id="moslh_userid" onchange="getAvailableMeetingTimeAndLocations(true);">
                                 <option>-- اختر --</option>
                                 @foreach($mos as $m)
                                <option value="{{$m->userid}}">{{$m->name}}</option>
                                @endforeach
                                </select>
                        </div>
                    </div>
    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>بيئة الانعقاد</label>
                            <select class="form-control" name="meeting_location" id="meeting_location" onchange="getAvailableMeetingTimeAndLocations(true);">
                                <option
                                 value="inside_building">داخل
                                الجمعية</option>
                                <option
                                 value="zoom_meeting">من على
                                بعد</option>
    
                            </select>
    
                            <small class="text-warning">سيتم ارسال رابط دعوة اجتماع Zoom في حالة الانعقاد خارج الجمعية</small>
    
                        </div>
                    </div>
    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>مصلح انتظار 1</label>
                            <select class="form-control select2-rtl" name="moslh_extra_userid">
                                <option>-- اختر --</option>
                                 @foreach($mos as $m)
                                     <option value="{{$m->userid}}">{{$m->name}}</option>
                                @endforeach
                             </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>مصلح انتظار 2</label>
                             <select class="form-control select2-rtl" name="moslh_extra_userid">
                                <option>-- اختر --</option>
                                @foreach($mos as $m)
                                     <option value="{{$m->userid}}">{{$m->name}}</option>
                                @endforeach                             
                                </select>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <hr/>
                    </div>
    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>موعد الجلسة</label>
                            <select class="form-control" name="timeid" id="timeid" onchange="getAvailableMeetingTimeAndLocations(false)">
                                <option value="">فضلاً قم بتغيير تاريخ الجلسة أولاً</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>مجلس الصلح</label>
                            <select class="form-control" name="council_id" id="council_id">
                                <option value="">فضلاً قم بتغيير موعد الجلسة أولاً</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="clearfix"></div>
              </div>
              <div class="row">
                            
                            <div class="col-md-2">
                                <input type = 'submit' value = "اعتماد الجلسة" class = "btn btn-flat btn-warning btn-block">
                                
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin.request.view',[$requests->reqid,'Waiting'])}}" class="btn btn-primary"> عرض بيانات الطلب </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('admin.request.edit',[$requests->reqid])}}" class="btn btn-info"> تعديل بيانات الطلب </a>
                            </div>

              </div>
            </form>
               
                <div class="clearfix"></div>
                <br/>
        </div>
    </div>
    

  <div class="card shadow-sm mb-4">
        <div class="card-header">
            <div class="card-header-left">
                <h5><i class="fa fa-info">
    		</i> بيانات الدعوى والنتيجة</h5>
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
            <form method="post" enctype="multipart/form-data" action="{{route('admin.request.close')}}">
                @csrf
                <input type="hidden" name="reqid" value="{{$requests->reqid}}"/>
                <div class="row">
                    <div class="col-md-5 form-group">
                      
                        <label>حالة اغلاق القضية</label>
                        <select onchange="getcaseclose();" name="close_status_id"  id = 'close_status_id' class="form-select">
                            <option>-- اختر --</option>           
                            @foreach($close as $c)
                                     <option value="{{$c->close_status_id}}" {{($requests->close_status_id == $c->close_status_id) ? 'selected':'';}} >{{$c->title}}</option>
                            @endforeach    
                        </select>
        
                                        <small>يمكنك اضافة حالات جديدة عبر
                            <a href="http://solh-new.tawafoq.org.sa/cases_close_status.html">الضغط هنا</a></small>
                    </div>
                    <div class="col-md-5 form-group">
                        <label>الجهة الصادر إليها</label>
                        <select class="form-select select2-rtl" name="out_referal_id">
                             @foreach($referral as $r)
                                     <option value="{{$r->referid}}" {{($requests->referal_id == $r->referid) ? 'selected':'';}}>{{$r->title}}</option>
                             @endforeach  
                                    
                        </select>
                    </div>
                    <div class="col-md-5 form-group">
                        @php $finish_req_session = DB::Table('mos_reward')->where('reqid',$requests->reqid)->first();
                        if($finish_req_session)
                        {
                         $mos_id = $finish_req_session->mosid;
                         $amount = $finish_req_session->amount;
                         $sec_mos_id = $finish_req_session->sec_mosid;
                         $sec_amount = $finish_req_session->sec_amount;
                        }
                        else
                        {
                         $mos_id = ' ';
                          $amount = ' ';
                         $sec_mos_id = ' ';
                          $sec_amount = ' ';
                        }
                        @endphp
                        <label>المصلح الأساسي</label>
                        <select class="form-select select2-rtl" name="primary_mos">
                            <option>-- اختر --</option>
                            @foreach($mos as $m)
                            <option value="{{$m->userid}}" {{($mos_id  == $m->userid) ? 'selected':'';}}>{{$m->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-5 form-group">
                        <label>مقدار المكافأة</label>
                        <input type="text" style='opacity: 1 !important;' class="form-control" id = 'close_status_reward' name="primary_mos_reward" value ="{{ $amount}}" placeholder="">

                    </div>
                    <div class="col-md-5 form-group">
                        <label>المصلح الثانوي (إن وجد)</label>
                        <select class="form-select select2-rtl" name="sec_mos">
                             <option>-- اختر --</option>
                              @foreach($mos as $m)
                                     <option value="{{$m->userid}}" {{($sec_mos_id  == $m->userid) ? 'selected':'';}}>{{$m->name}}</option>
                                @endforeach
                        </select>

                    </div>
                    <div class="col-md-5 form-group">
                        <label>مقدار المكافأة</label>
                        <input type="text" style='opacity: 1 !important;' class="form-control" id='close_status_secreward' name="sec_mos_reward"  value ="{{ $sec_amount}}" placeholder="">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>ملف المعاملة</label>
                                        <span class="file-input btn btn-block btn-default btn-file">اختيار ملف المعاملة<input type="file" accept="application/pdf" name="req_archive_file"></span>
                    </div>
                    <div class="col-md-12 form-group">
                        <label> ملاحظات</label>
                        <textarea placeholder="اكتب ملاحظاتك هنا للأرشفة" name="admin_notes" class="form-control"
                                  rows="4">
                        </textarea>
                    </div>
                </div>
                 <div class="row">
                        
                    <div class="col-md-4 col-md-offset-4">
                        <input type="submit" class="btn btn-block btn-warning shiny" value="حفظ التعديلات"/>
                     </div>
                </div>
            </form>
        </div>
    </div>

<script>
    function getcaseclose()
    { 
        let close_status_id = document.querySelector("#close_status_id");
        let reward = document.querySelector("#close_status_reward");
        let secreward = document.querySelector("#close_status_secreward");
        let _token   = $('meta[name="csrf-token"]').attr('content');

       $.ajax({
        url: 'http://solh.tawafoq.org.sa/settings/cases-close-status/getreward',
        type:"POST",
        data:{
          close_status_id:close_status_id.value,
          _token: _token
        },
        success:function(data){
          if(data) {
              console.log(data.reward_amount)
              reward.value = data.reward_amount; 
          }
        },
        error: function(error) {
         console.log(error);
        }
       }); 
    }
    function getAvailableMeetingTimeAndLocations(refreshTimeSlots) {
        let session_date = document.querySelector("#session_date");
        let timeid = document.querySelector("#timeid");
        let council_id = document.querySelector("#council_id");
        let meeting_location = document.querySelector("#meeting_location");
        let _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
        url: 'http://solh.tawafoq.org.sa/gettime',
        type:"POST",
        data:{
          id:{{$requests->reqid}},
          session_date: session_date.value,
          timeid: timeid.value,
          council_id: council_id.value,
         meeting_location: meeting_location.value,
          _token: _token
        },
        success:function(data){
          console.log(data);
          if(data) {
            $('.success').text(data.success);
             $('#council_id').find('option').remove();

                if (refreshTimeSlots) {
                    $('#timeid').find('option').remove();

                    if (data["time_slots"].length > 0)
                        $.each(data["time_slots"], function (i, p) {
                            $('#timeid').append($('<option></option>').val(p.timeid).html(p.title + " [ " + p.session_time_start + " - " + p.session_time_end + " ]"));
                        });
                    else
                        $('#timeid').append($('<option></option>').val("").html("لم يتم العثور على مواعيد متوفرة للتاريخ المحدد"));
                    getAvailableMeetingTimeAndLocations(false);
                } else {

                    if (data["meeting_location"].length > 0)
                        $.each(data["meeting_location"], function (i, p) {
                            $('#council_id').append($('<option></option>').val(p.council_id).html("الغرفة [ " + p.room_code + " ] بالدور [ " + p.level_code + " ]"));
                        });
                    else
                        $('#council_id').append($('<option></option>').val("").html("لم يتم العثور على جلسات صلح متوفرة للتاريخ والوقت المحدد"));
                }
            // $("#ajaxform")[0].reset();
          }
        },
        error: function(error) {
         console.log(error);
        }
       });
    }
</script>
@endsection
