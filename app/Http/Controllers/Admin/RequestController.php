<?php

namespace App\Http\Controllers\Admin;
use App\lib\FilesUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Request\CreateRequestRequest;
use App\Models\RequestSession;
use App\Models\RequestsInfo;
use App\Models\User;
use App\Models\NationalityList;
use App\Models\StudyLevel;
use App\Models\CasesCloseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use File;


class RequestController extends Controller
{

    public function create(){
        $lastCaseNumber = DB::select(DB::raw("select max(auto_number) as maxNumber from requests where FROM_UNIXTIME(dateadd,'%Y') = " . date('Y')));
        return view('backend.request.create', compact('lastCaseNumber'));
    }  
    public function view($id,$status){
         $getRequest = \App\Models\Request::select('*')
                    ->where('reqid',$id)
                    ->first();
                    
        return view('backend.request.request-view',compact('getRequest','status'));
    }  
    public function approve(Request $request){
        $userid = Auth::id();
        $tempRequest = \App\Models\Request::where('reqid',$request->reqid)->limit(1)->update(array('status' => 'APPROVED','date_updated' => time(), 'edited_userid' => $userid)); 
        return redirect()->route('admin.request.waiting.approve')->with(['status' => 'success', 'msg' => 'تم اعتماد الطلب']);
    }  
    public function close(Request $request){
           if($request->hasFile('req_archive_file'))
          {
            $fileName = time().'.'.$request->req_archive_file->extension();  
            $request->req_archive_file->move(public_path('uploads'), $fileName);
          }
          $getRequest = \App\Models\Request::select('*')
                    ->where('reqid',$request->reqid)
                    ->first();
         $requests = \App\Models\Request::where('reqid', $request->reqid)->update(['req_archive_file' => $fileName ?? "",'out_referal_id' => $request->out_referal_id,'admin_notes' => $request->admin_notes,'close_status_id' => $request->close_status_id,'status' => 'COMPLATED']);
         $requests =  DB::table('mos_reward')->insert(['mosid' => $request->primary_mos ?? "",'sec_mosid' => $request->sec_mos,'reqid' => $request->reqid,'amount' => $request->primary_mos_reward,'sec_amount' => $request->sec_mos_reward ?? ""]);
         
         $requestsInfo = RequestsInfo::where('reqid', $request->reqid)->where('status', 'waiting')->update(['admin_notes' => $request->admin_notes,'status' =>'COMPLATED']);
          $requestsession = RequestSession::where('reqid', $request->reqid)->update(['session_end_time' => 'session_date','session_start_time' => 'session_date','status' => 'finish']);
          $casetitles = CasesCloseStatus::select(['require_notification','title'])->where('close_status_id', $request->close_status_id)->first();
          if ($casetitles->count() > 0) {
            if ($casetitles->require_notification == 1) {
                sendSMS(
                    $getRequest->phone_number,
                    "تم انتهاء الطلب الخاص بك # $getRequest->reqid وتغيير حالته الى [ $casetitles->title ]"
                );
                
            }
             return redirect()->route('admin.archive.request')->with(['status' => 'success', 'msg' => 'تم إغلاق القضية !']);
        }
    }
    public function edit($id){
         $lastCaseNumber = DB::select(DB::raw("select max(auto_number) as maxNumber from requests where FROM_UNIXTIME(dateadd,'%Y') = " . date('Y')));
         $getRequest = \App\Models\Request::select('*')
                    ->where('reqid',$id)
                    ->first();
        $req_info = RequestsInfo::select('*')
              ->where('reqid' , $id)
                ->first();
        return view('backend.request.edit', compact('lastCaseNumber','getRequest','req_info'));
    }
    public function delete($id){
         $getRequest = \App\Models\Request::where('reqid',$id)
                    ->update(['is_deleted' => 1]);
            $req_info = RequestsInfo::where('reqid' , $id)
                    ->update(['is_deleted' => 1]);
        return redirect()->back()->with(['status' => 'success', 'msg' => 'تم حذف الطلب بنجاح ']);
      
    }
    public function editpost(Request $request){
        
          if($request->hasFile('attachments'))
          {
            $fileName = time().'.'.$request->attachments->extension();  
            $request->attachments->move(public_path('uploads'), $fileName);
          }
   
         $requests = \App\Models\Request::where('reqid', $request->reqid)->update(['name' => $request->name,'req_type' => $request->req_type,'referal_id' => $request->referral_id,'email' => $request->req_type,'transaction_number' => $request->transaction_number ?? "","second_part_type" => $request->second_part_type,"additional_file" => $fileName ?? ""]);
         $requestsInfo = RequestsInfo::where('reqid', $request->reqid)->update(['husband_name' => $request->husband_name,'husband_nationality_id' => $request->husband_nationality_id,'husband_national_id' => $request->husband_national_id,'husband_phone' => $request->husband_phone ?? "","wife_name" => $request->wife_name,"wife_nationality_id" => $request->wife_nationality_id ?? "",'wife_phone' => $request->wife_phone ?? "",'marriage_duration' => $request->marriage_duration,'children_no' => $request->children_no,'marriage_money_amount' => $request->marriage_money_amount,'marriage_money_amount' => $request->marriage_money_amount,'marriage_late_money_amount' => $request->marriage_late_money_amount,'total_previous_divorce_count' => $request->total_previous_divorce_count]);
             return redirect()->route('admin.archive.request')->with(['status' => 'success', 'msg' => 'تم تعديل الطلب بنجاح !']);
        
    }
    public function getreferral(Request $request){
        $data['referral'] = array();
        $data['req_type'] = array();
        $data['referral'][] = $request->referral;
        $data['req_type'][] = $request->req_type;
        return $data;
    }
    public function complete($req_uuid){
        if(strstr( $req_uuid, 'c-h-' ))
        {
         $req_uuid = trim($req_uuid, "c-h-");
         $side = 'first';
        }
        else if(strstr( $req_uuid, 'c-w-' ))
        {
         $req_uuid = trim($req_uuid, "c-w-");
         $side = 'second';
        }
        $getRequest = \App\Models\Request::select(array("reqid","husband_phone_number","wife_phone_number","name","id_number"))
                    ->whereIn('status', ['WAITING', 'WAITING_INFO_COMPLATE', 'INFO_COMPLATE_NOTIFY'])->where('req_uuid',$req_uuid)
                    ->get();
      if($getRequest->count()  == 0)
      {
         return redirect()->route('message')->withErrors(['msg' => 'لم يتم العثور على المعاملة المطلوبة']);
      }
      $getRequest = $getRequest->first();
      $reqID = $getRequest->reqid;
      $getnationality = NationalityList::select(array("nationality_id","title","title_female"))
                  ->where('is_deleted' , 0)->where('closed' , 0)->orderBy('dateadd')
                    ->get();
      $studyLevels =   StudyLevel::select(array("study_id","title"))
              ->where('is_deleted' , 0)->where('closed' , 0)->orderBy('dateadd')
                ->get();
         $req_info = RequestsInfo::select('*')
              ->where('reqid' , intval($reqID))
                ->first();
        if($req_info)
        {
                 if ($req_info->husband_phone == "") $req_info->husband_phone =  $getRequest->husband_phone_number;
                 if ($req_info->wife_phone == "") $req_info->wife_phone =  $getRequest->wife_phone_number;
        }
        
        return view('backend.request.complete', compact('side','getRequest','getnationality','studyLevels','req_info'));

      
    }
    public function storeComplete(Request $request)
    {   
        $requestInfo = RequestsInfo::select('*')->where('reqid',$request->reqid)->first();
        $getrequest = \App\Models\Request::select('*')->where('reqid',$request->reqid)->first();
            if($requestInfo != '[]')
            {
                if($request->type == 'first')
                {
                     $requestInfo = RequestsInfo::where('reqid',$request->reqid)->limit(1)->update(array('husband_name' => $request->husband_name ,'husband_nationality_id' => $request->husband_nationality_id ,'husband_national_id' => $request->husband_national_id ,'husband_phone' => $request->husband_phone,'husband_age' => $request->husband_age,'husband_work_status' => $request->husband_work_status,'husband_medical_condition' => $request->husband_medical_condition,'husband_study_levelid' => $request->husband_study_levelid,'marriage_duration' => $request->marriage_duration,'children_no' => $request->children_no,'marriage_money_amount' => $request->marriage_money_amount) );
                     $getrequest = \App\Models\Request::where('reqid',$request->reqid)->limit(1)->update(array('husband_complate_info' => 1));
                }
                else
                {
                    $requestInfo = RequestsInfo::where('reqid',$request->reqid)->limit(1)->update(array('wife_name' => $request->wife_name ,'wife_nationality_id' => $request->wife_nationality_id,'wife_national_id' => $request->wife_national_id ,'wife_phone' => $request->wife_phone,'wife_age' => $request->wife_age,'wife_work_status' => $request->wife_work_status,'wife_medical_condition' => $request->wife_medical_condition,'wife_study_levelid' => $request->wife_study_levelid) );
                    $temprequest = \App\Models\Request::where('reqid',$request->reqid)->limit(1)->update(array('wife_complate_info' => 1));

                }
                 $getrequest = \App\Models\Request::select('*')->where('reqid',$request->reqid)->where('husband_complate_info','1')->where('wife_complate_info','1')->count();

                if($getrequest!=0)
                {
                    $temprequest = \App\Models\Request::where('reqid',$request->reqid)->limit(1)->update(['status' => 'WAITING_APPROVE']);
                }
                return redirect()->route('message')->with(['status' => 'success', 'msg' => 'تم تحديث البيانات بنجاح ']);
            }
            else
            {
                if($request->type == 'first')
                {
                    $requestInfo = RequestsInfo::insert(array('reqid' => $request->reqid , 'husband_name' => $request->husband_name ?? ' ' ,'husband_nationality_id' => $request->husband_nationality_id ,'husband_national_id' => $request->husband_national_id ?? ' ' ,'husband_phone' => $request->husband_phone ?? ' ','husband_age' => $request->husband_age ?? ' ','husband_work_status' => $request->husband_work_status ?? ' ','husband_medical_condition' => $request->husband_medical_condition ?? ' ','husband_study_levelid' => $request->husband_study_levelid ?? ' ','marriage_duration' => $request->marriage_duration ?? ' ','children_no' => $request->children_no ?? ' ','marriage_money_amount' => $request->marriage_money_amount ?? ' ' ) );
                }
                else
                {
                    $requestInfo = RequestsInfo::insert(array('reqid' => $request->reqid ,'wife_name' => $request->wife_name ?? ' ' ,'wife_nationality_id' => $request->wife_nationality_id ?? ' ','wife_national_id' => $request->wife_national_id ?? ' ','wife_phone' => $request->wife_phone ?? ' ','wife_age' => $request->wife_age ?? ' ','wife_work_status' => $request->wife_work_status ?? ' ','wife_medical_condition' => $request->wife_medical_condition ?? ' ','wife_study_levelid' => $request->wife_study_levelid ?? ' ' ) );
                }
                return redirect()->route('message')->with(['status' => 'success', 'msg' => 'تم تحديث البيانات بنجاح ']);

            }
      
    }
    public function message(){
        return view('backend.request.message');
    }       

