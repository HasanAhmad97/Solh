<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\RequestMeetingTime;
use \App\Models\RequestsInfo;
use \App\Models\RequestSession;
use \App\Models\CouncilsMeetingLocation;
use \App\Models\User;
use \App\Models\CasesCloseStatus;
use \App\Models\RequestReferral;
use DB;
use Auth;

class RequestSessionController extends Controller
{
    public function index(){
        $requests = \App\Models\Request::where('is_deleted', 0)->whereIn('status', ['APPROVED','RESCHEDULED'])->orderBy('reqid', 'desc')->paginate(20);
        return view('backend.session.index', compact('requests'));
    }
    public function session_approve($id){
    $requests = \App\Models\Request::where('reqid', $id)->first();
    $mos = \App\Models\User::where('usergroup', '2')->get();
    $close = \App\Models\CasesCloseStatus::select('*')->get();
    $referral = \App\Models\RequestReferral::select('*')->get();
    return view('backend.session.session-approve', compact('requests','mos','close','referral'));
    }
    public function session_approve_post(Request $request){
        $errorList["moslh_userid"] = array();
        if (intval($request->moslh_userid) == 0)
        {
        echo "فضلاً تحقق من اختيارك لمصلح الجلسة";
        $errorList["moslh_userid"] = "فضلاً تحقق من اختيارك لمصلح الجلسة";
        }
        
        if (intval($request->council_id) == 0)
        {
        echo "فضلاً تحقق من اختيارك لمجلس الصلح";
        $errorList["moslh_userid"] = "فضلاً تحقق من اختيارك لمجلس الصلح";
        }

         $SessionAvalibale = RequestMeetingTime::select(["title","session_time_start","session_time_end"])->where('timeid',$request->timeid)->first();
        if ($SessionAvalibale->count() == 0) {
            echo "موعد الجلسة المحدد غير متوفر في الوقت الحالي";
            $errorList["timeid"] = "موعد الجلسة المحدد غير متوفر في الوقت الحالي";
        }
        $timeSlotInfo = $SessionAvalibale;
        $sessionDateTimeStamp = _timestamp($request->session_date . " " . $timeSlotInfo->session_time_start, "Y-m-d H:i A");
        $sessionEndDateTimeStamp = _timestamp($request->session_date . " " . $timeSlotInfo->session_time_end, "Y-m-d H:i A");
        $session_time_start = _timestamp($timeSlotInfo->session_time_start, "H:i A");
        $session_time_start = date('h:i A', strtotime($session_time_start));
        $meetingAvalibale = CouncilsMeetingLocation::select(["room_code","level_code"])->where('council_id',$request->council_id)->first();
        if ($meetingAvalibale->count() == 0) {
        echo "مجلس القضية المحدد غير متوفر في الوقت الحالي";
        $errorList["timeid"] = "مجلس القضية المحدد غير متوفر في الوقت الحالي";
    }
        $meetingLocationInfo = $meetingAvalibale;
        $moslhAvalibale = User::select(["zoom_code","zoom_access_token","userid","name","phone"])->where('closed','0')->where('userid',$request->moslh_userid)->first();
        if ($moslhAvalibale->count() == 0) {
            echo "لم يتم العثور على المصلح المطلوب او ان حسابه مغلق بواسطة الادارة";
            $errorList["moslh_userid"] = "لم يتم العثور على المصلح المطلوب او ان حسابه مغلق بواسطة الادارة";
        }
        $moslhInfo = $moslhAvalibale;
        if ($moslhInfo["zoom_access_token"] == "" && $request->meeting_location == "zoom_meeting") {
            echo "يبدو ان المصلح المطلوب لم يقم بربط حساب Zoom الخاص به مع المنصة, فضلاً تواصل مع المصلح لتحديث البيانات الخاصة به عبر لوحة التحكم الخاصة به";
            $errorList["moslh_userid"] = "يبدو ان المصلح المطلوب لم يقم بربط حساب Zoom الخاص به مع المنصة, فضلاً تواصل مع المصلح لتحديث البيانات الخاصة به عبر لوحة التحكم الخاصة به";
        }
        
         $sessionExist = RequestSession::select(["sessionid"])->where('council_id',$request->council_id)->where('userid',$request->moslh_userid)
         ->where('reqid',$request->reqid)->where('timeid',$request->timeid)->where('moslh_userid',$request->moslh_userid)->where('session_date',$sessionDateTimeStamp)->first();
         if($sessionExist)
         {
              if ($sessionExist->count() != 0) {
                 echo "يبدو أنك قمت بالفعل بتعيين هذه الجلسة من قبل";
            }
         }
       
        $phones = RequestsInfo::select(["husband_phone","wife_phone"])->where('reqid',$request->reqid)->first();
        if ($phones->count() != 0)
        {
            $husbandWifePhone = $phones;
        }
        else
        {
            $husbandWifePhone = ["",""];
        }
        
            $requests = \App\Models\Request::where('reqid', $request->reqid)->update(['status' => 'SCHEDULED','date_updated' => time(),'edited_userid' => Auth::id()]);
            $requestSessions = RequestSession::insert(['zoom_link' => ' ','zoom_password' => ' ','council_location' => $request->meeting_location,"council_id" => $request->council_id,
            "reqid" => $request->reqid,"timeid" => $request->timeid,"moslh_userid" => $request->moslh_userid,'session_date' => $sessionDateTimeStamp,'session_date_end' => $sessionEndDateTimeStamp,
            "dateadd" => time(),"added_userid" => Auth::id()]);



    //         if ($request->meeting_location == 'zoom_meeting') {
    //             echo "سيتم لاحقا تفعيل هذه الميزة ";
    //             // $smsMessage = " نشكر تواصلكم مع جمعية توافق ونفيدكم بأنه تم تحديد جلسة لكم مع أحد المصلحين {SOCIAL_WORKER_NAME} وذلك في تاريخ: {SESSION_DATE} الساعة: {SESSION_TIME} ولمدة: 45 دقيقة عبر الرابط: {CONFERENCE_URL}";
    //             // $smsMoslhMessage = " عزيزنا {SOCIAL_WORKER_NAME} ,نفيدكم بأنه تم تحديد جلسة صلح لكم في توافق وذلك في تاريخ: {SESSION_DATE} الساعة: {SESSION_TIME} ولمدة: 45 دقيقة عبر الرابط: {CONFERENCE_URL}";
    //         } else {
    //                 $smsMessage = "موعدكم بجمعية توافق بتاريخ: {SESSION_DATE} الساعة: {SESSION_TIME} في: {PERIOD_DESC} للاستفسار 0148593637
    //                 يمكنكم التعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.be/pldpY94Bxng ";
    //                 $smsMoslhMessage = "عزيزنا المصلح {SOCIAL_WORKER_NAME}, موعدكم بجمعية توافق بتاريخ: {SESSION_DATE} الساعة: {SESSION_TIME} في: {PERIOD_DESC} للاستفسار 0148593637
    //                 يمكنكم التعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.be/pldpY94Bxng ";
    //         }


    // $smsMessage = str_replace(
    //     array("{SOCIAL_WORKER_NAME}", "{SESSION_DATE}", "{SESSION_TIME}", "{CONFERENCE_URL}", "{PERIOD_DESC}"),
    //     array($moslhInfo->name, $request->session_date, $timeSlotInfo->session_time_start, "dd", "الغرفة [{$meetingLocationInfo->room_code}] الدور [{$meetingLocationInfo->level_code}]"),
    //     $smsMessage
    // );
    // $smsMoslhMessage = str_replace(
    //     array("{SOCIAL_WORKER_NAME}", "{SESSION_DATE}", "{SESSION_TIME}", "{CONFERENCE_URL}", "{PERIOD_DESC}"),
    //     array($moslhInfo->name, $request->session_date, $timeSlotInfo->session_time_start, "dd", "الغرفة [{$meetingLocationInfo->room_code}] الدور [{$meetingLocationInfo->level_code}]"),
    //     $smsMoslhMessage
    // );
   if ($request->meeting_location == 'zoom_meeting')
   {
      echo "سيتم لاحقا تفعيل هذه اجتماعات zoom ";

   }
     sendSMS(
         fixPhoneNumber($husbandWifePhone->husband_phone),
         "موعدكم بجمعية توافق بتاريخ: $request->session_date ، الساعة: $session_time_start ، في الغرفة: $meetingLocationInfo->room_code ، الدور: $meetingLocationInfo->level_code ، للاستفسار:0148593637،    للتعرف على آلية الصلح الأسري بجمعية توافق عبر يوتيوب: : https://youtu.bepldpY94Bxng ."
         );
           sendSMS(
         fixPhoneNumber($husbandWifePhone->wife_phone),
         "موعدكم بجمعية توافق بتاريخ: $request->session_date ، الساعة: $session_time_start ، في الغرفة: $meetingLocationInfo->room_code ، الدور: $meetingLocationInfo->level_code ، للاستفسار:0148593637،  للتعرف على آلية الصلح الأسري بجمعية توافق عبر يوتيوب: : https://youtu.bepldpY94Bxng ."
         );
           sendSMS(
          $moslhInfo->phone,
         "عزيزنا المصلح موعدكم بجمعية توافق بتاريخ: $request->session_date، الساعة: $session_time_start ، في الغرفة: $meetingLocationInfo->room_code ، الدور: $meetingLocationInfo->level_code ، للاستفسار:0148593637، للتعرف على آلية الصلح الأسري بجمعية توافق عبر يوتيوب: : https://youtu.bepldpY94Bxng ."
         );
    //  sendSMS(
    //     fixPhoneNumber($husbandWifePhone->husband_phone),
    //       "موعدكم بجمعية توافق بتاريخ:  $request->session_date الساعة: $timeSlotInfo->session_time_start في: الغرفة $meetingLocationInfo->room_code الدور $meetingLocationInfo->level_code  للاستفسار 0148593637 يمكنكم التعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.bepldpY94Bxng");
    //  sendSMS(
    //     fixPhoneNumber($husbandWifePhone->wife_phone),
    //           "موعدكم بجمعية توافق بتاريخ:  $request->session_date الساعة: $timeSlotInfo->session_time_start في: الغرفة $meetingLocationInfo->room_code الدور $meetingLocationInfo->level_code  للاستفسار 0148593637 يمكنكم التعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.bepldpY94Bxng");
        
    //      sendSMS(
    //     $moslhInfo->phone,
    //           "عزيزنا المصلح موعدكم بجمعية توافق بتاريخ:  $request->session_date الساعة: $timeSlotInfo->session_time_start في: الغرفة $meetingLocationInfo->room_code الدور $meetingLocationInfo->level_code  للاستفسار 0148593637
    //                             يمكنكم التعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.bepldpY94Bxng");

   
    
    return redirect()->route('admin.request.session')->with(['status' => 'success', 'msg' => 'تم انشاء الجلسة بنجاح وتنبيه الاطراف المشاركة']);

    }
      public function management(){
          $meetings = DB::select(DB::raw("select users.name as moslh_name,moslh_session_userid,moslh_extra_userid,moslh_extra_second_userid, sessionid,husband_present_date,wife_present_date, moslh_present_date, husband_name,wife_name,session_date_end, session_start_time,session_end_time,session_date , councils_meeting_location.council_id,room_code,level_code,meeting_location,councils_meeting_location.reqid from councils_meeting_location LEFT JOIN request_sessions on request_sessions.is_deleted = 0 and request_sessions.council_id = councils_meeting_location.council_id and request_sessions.session_date < " . time() . " and request_sessions.session_date_end > " . time() . " Left JOIN users on request_sessions.moslh_userid = users.userid lEFT join requests_info ON requests_info.reqid = request_sessions.reqid order by order_level asc"));
        return view('backend.session.management', compact('meetings'));
    }
    public function get_time(Request $request){
        $requests = \App\Models\Request::where('reqid', $request->id)->first();
        $sessionDateTimeStamp = _timestamp($request->session_date . " " . date("H:i"), "Y-m-d H:i");
        $sessionDateFormat = timer($sessionDateTimeStamp, "Y-m-d");
        $response["time_slots"] = array();
        $response["meeting_location"] = array();
        $todayDate = date("Y-m-d");
        $Details = DB::select(DB::raw("SELECT request_sessions.sessionid, request_meeting_time.title, request_meeting_time.timeid,session_time_start ,session_time_end, request_meeting_time.order_level from 
            councils_meeting_location left join request_meeting_time on request_meeting_time.timeid = request_meeting_time.timeid and request_meeting_time.closed = 0  
            left join request_sessions on request_sessions.council_id = councils_meeting_location.council_id and FROM_UNIXTIME(request_sessions.session_date,'%Y-%m-%d') = $request->session_date    
        where request_sessions.sessionid is null group by request_meeting_time.timeid
        order by request_meeting_time.order_level,request_meeting_time.timeid asc"));
        if(!$Details[0]->timeid)
        {
            echo "لم يتم العثور على مواعيد متوفرة للتاريخ المحدد";
        }
        if ($request->meeting_location == "inside_building")
            $whereLocation = "('inside_building','booth' )";
        else
            $whereLocation = "('zoom_meeting','booth' )";
            // $whereLocation = "('inside_building','booth' )";
        foreach($Details as $v)
        {
             $meeting = DB::select(DB::raw("SELECT councils_meeting_location.room_code, councils_meeting_location.council_id,level_code    
            from councils_meeting_location left join request_sessions on FROM_UNIXTIME(request_sessions.session_date,'%Y-%m-%d') = $sessionDateFormat and 
            councils_meeting_location.council_id = request_sessions.council_id and request_sessions.timeid = $v->timeid 
            where councils_meeting_location.meeting_location in $whereLocation and request_sessions.council_id is null and councils_meeting_location.closed = 0 order by councils_meeting_location.order_level,councils_meeting_location.council_id asc
                "));
             if(count($meeting) == 0){
                 continue;
             }
             else
             {
                $timeSlotTimeStamp = "$todayDate " . $v->session_time_start;
                $timeSlotTimeStamp = _timestamp($timeSlotTimeStamp, "Y-m-d H:i");
                if ($timeSlotTimeStamp > $sessionDateTimeStamp || $request->session_date != $todayDate)
                {
                   $response["time_slots"][] = $v;
                }
             }
             
        }
         $currentTimeSlot = $Details[0]->timeid;

        $Councel = DB::select(DB::raw("SELECT councils_meeting_location.room_code, councils_meeting_location.council_id,level_code    
        from councils_meeting_location left join request_sessions on FROM_UNIXTIME(request_sessions.session_date,'%Y-%m-%d') = '$sessionDateFormat' and 
        councils_meeting_location.council_id = request_sessions.council_id and request_sessions.timeid = $currentTimeSlot 
        where councils_meeting_location.meeting_location in $whereLocation and request_sessions.council_id is null and councils_meeting_location.closed = 0 
        order by councils_meeting_location.order_level,councils_meeting_location.council_id asc"));
         if (count($Councel) == 0)
         {
             echo "لم يتم العثور على مواعيد جلسات صلح متوفرة للتاريخ والوقت المحدد";
         }
        else {
        foreach($Councel as $c)
        {
            $response["meeting_location"][] = $c;
        }
        }
        return $response;


    }
    public function filter(Request $request){
        $requests = \App\Models\Request::where('is_deleted', 0)->whereIn('status', ['APPROVED','RESCHEDULED'])->orderBy('reqid', 'desc')->paginate(20);
         if(!$request->input('name'))
        {
            $name = '';
        }
        else
        {
            $name =  $request->input('name');
        }
        if(!$request->input('phone'))
        {
            $phone = '';
        }
        else
        {
            $phone = $request->input('phone');
        }
        if(!$request->input('id'))
        {
            $id = '';
        }
        else
        {
            $id = $request->input('id');
        }
           foreach($requests as $key => $req)
         {
             if($req->request_info->husband_name == $name || 
             $req->request_info->wife_name == $name || 
             $req->request_info->husband_phone == $phone || 
             $req->request_info->wife_phone == $phone ||
             $req->request_info->husband_nationality_id == $id || 
             $req->request_info->wife_nationality_id == $id)
             {
                 return view('backend.session.index-filter', compact('req'));
             }
         }
    }
}
