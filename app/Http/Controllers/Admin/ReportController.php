<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function mslh(Request $request){
        $andSQL = "";
        $start = '';
        $end = '';

        $users = User::where('usergroup', 2)->orderBy('userid', 'desc');

        if ($request->has('start') && $request->input('start') != '' && $request->input('start') != null) {
            $andSQL .= " and request_sessions.session_date > " . _timestamp($request->input('start') . " 01:00", 'Y-m-d H:i');
            $start = $request->input('start');
        }
        if ($request->has('end') && $request->input('end') != '' && $request->input('end') != null) {
            $andSQL .= " and request_sessions.session_date < " . _timestamp($request->input('end') . " 23:59", 'Y-m-d H:i');
            $end = $request->input('end');
        }
        if ($request->has('period') && $request->input('period') == 'today'){
            $andSQL = "and FROM_UNIXTIME(request_sessions.session_date,'%Y-%m-%d') = CURDATE()";
        }
        if ($request->has('period') && $request->input('period') == 'yesterday'){
            $andSQL = "and request_sessions.session_date >= UNIX_TIMESTAMP(CAST(NOW() - INTERVAL 1 DAY AS DATE)) AND request_sessions.session_date <= UNIX_TIMESTAMP(CAST(NOW() AS DATE))";
        }
        $users = $users->get();
        return view('backend.reports.mslh', compact('users', 'start', 'end'));
    }

    public function incoming(){
        $users = DB::select(DB::raw("select request_referral.title, request_referral.referid as RefID, FROM_UNIXTIME(requests.dateadd,'%Y/%m') as RequestDate, (SELECT count(second_part_type) FROM requests where is_deleted = 0 and requests.referal_id = RefID and FROM_UNIXTIME(requests.dateadd,'%Y/%m') = RequestDate and second_part_type = 'husband') AS totalWifeRequests, (SELECT count(second_part_type) FROM requests where is_deleted = 0 and requests.referal_id = RefID and FROM_UNIXTIME(requests.dateadd,'%Y/%m') = RequestDate and second_part_type = 'wife') AS totalHusbandRequests from requests,request_referral where requests.referal_id = request_referral.referid group by RequestDate,RefID order by RequestDate desc"));
        $dates = [];
        foreach ($users as $key => $user){
            $dates[] = $user->RequestDate;
        }
        $dates =  array_unique($dates);
        return view('backend.reports.incoming', compact('users', 'dates'));
    }

    public function outgoing(){
        $users = DB::select(DB::raw("select request_referral.title, request_referral.referid as RefID, FROM_UNIXTIME(requests.dateadd,'%Y/%m') as RequestDate, (SELECT count(second_part_type) FROM requests where is_deleted = 0 and requests.out_referal_id = RefID and FROM_UNIXTIME(requests.dateadd,'%Y/%m') = RequestDate and second_part_type = 'husband') AS totalWifeRequests, (SELECT count(second_part_type) FROM requests where is_deleted = 0 and requests.out_referal_id = RefID and FROM_UNIXTIME(requests.dateadd,'%Y/%m') = RequestDate and second_part_type = 'wife') AS totalHusbandRequests from requests,request_referral where requests.out_referal_id = request_referral.referid group by RequestDate,RefID order by RequestDate desc"));
        $dates = [];
        foreach ($users as $key => $user){
            $dates[] = $user->RequestDate;
        }
        $dates =  array_unique($dates);
        return view('backend.reports.outgoing', compact('users', 'dates'));
    }

    public function categories(){
        $users = DB::select(DB::raw("select cases_categories.title, cases_categories.catid as RefID, FROM_UNIXTIME(requests.dateadd,'%Y/%m') as RequestDate, (SELECT count(second_part_type) FROM requests where is_deleted = 0 and requests.out_referal_id = RefID and FROM_UNIXTIME(requests.dateadd,'%Y/%m') = RequestDate and second_part_type = 'husband') AS totalWifeRequests, (SELECT count(second_part_type) FROM requests where is_deleted = 0 and requests.out_referal_id = RefID and FROM_UNIXTIME(requests.dateadd,'%Y/%m') = RequestDate and second_part_type = 'wife') AS totalHusbandRequests from requests, request_sessions,cases_categories where request_sessions.reqid = requests.reqid and cases_categories.catid in (request_sessions.category_tags) group by RequestDate,RefID order by RequestDate desc"));
        $dates = [];
        foreach ($users as $key => $user){
            $dates[] = $user->RequestDate;
        }
        $dates =  array_unique($dates);
        return view('backend.reports.categories', compact('users', 'dates'));
    }
}