    public function store(CreateRequestRequest $request){
        $user = User::firstWhere('phone', fixPhoneNumber($request->input('husband_phone')));
        if(!$user){
            $password = createRandomKey(5);
            $newUser = new User();
            $newUser->picture = 'no_img.png';
            $newUser->name = $request->input('husband_name');
            $newUser->password = md5($password);
            $newUser->phone = fixPhoneNumber($request->input('husband_phone'));
            $newUser->usergroup = 1;
            $newUser->email = createRandomKey(10) . '@tawafoq.org.sa';
            $newUser->date_join = time();
            $newUser->last_seen = time();
            $newUser->save();
            $insertUID = $newUser->userid;

        }else{
            $insertUID = $user->userid;
        }

        $reqUUID = gen_uuid();
        
        if($request->hasFile('attachments')){
            $fileName = time().'.'.$request->attachments->extension();  
            $request->attachments->move(public_path('uploads'), $fileName);
        }
   
        $lastCaseNumber = DB::select(DB::raw("select max(auto_number) as maxNumber from requests where FROM_UNIXTIME(dateadd,'%Y') = " . date('Y')));

        $requests = new \App\Models\Request();
        $requests->auto_number = $lastCaseNumber[0]->maxNumber+1;
        $requests->req_uuid = $reqUUID;
        $requests->name = $request->input('husband_name') ?? "";
        $requests->id_number = $request->input('husband_national_id') ?? "";
        $requests->phone_number = fixPhoneNumber($request->input('husband_phone')) ?? "";
        $requests->husband_phone_number = fixPhoneNumber($request->input('husband_phone')) ?? "";
        $requests->wife_phone_number = fixPhoneNumber($request->input('wife_phone_number')) ?? "";
        $requests->email = $request->input('email') ?? "";
        if ($request->input('req_type') != 'other'){
            $requests->req_type = $request->input('req_type') ?? "";
        }
        $requests->second_part_type = $request->input('second_part_type') ?? "";
        $requests->request_description = $request->input('request_description') ?? "";
        $requests->transaction_number = $request->input('transaction_number') ?? "";
        $requests->referal_id = $request->input('referral_id') ?? "";
        $requests->added_userid = auth()->user()->userid;
        $requests->userid = $insertUID;
        $requests->dateadd = time();
        $requests->additional_file = $fileName ?? "";
        $requests->save();

        $requestInfo = new RequestsInfo();
        $requestInfo->reqid = $requests->reqid;
        $requestInfo->husband_name = $request->input('husband_name') ?? '';
        $requestInfo->wife_name = $request->input('wife_name') ?? '';
        $requestInfo->husband_nationality_id = $request->input('husband_nationality_id') ?? '';
        $requestInfo->wife_nationality_id = $request->input('wife_nationality_id') ?? '';
        $requestInfo->husband_phone = $request->input('husband_phone') ?? '';
        $requestInfo->wife_phone = $request->input('wife_phone') ?? '';
        $requestInfo->husband_national_id = $request->input('husband_national_id') ?? '';
        $requestInfo->wife_national_id = $request->input('wife_national_id') ?? '';
        $requestInfo->added_userid = Auth::id();
        $requestInfo->dateadd = time();
        $requestInfo->save();

        sendSMS(
            fixPhoneNumber($request->input('husband_phone')),
            "تعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.be/pldpY94Bxng وبناء على الطلب المحالة من محكمة الأحوال الشخصية بالمدينة المنورة، نرجو منك إكمال البيانات الخاصة بك لسرعة تحديد موعد للجلسة عبر الرابط"  . "http://solh.tawafoq.org.sa/complete" . "/c-h-$reqUUID"
        );

        sendSMS(
           fixPhoneNumber($request->input('wife_phone')),
            "تعرف على آلية الصلح الأسري بجمعية توافق عبر اليوتيوب: https://youtu.be/pldpY94Bxng وبناء على الطلب المحالة من محكمة الأحوال الشخصية بالمدينة المنورة، نرجو منك إكمال البيانات الخاصة بك لسرعة تحديد موعد للجلسة عبر الرابط"  . "http://solh.tawafoq.org.sa/complete" . "/c-w-$reqUUID"
        );

        return redirect()->route('admin.request.create')->with(['status' => 'success', 'msg' => 'تم اضافة الطلب بنجاح !']);
    }


