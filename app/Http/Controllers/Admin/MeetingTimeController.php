<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Meeting\CreateMeetingTimeRequest;
use App\Models\RequestMeetingTime;
use Illuminate\Http\Request;

class MeetingTimeController extends Controller
{
    public function index(){
        $meetings = RequestMeetingTime::where('is_deleted', 0)->orderBy('order_level', 'asc')->paginate(20);
        return view('backend.settings.meeting.index', compact('meetings'));
    }

    public function create(){
        return view('backend.settings.meeting.create');
    }

    public function store(CreateMeetingTimeRequest $request){
        $meeting = new RequestMeetingTime();
        $meeting->title = $request->input('title');
        $meeting->session_time_start = str_replace(['PM', 'AM'], '', $request->input('session_time_start'));
        $meeting->session_time_end = str_replace(['PM', 'AM'], '', $request->input('session_time_end'));
        $meeting->closed = $request->input('closed');
        $meeting->order_level = $request->input('order_level');
        $meeting->added_userid = auth()->user()->userid;
        $meeting->dateadd = time();
        $meeting->is_deleted = 0;
        if ($meeting->save()){
            return redirect()->route('admin.settings.meeting')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.meeting')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $meeting = RequestMeetingTime::find($id);
        if (!$meeting){
            return redirect()->route('admin.settings.meeting')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $meeting->is_deleted = 1;
        $meeting->delete_userid = auth()->user()->userid;
        $meeting->save();
        return redirect()->route('admin.settings.meeting')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $meeting = RequestMeetingTime::find($id);
        if (!$meeting){
            return redirect()->route('admin.settings.meeting')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.meeting.edit', compact('meeting'));
    }

    public function update(CreateMeetingTimeRequest $request, $id){
        $meeting = RequestMeetingTime::find($id);
        if (!$meeting){
            return redirect()->route('admin.settings.meeting')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $meeting->title = $request->input('title');
        $meeting->session_time_start = str_replace(['PM', 'AM'], '', $request->input('session_time_start'));
        $meeting->session_time_end = str_replace(['PM', 'AM'], '', $request->input('session_time_end'));
        $meeting->closed = $request->input('closed');
        $meeting->order_level = $request->input('order_level');
        $meeting->edited_userid = auth()->user()->userid;
        $meeting->date_updated = time();
        if ($meeting->save()){
            return redirect()->route('admin.settings.meeting')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.meeting')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
