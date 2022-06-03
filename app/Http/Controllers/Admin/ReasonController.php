<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reason\CreateCasesReasonRequest;
use App\Models\CasesReason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function index(){
        $reasons = CasesReason::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.reasons.index', compact('reasons'));
    }

    public function create(){
        return view('backend.settings.reasons.create');
    }

    public function store(CreateCasesReasonRequest $request){
        $reason = new CasesReason();
        $reason->title = $request->input('title');
        if ($request->input('default_complainant') != 'unknown'){
            $reason->default_complainant = $request->input('default_complainant');
        }
        $reason->closed = $request->input('closed');
        $reason->is_deleted = 0;
        $reason->added_userid = auth()->user()->userid;
        $reason->dateadd = time();
        if ($reason->save()){
            return redirect()->route('admin.settings.reasons')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.reasons')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $reason = CasesReason::find($id);
        if (!$reason){
            return redirect()->route('admin.settings.reasons')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $reason->is_deleted = 1;
        $reason->delete_userid = auth()->user()->userid;
        $reason->save();
        return redirect()->route('admin.settings.reasons')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $reason = CasesReason::find($id);
        if (!$reason){
            return redirect()->route('admin.settings.reasons')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.reasons.edit', compact('reason'));
    }

    public function update(CreateCasesReasonRequest $request, $id){
        $reason = CasesReason::find($id);
        if (!$reason){
            return redirect()->route('admin.settings.reasons')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $reason->title = $request->input('title');
        if ($request->input('default_complainant') != 'unknown'){
            $reason->default_complainant = $request->input('default_complainant');
        }else{
            $reason->default_complainant = '';
        }
        $reason->closed = $request->input('closed');
        $reason->edited_userid = auth()->user()->userid;
        $reason->date_updated = time();
        if ($reason->save()){
            return redirect()->route('admin.settings.reasons')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.reasons')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
