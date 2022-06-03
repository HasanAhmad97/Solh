<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Referral\CreateRequestReferralRequest;
use App\Models\RequestReferral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index(){
        $referrals = RequestReferral::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.referral.index', compact('referrals'));
    }

    public function create(){
        return view('backend.settings.referral.create');
    }

    public function store(CreateRequestReferralRequest $request){
        $referral = new RequestReferral();
        $referral->title = $request->input('title');
        $referral->contact_name = $request->input('contact_name');
        $referral->closed = $request->input('closed');
        $referral->is_deleted = 0;
        $referral->added_userid = auth()->user()->userid;
        $referral->dateadd = time();
        if ($referral->save()){
            return redirect()->route('admin.settings.referral')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.referral')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $referral = RequestReferral::find($id);
        if (!$referral){
            return redirect()->route('admin.settings.referral')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $referral->is_deleted = 1;
        $referral->delete_userid = auth()->user()->userid;
        $referral->save();
        return redirect()->route('admin.settings.referral')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $referral = RequestReferral::find($id);
        if (!$referral){
            return redirect()->route('admin.settings.referral')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.referral.edit', compact('referral'));
    }

    public function update(CreateRequestReferralRequest $request, $id){
        $referral = RequestReferral::find($id);
        if (!$referral){
            return redirect()->route('admin.settings.referral')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $referral->title = $request->input('title');
        $referral->contact_name = $request->input('contact_name');
        $referral->closed = $request->input('closed');
        $referral->edited_userid = auth()->user()->userid;
        $referral->date_updated = time();
        if ($referral->save()){
            return redirect()->route('admin.settings.referral')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.referral')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
