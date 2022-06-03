<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Nationality\CreateNationalityListRequest;
use App\Models\NationalityList;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function index(){
        $nationalities = NationalityList::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.nationality.index', compact('nationalities'));
    }

    public function create(){
        return view('backend.settings.nationality.create');
    }

    public function store(CreateNationalityListRequest $request){
        $nationality = new NationalityList();
        $nationality->title = $request->input('title');
        $nationality->title_female = $request->input('title_female');
        $nationality->country = $request->input('country');
        $nationality->closed = $request->input('closed');
        $nationality->is_deleted = 0;
        $nationality->added_userid = auth()->user()->userid;
        $nationality->dateadd = time();
        if ($nationality->save()){
            return redirect()->route('admin.settings.nationality')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.nationality')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $nationality = NationalityList::find($id);
        if (!$nationality){
            return redirect()->route('admin.settings.nationality')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $nationality->is_deleted = 1;
        $nationality->delete_userid = auth()->user()->userid;
        $nationality->save();
        return redirect()->route('admin.settings.nationality')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $nationality = NationalityList::find($id);
        if (!$nationality){
            return redirect()->route('admin.settings.nationality')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.nationality.edit', compact('nationality'));
    }

    public function update(CreateNationalityListRequest $request, $id){
        $nationality = NationalityList::find($id);
        if (!$nationality){
            return redirect()->route('admin.settings.nationality')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $nationality->title = $request->input('title');
        $nationality->title_female = $request->input('title_female');
        $nationality->country = $request->input('country');
        $nationality->closed = $request->input('closed');
        $nationality->edited_userid = auth()->user()->userid;
        $nationality->date_updated = time();
        if ($nationality->save()){
            return redirect()->route('admin.settings.nationality')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.nationality')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
