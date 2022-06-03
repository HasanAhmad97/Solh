<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Study\CreateStudyLevelRequest;
use App\Models\StudyLevel;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index(){
        $levels = StudyLevel::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.study.index', compact('levels'));
    }

    public function create(){
        return view('backend.settings.study.create');
    }

    public function store(CreateStudyLevelRequest $request){
        $level = new StudyLevel();
        $level->title = $request->input('title');
        $level->closed = $request->input('closed');
        $level->is_deleted = 0;
        $level->added_userid = auth()->user()->userid;
        $level->dateadd = time();
        if ($level->save()){
            return redirect()->route('admin.settings.study')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.study')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $level = StudyLevel::find($id);
        if (!$level){
            return redirect()->route('admin.settings.study')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $level->is_deleted = 1;
        $level->delete_userid = auth()->user()->userid;
        $level->save();
        return redirect()->route('admin.settings.study')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $level = StudyLevel::find($id);
        if (!$level){
            return redirect()->route('admin.settings.study')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.study.edit', compact('level'));
    }

    public function update(CreateStudyLevelRequest $request, $id){
        $level = StudyLevel::find($id);
        if (!$level){
            return redirect()->route('admin.settings.study')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $level->title = $request->input('title');
        $level->closed = $request->input('closed');
        $level->edited_userid = auth()->user()->userid;
        $level->date_updated = time();
        if ($level->save()){
            return redirect()->route('admin.settings.study')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.study')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
