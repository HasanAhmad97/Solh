<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Jobs\CreateRoleRequest;
use App\Models\JobTitleList;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class JobController extends Controller
{
    public function index(){
        $jobs = JobTitleList::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.jobs.index', compact('jobs'));
    }

    public function create(){
        return view('backend.settings.jobs.create');
    }

    public function store(CreateRoleRequest $request){
        $role = new Role();
        $role->name = $request->input('title');
        $role->closed = $request->input('closed');
        $role->guard_name = 'web';
        $role->is_deleted = 0;
        $role->added_userid = auth()->user()->userid;
        $role->dateadd = time();
        if ($role->save()){
            if ($request->has('permission') && (count($request->permission) > 0)){
                $permissions = $request->permission;
                foreach ($permissions as $iValue) {
                    $role->givePermissionTo($iValue);
                }
            }
            return redirect()->route('admin.settings.jobs')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.jobs')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $role = Role::find($id);
        if (!$role){
            return redirect()->route('admin.settings.jobs')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $role->is_deleted = 1;
        $role->delete_userid = auth()->user()->userid;
        $role->save();
        return redirect()->route('admin.settings.jobs')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $role = JobTitleList::where('job_title_id',$id)->first();
        if (!$role){
            return redirect()->route('admin.settings.jobs')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.jobs.edit', compact('role'));
    }

    public function update(CreateRoleRequest $request, $id){
        $role = JobTitleList::findById($id);
        if (!$role){
            return redirect()->route('admin.settings.jobs')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $role->title = $request->input('title');
        $role->closed = $request->input('closed');
        $role->edited_userid = auth()->user()->userid;
        $role->date_updated = time();
        if ($role->save()){

            if ($request->has('permission') && (count($request->permission) > 0)){
                $permissions = $request->permission;
                foreach ($role->permissions as $permission){
                    $role->revokePermissionTo($permission->name);
                }
                foreach ($permissions as $iValue) {
                    $role->givePermissionTo($iValue);
                }
            }
            return redirect()->route('admin.settings.jobs')->with(['status' => 'success', 'msg' => 'تمت تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.jobs')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