    public function attendance(){
        $mytime = Carbon::now()->format('Ymd');
        $requests = RequestSession::whereRaw("FROM_UNIXTIME(session_date, '%Y%m%d') = {$mytime}")->where('is_deleted', 0)->orderBy('session_date', 'desc')->paginate(20);
        return view('backend.request.attendance', compact('requests'));
    }
    public function getattendance($id,$type){
        echo $type;
        echo '\n';
        echo $id;
         switch ($type) {
            default:
                $fieldName = "moslh_present_date";
                break;
            case "first":
                $fieldName = "husband_present_date";
                break;
            case "second":
                $fieldName = "wife_present_date";
                break;
        }
        $sess = RequestSession::where($fieldName,0)->where('sessionid',$id)->update([$fieldName => time()]);

         return redirect()->route('admin.request.attendance')->with(['status' => 'success', 'msg' => 'تم التحضير ']);
 }

  public function waiting(){
        $requests = \App\Models\Request::where('is_deleted', 0)->where('transaction_number','!=','0')->whereIn('status', ['WAITING','WAITING_INFO_COMPLATE','INFO_COMPLATE_NOTIFY'])->orderBy('reqid', 'desc')->paginate(20);
        $waitType = 'wait';
        return view('backend.request.waiting', compact('requests','waitType'));
    }
     public function selfwaiting(){
        $requests = \App\Models\Request::where('is_deleted', 0)->where('transaction_number','0')->whereIn('status', ['WAITING','WAITING_INFO_COMPLATE','INFO_COMPLATE_NOTIFY'])->orderBy('reqid', 'desc')->paginate(20);
        $waitType = 'self-wait';
        return view('backend.request.waiting', compact('requests','waitType'));
    }


