<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Models\JobTitleList;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request){
        $name = '';
        $email = '';
        $phone = '';
        $status = '';

        $users = User::where('is_deleted',0)->orderBy('userid', 'desc');
        if ($request->has('name') && $request->name != '' && $request->name != null){
            $users = $users->where('name', 'like', '%'.$request->name.'%');
            $name = $request->name;
        }
        if ($request->has('email') && $request->email != '' && $request->email != null){
            $users = $users->where('email', 'like', '%'.$request->email.'%');
            $email = $request->email;
        }
        if ($request->has('phone') && $request->phone != '' && $request->phone != null){
            $users = $users->where('phone', 'like', '%'.$request->phone.'%');
            $phone = $request->phone;
        }
        if ($request->has('status') && $request->status != '' && $request->status != null){
            if ($request->status == 'email_confirm'){
                $users = $users->where('emailconfirm', 0);
            }elseif ($request->status == 'closed1'){
                $users = $users->where('closed', 1);
            }elseif ($request->status == 'closed0'){
                $users = $users->where('closed', 0);
            }
            $status = $request->status;
        }
        $users = $users->paginate(20);
        return view('backend.users.index', compact('users', 'name', 'email', 'phone', 'status'));
    }

    public function create(){
        return view('backend.users.create');
    }

    public function store(CreateUserRequest $request){
        $phoneStr = $request->input('phone');
        if (strlen($request->input('phone')) == 10) {
           $phoneStr = "966" . substr($request->input('phone'), 1);
        } else if (strlen($request->input('phone')) == 14) {
            $phoneStr = substr($request->input('phone'), 2);
        } else if (strlen($request->input('phone')) != 11 && strlen($request->input('phone')) != 12 && strlen($request->input('phone')) != 13) {
            $phoneStr = "966" . substr($request->input('phone'), -9);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->phone = fixPhoneNumber($phoneStr);
        $user->password = md5($request->input('password'));
        $user->email = $request->input('email');
        $user->closed = 0;
        $user->usergroup = $request->input('usergroup');
        $user->otp_verified = 1;
        // $user->emailconfirm = 1;
        if ($request->has('job_title_id')){
            $user->job_title_id = $request->input('job_title_id');
            $user->usergroup = 3;
        }else{
            $user->usergroup = $request->input('usergroup');
        }
        $user->date_join = time();
        $user->last_seen = time();
        if ($user->save()){
            if ($request->has('job_title_id')) {
                $user->job_title_id = $request->input('job_title_id');
                return redirect()->route('admin.users.staff')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
            }
            return redirect()->route('admin.users')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($userid){
        $user = User::find($userid);
        if (!$user){
            return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $user->update(['is_deleted' => 1]);
        return redirect()->route('admin.users')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function close($id){
        $user = User::find($id);
        if (!$user){
            return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $user->closed = 1;
        $user->save();
        return redirect()->route('admin.users')->with(['status' => 'success', 'msg' => 'تمت اغلاق العنصر بنجاح !']);
    }

    public function active($id){
        $user = User::find($id);
        if (!$user){
            return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $user->closed = 0;
        $user->save();
        return redirect()->route('admin.users')->with(['status' => 'success', 'msg' => 'تمت تفعيل العنصر بنجاح !']);
    }

    public function edit($id){
        $user = User::find($id);
        if (!$user){
            return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.users.edit', compact('user'));
    }

    public function update($userid, UpdateUserRequest $request){
        $user = User::find($userid);
        if (!$user){
            return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }

        $phoneStr = $request->input('phone');
        if (strlen($request->input('phone')) == 10) {
            $phoneStr = "966" . substr($request->input('phone'), 1);
        } else if (strlen($request->input('phone')) == 14) {
            $phoneStr = substr($request->input('phone'), 2);
        } else if (strlen($request->input('phone')) != 11 && strlen($request->input('phone')) != 12 && strlen($request->input('phone')) != 13) {
            $phoneStr = "966" . substr($request->input('phone'), -9);
        }

        $user->name = $request->input('name');
        $user->phone = fixPhoneNumber($phoneStr);
        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->email = $request->input('email');
        if ($request->has('job_title_id')){
            $user->job_title_id = $request->input('job_title_id');
            $user->usergroup = 3;
        }else{
            $user->usergroup = $request->input('usergroup');
        }
        if ($user->save()){
            if ($request->has('job_title_id')) {
                $roles = Role::all();
                foreach ($roles as $role){
                    if ($user->hasRole($role->name)){
                        $user->removeRole($role->name);
                    }
                }
                $user->assignRole(Role::findById($request->input('job_title_id'))->name);
                return redirect()->route('admin.users.staff')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
            }
            return redirect()->route('admin.users')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.users')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function mslh(Request $request){
        $name = '';
        $email = '';
        $phone = '';
        $status = '';

        $users = User::where('usergroup', 2)->orderBy('userid', 'desc');
        if ($request->has('name') && $request->name != '' && $request->name != null){
            $users = $users->where('name', 'like', '%'.$request->name.'%');
            $name = $request->name;
        }
        if ($request->has('email') && $request->email != '' && $request->email != null){
            $users = $users->where('email', 'like', '%'.$request->email.'%');
            $email = $request->email;
        }
        if ($request->has('phone') && $request->phone != '' && $request->phone != null){
            $users = $users->where('phone', 'like', '%'.$request->phone.'%');
            $phone = $request->phone;
        }
        if ($request->has('status') && $request->status != '' && $request->status != null){
            if ($request->status == 'email_confirm'){
                $users = $users->where('emailconfirm', 0);
            }elseif ($request->status == 'closed1'){
                $users = $users->where('closed', 1);
            }elseif ($request->status == 'closed0'){
                $users = $users->where('closed', 0);
            }
            $status = $request->status;
        }
        $users = $users->paginate(20);
        return view('backend.users.mslh', compact('users', 'name', 'email', 'phone', 'status'));
    }

    public function staff(Request $request){
        $name = '';
        $email = '';
        $phone = '';
        $status = '';

        $users = User::where('usergroup', 3)->orderBy('userid', 'desc');
        if ($request->has('name') && $request->name != '' && $request->name != null){
            $users = $users->where('name', 'like', '%'.$request->name.'%');
            $name = $request->name;
        }
        if ($request->has('email') && $request->email != '' && $request->email != null){
            $users = $users->where('email', 'like', '%'.$request->email.'%');
            $email = $request->email;
        }
        if ($request->has('phone') && $request->phone != '' && $request->phone != null){
            $users = $users->where('phone', 'like', '%'.$request->phone.'%');
            $phone = $request->phone;
        }
        if ($request->has('status') && $request->status != '' && $request->status != null){
            if ($request->status == 'email_confirm'){
                $users = $users->where('emailconfirm', 0);
            }elseif ($request->status == 'closed1'){
                $users = $users->where('closed', 1);
            }elseif ($request->status == 'closed0'){
                $users = $users->where('closed', 0);
            }
            $status = $request->status;
        }
        $users = $users->paginate(20);
        return view('backend.users.staff', compact('users', 'name', 'email', 'phone', 'status'));
    }

    public function staff_create(){
        $role = JobTitleList::select('*')->where('is_deleted', 0)->get();
        return view('backend.users.staff-create', compact('role'));
    }

    public function staff_edit($id){
        $user = User::find($id);
        if (!$user){
            return redirect()->route('admin.users.staff')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.users.staff-edit', compact('user'));
    }

    public function admins(Request $request){
        $name = '';
        $email = '';
        $phone = '';
        $status = '';

        $users = User::where('usergroup', 10)->orderBy('userid', 'desc');
        if ($request->has('name') && $request->name != '' && $request->name != null){
            $users = $users->where('name', 'like', '%'.$request->name.'%');
            $name = $request->name;
        }
        if ($request->has('email') && $request->email != '' && $request->email != null){
            $users = $users->where('email', 'like', '%'.$request->email.'%');
            $email = $request->email;
        }
        if ($request->has('phone') && $request->phone != '' && $request->phone != null){
            $users = $users->where('phone', 'like', '%'.$request->phone.'%');
            $phone = $request->phone;
        }
        if ($request->has('status') && $request->status != '' && $request->status != null){
            if ($request->status == 'email_confirm'){
                $users = $users->where('emailconfirm', 0);
            }elseif ($request->status == 'closed1'){
                $users = $users->where('closed', 1);
            }elseif ($request->status == 'closed0'){
                $users = $users->where('closed', 0);
            }
            $status = $request->status;
        }
        $users = $users->paginate(20);
        return view('backend.users.admins', compact('users', 'name', 'email', 'phone', 'status'));
    }
}
