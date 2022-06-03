<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return view('backend.settings.index');
    }

    public function update(Request $request){
        $settings = Setting::all();
        foreach ($settings as $setting){
            if ($setting->varname == 'closeSmsServer'){
                $setting->value = $request->has('close_sms_server') ? 0 : 1;
                $setting->save();
            }elseif ($setting->varname == 'update_request_complate_timer'){
                $setting->value = $request->input('update_request_complate_timer');
                $setting->save();
            }elseif ($setting->varname == 'update_request_complate_reminder_timer'){
                $setting->value = $request->input('update_request_complate_reminder_timer');
                $setting->save();
            }elseif ($setting->varname == 'max_daily_requests'){
                $setting->value = $request->input('max_daily_requests');
                $setting->save();
            }
        }
        return redirect()->route('admin.settings')->with(['status' => 'success', 'msg' => 'تم تحديث إعدادات النظام بنجاح،']);
    }
}