    public function filter(Request $request){
        if($request->input('filter_type') == "waiting_approve")
        {
            $requests = \App\Models\Request::where('is_deleted', 0)->where('status', 'WAITING_APPROVE')->orderBy('reqid', 'desc')->paginate(20);
        }
        else
        {
        $requests = \App\Models\Request::where('is_deleted', 0)->whereIn('status', ['WAITING','WAITING_INFO_COMPLATE','INFO_COMPLATE_NOTIFY'])->orderBy('reqid', 'desc')->paginate(20);
        }
        if(!$request->input('result'))
        {
            $result = ' ';
        }
        else
        {
            $result =  $request->input('result');
        }
      
        if($request->input('filter_type') == "waiting_approve")
        {
             foreach($requests as $key => $req)
         {           

             if($req->request_info->husband_name == $result || 
             $req->request_info->wife_name == $result || 
             $req->request_info->husband_phone == $result || 
             $req->request_info->wife_phone == $result ||
             $req->request_info->husband_nationality_id == $result || 
             $req->request_info->wife_nationality_id == $result)
             {
                 return view('backend.request.waiting-approve-filter', compact('req'));
             }
            
         }
         return view('backend.request.waiting-approve-filter');

        }
        else
        {
        foreach($requests as $key => $req)
         {
             if($req->request_info){
                 
                 if($req->request_info->husband_name == $result || 
                 $req->request_info->wife_name == $result || 
                 $req->request_info->husband_phone == $result || 
                 $req->request_info->wife_phone == $result ||
                 $req->request_info->husband_nationality_id == $result || 
                 $req->request_info->wife_nationality_id == $result)
                 {
                     return view('backend.request.waiting-filter', compact('req'));
                 }
             }
         }
          return view('backend.request.waiting-filter');

        }
        
    }
    public function attendance_filter(Request $request){
         if(!$request->input('result'))
        {
            $result = ' ';
        }
        else
        {
            $result =  $request->input('result');
        }
         $mytime = Carbon::now()->format('Ymd');
         $getRequestInfo = RequestsInfo::where('is_deleted', 0)->where('husband_name', $result)->orWhere('wife_name', $result)->orWhere('husband_phone', $result)->orWhere('wife_phone', $result)->orWhere('husband_nationality_id', $result)->orWhere('wife_nationality_id', $result)->first();
         if($getRequestInfo != [])
         {
               $requests = RequestSession::whereRaw("FROM_UNIXTIME(session_date, '%Y%m%d') = {$mytime}")->where('is_deleted', 0)->where('reqid',$getRequestInfo->reqid)->orderBy('session_date', 'desc')->paginate(20);
               return view('backend.request.attendance', compact('requests'));
         }
                     return view('backend.request.attendance');

    }
    public function waiting_approve(){
        $requests = \App\Models\Request::where('is_deleted', 0)->where('status', 'WAITING_APPROVE')->orderBy('reqid', 'desc')->paginate(20);
        return view('backend.request.waiting-approve', compact('requests'));
    }
}
