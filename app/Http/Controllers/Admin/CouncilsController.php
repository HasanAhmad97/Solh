<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Council\CreateCouncilRequest;
use App\Models\CouncilsMeetingLocation;
use Illuminate\Http\Request;

class CouncilsController extends Controller
{
    public function index(){
        $councils = CouncilsMeetingLocation::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.councils.index', compact('councils'));
    }

    public function create(){
        return view('backend.settings.councils.create');
    }

    public function store(CreateCouncilRequest $request){
        $council = new CouncilsMeetingLocation();
        $council->order_level = $request->input('order_level');
        $council->room_code = $request->input('room_code');
        $council->level_code = $request->input('level_code');
        $council->total_chairs = $request->input('total_chairs');
        $council->meeting_location = $request->input('meeting_location');
        $council->closed = $request->input('closed');
        $council->dateadd = time();
        $council->added_userid = auth()->user()->userid;
        if ($council->save()){
            return redirect()->route('admin.settings.councils')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.councils')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $council = CouncilsMeetingLocation::find($id);
        if (!$council){
            return redirect()->route('admin.settings.councils')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $council->is_deleted = 1;
        $council->delete_userid = auth()->user()->userid;
        $council->save();
        return redirect()->route('admin.settings.councils')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $council = CouncilsMeetingLocation::find($id);
        if (!$council){
            return redirect()->route('admin.settings.councils')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.councils.edit', compact('council'));
    }

    public function update(CreateCouncilRequest $request, $id){
        $council = CouncilsMeetingLocation::find($id);
        if (!$council){
            return redirect()->route('admin.settings.councils')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $council->order_level = $request->input('order_level');
        $council->room_code = $request->input('room_code');
        $council->level_code = $request->input('level_code');
        $council->total_chairs = $request->input('total_chairs');
        $council->meeting_location = $request->input('meeting_location');
        $council->closed = $request->input('closed');
        $council->date_updated = time();
        $council->edited_userid = auth()->user()->userid;
        if ($council->save()){
            return redirect()->route('admin.settings.councils')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.councils')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
