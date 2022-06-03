<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Close\CreateCasesCloseRequest;
use App\Models\CasesCloseStatus;
use Illuminate\Http\Request;

class CasesCloseController extends Controller
{
    public function index(){
        $closes = CasesCloseStatus::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.close.index', compact('closes'));
    }

    public function create(){
        return view('backend.settings.close.create');
    }

    public function store(CreateCasesCloseRequest $request){
        $close = new CasesCloseStatus();
        $close->title = $request->input('title');
        $close->require_notification = $request->input('require_notification');
        $close->closed = $request->input('closed');
        $close->is_deleted = 0;
        $close->added_userid = auth()->user()->userid;
        $close->dateadd = time();
        if ($close->save()){
            return redirect()->route('admin.settings.close')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.close')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $close = CasesCloseStatus::find($id);
        if (!$close){
            return redirect()->route('admin.settings.close')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $close->is_deleted = 1;
        $close->delete_userid = auth()->user()->userid;
        $close->save();
        return redirect()->route('admin.settings.close')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $close = CasesCloseStatus::find($id);
        if (!$close){
            return redirect()->route('admin.settings.close')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.close.edit', compact('close'));
    }
    public function getreward(Request $request){
        $close_id = $request->close_status_id;
        $close_reward = CasesCloseStatus::select('reward_amount')->where('close_status_id',$close_id)->first();
        return $close_reward;
    }

    public function update(CreateCasesCloseRequest $request, $id){
        $close = CasesCloseStatus::find($id);
        if (!$close){
            return redirect()->route('admin.settings.close')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $close->title = $request->input('title');
        $close->reward_amount = $request->input('reward_amount');
        $close->require_notification = $request->input('require_notification');
        $close->closed = $request->input('closed');
        $close->edited_userid = auth()->user()->userid;
        $close->date_updated = time();
        if ($close->save()){
            return redirect()->route('admin.settings.close')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.close')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
