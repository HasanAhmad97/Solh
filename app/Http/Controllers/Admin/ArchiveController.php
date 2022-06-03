<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestSession;
use App\Models\CasesReason;
use App\Models\RequestsInfo;
use App\Models\CasesCloseStatus;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function request_archive(){
        if(auth()->user()->usergroup != 1)
        {
            $requests = \App\Models\Request::where('is_deleted', 0)->orderBy('reqid', 'desc')->paginate(20);
           $casesreasons = CasesReason::select('*')->get();
           $casesclosestatus = CasesCloseStatus::select('*')->get();
            return view('backend.archive.request', compact('requests','casesreasons','casesclosestatus'));
        }
        else
        {
            $requests = \App\Models\Request::where('is_deleted', 0)->where('userid', auth()->user()->userid)->orderBy('reqid', 'desc')->paginate(20);
           $casesreasons = CasesReason::select('*')->get();
           $casesclosestatus = CasesCloseStatus::select('*')->get();
            return view('backend.archive.request', compact('requests','casesreasons','casesclosestatus'));
        }
    }
    public function request_archive_show($id){
        $requests = \App\Models\Request::where('reqid', $id)->first();
        // echo $requests;
        return view('backend.archive.request-view', compact('requests'));
    }
    public function search(Request $request){
        if(auth()->user()->usergroup != 1)
        {
            $casesreasons = CasesReason::select('*')->get();
            $casesclosestatus = CasesCloseStatus::select('*')->get();
            $result =  $request->input('result') ?? "";
            $req = RequestsInfo::where('is_deleted', 0)
            ->where('husband_name', 'like', "%{$result}%")
            ->orWhere('wife_name', 'like', "%{$result}%")
            ->orWhere('husband_phone',$result)
            ->orWhere('wife_phone',$result)
            ->orWhere('husband_nationality_id',$result)
            ->orWhere('wife_nationality_id',$result)
            ->get();
    
          if($req ?? "")
          {
              $requests = array();
              foreach($req as $request)
              {
                  $getrequests = \App\Models\Request::where('reqid',$request->reqid)
                ->orderBy('reqid', 'desc')->orderBy('reqid', 'desc')->first(); 
               $requests[] = $getrequests;
              }
              
                if($requests ?? "")
                  {
                        // print_r($requests);
                      return view('backend.archive.request-search', compact('requests','casesreasons','casesclosestatus'));
                  }
          }
        
             return view('backend.archive.request-search', compact('casesreasons','casesclosestatus'));   
        }
        else
        {
            
            $casesreasons = CasesReason::select('*')->get();
            $casesclosestatus = CasesCloseStatus::select('*')->get();
            $result =  $request->input('result') ?? "";
            $req = RequestsInfo::where('is_deleted', 0)
            ->where('husband_name', 'like', "%{$result}%")
            ->orWhere('wife_name', 'like', "%{$result}%")
            ->orWhere('husband_phone',$result)
            ->orWhere('wife_phone',$result)
            ->orWhere('husband_nationality_id',$result)
            ->orWhere('wife_nationality_id',$result)
            ->get();
    
          if($req ?? "")
          {
              $requests = array();
              foreach($req as $request)
              {
                  $getrequests = \App\Models\Request::where('reqid',$request->reqid)->where('userid', auth()->user()->userid)
                ->orderBy('reqid', 'desc')->orderBy('reqid', 'desc')->first(); 
               $requests[] = $getrequests;
              }
              
                if($requests ?? "")
                  {
                        // print_r($requests);
                      return view('backend.archive.request-search', compact('requests','casesreasons','casesclosestatus'));
                  }
          }
        
             return view('backend.archive.request-search', compact('casesreasons','casesclosestatus'));   
        }
       
    }
    public function filter(Request $request){
        
         $casesreasons = CasesReason::select('*')->get();
        $casesclosestatus = CasesCloseStatus::select('*')->get();
        if($request->start_date)
        {  
             $start = _timestamp($request->start_date, "Y-m-d");
            _timestamp($request->start_date, "Y-m-d");
             if($request->input('archive_type') == "request")
             {
            if($request->end_date)
            {
                $end =_timestamp($request->end_date, "Y-m-d");
            
                 $requests = \App\Models\Request::where('is_deleted', 0)  ->whereBetween('dateadd', array($start, $end))
                     ->whereBetween('dateadd', array($start, $end))->orderBy('reqid', 'desc')->paginate(20); 
            }
            else
            {
                 $requests = \App\Models\Request::where('is_deleted', 0)  ->where('dateadd', $start)
                     ->orderBy('reqid', 'desc')->paginate(20); 
            }
             }
             else
             {
                   $start = _timestamp($request->start_date, "Y-m-d");
                    _timestamp($request->start_date, "Y-m-d");
                    if($request->end_date)
                    {
                        $end =_timestamp($request->end_date, "Y-m-d");
                         $requests = RequestSession::where('is_deleted', 0)  ->whereBetween('session_date', array($start, $end))
                             ->whereBetween('session_date', array($start, $end))->orderBy('reqid', 'desc')->paginate(20); 
                    }
                    else
                    {
                         $requests = RequestSession::where('is_deleted', 0)  ->where('session_date', $start)
                             ->orderBy('reqid', 'desc')->paginate(20); 
                    }
             }
           
        }
        else
        {
               
              if($request->input('result') != -10 && $request->input('close_result') !=-10)
            {
                    if($request->input('archive_type') == "request")
                    {
                                 $requests = \App\Models\Request::where('is_deleted', 0)->where('req_type',$request->input('result'))->Where('close_status_id',$request->input('close_result'))->orderBy('reqid', 'desc')->paginate(20);
                    }
                    else
                    {
                        
                     $requestsid = \App\Models\Request::select('reqid')->where('is_deleted', 0)->where('req_type',$request->input('result'))->orderBy('reqid', 'desc')->get(); 
                     $ids = [];
                     foreach($requestsid as $id)
                     {
                         $ids[]=$id->reqid;
                        
                     }
                     $requests = RequestSession::where('is_deleted', 0)->whereIn('reqid',$ids)->orderBy('session_date', 'desc')->paginate(20);
                    }
            }
            else if ($request->input('result') != -10)
            {
                 $requests = \App\Models\Request::where('is_deleted', 0)->where('req_type',$request->input('result'))->orderBy('reqid', 'desc')->paginate(20);
            }
        
            else if ($request->input('close_result') != -10)
            {
                 $requests = \App\Models\Request::where('is_deleted', 0)->where('close_status_id',$request->input('close_result'))->orderBy('reqid', 'desc')->paginate(20);
            }
           
        }
         if($requests)
         {
             if($request->input('archive_type') == "request")
             {
                  return view('backend.archive.request', compact('requests','casesreasons','casesclosestatus'));
             }
            else
            {
                return view('backend.archive.session', compact('requests','casesreasons','casesclosestatus'));
            }
         }
       else
       {
              if($request->input('archive_type') == "request")
             {
                  return view('backend.archive.request', compact('casesreasons','casesclosestatus'));    
             }
            else
            {
                return view('backend.archive.session', compact('casesreasons','casesclosestatus'));   
            }
            
       }
}

    public function session_archive(){
        if(auth()->user()->usergroup != 1)
        {
        $requests = RequestSession::where('is_deleted', 0)->orderBy('session_date', 'desc')->paginate(20);
        $casesreasons = CasesReason::select('*')->get();
        $casesclosestatus = CasesCloseStatus::select('*')->get();
        return view('backend.archive.session', compact('requests','casesreasons','casesclosestatus')); 
        }
        else
        {
             $requests = RequestSession::where('is_deleted', 0)->orderBy('session_date', 'desc')->where('userid', auth()->user()->userid)->paginate(20);
        $casesreasons = CasesReason::select('*')->get();
        $casesclosestatus = CasesCloseStatus::select('*')->get();
        return view('backend.archive.session', compact('requests','casesreasons','casesclosestatus')); 
        }
       
    }
}
