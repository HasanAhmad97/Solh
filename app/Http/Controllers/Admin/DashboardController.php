<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RequestSession;
use App\Models\RequestsInfo;
use App\Models\User;
use App\Models\NationalityList;
use App\Models\StudyLevel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $meetings = DB::select(DB::raw("select users.name as moslh_name,moslh_session_userid,moslh_extra_userid,moslh_extra_second_userid, sessionid,husband_present_date,wife_present_date, moslh_present_date, husband_name,wife_name,session_date_end, session_start_time,session_end_time,session_date , councils_meeting_location.council_id,room_code,level_code,meeting_location,councils_meeting_location.reqid from councils_meeting_location LEFT JOIN request_sessions on request_sessions.is_deleted = 0 and request_sessions.council_id = councils_meeting_location.council_id and request_sessions.session_date < " . time() . " and request_sessions.session_date_end > " . time() . " Left JOIN users on request_sessions.moslh_userid = users.userid lEFT join requests_info ON requests_info.reqid = request_sessions.reqid order by order_level asc"));
        return view('backend.index', compact('meetings'));
    }
   
    public function sms($id,$reqtype,$phone){
         $getRequest = \App\Models\Request::select(array("req_uuid","husband_n_sms","wife_n_sms"))
                    ->whereIn('status', ['WAITING', 'WAITING_INFO_COMPLATE', 'INFO_COMPLATE_NOTIFY'])->where('reqid',$id)
                    ->first();
        $h_n_sms = $getRequest->husband_n_sms;
        $w_n_sms = $getRequest->wife_n_sms;
        if($reqtype == 'first')
        {
            
            sendSMS(
            fixPhoneNumber($phone),
            "نود تذكيرك بتحديث البيانات الخاصة بك عبر الرابط: "  . "http://solh.tawafoq.org.sa/complete" . "/c-h-$getRequest->req_uuid"
            );
            $h_n_sms = intval($h_n_sms)+1;
            $requestupdate = \App\Models\Request::where('reqid',$id)->update(['husband_n_sms' => $h_n_sms]);
        }
        else
        {
            sendSMS(
            fixPhoneNumber($phone),
            "نود تذكيرك بتحديث البيانات الخاصة بك عبر الرابط: "  . "http://solh.tawafoq.org.sa/complete" . "/c-w-$getRequest->req_uuid"
            );
            $w_n_sms = intval($w_n_sms)+1;
            $requestupdate = \App\Models\Request::where('reqid',$id)->update(['wife_n_sms' => $w_n_sms]);
        }
        return redirect()->route('admin.request.waiting')->with(['status' => 'success', 'msg' => 'تم رسال الرسالة بنجاح ']);
    }
}
