<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'          => 'requests_attendance',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'waiting_review_requests',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'waiting_review_requests_delete',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'waiting_approved_requests',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'waiting_approved_requests_delete',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'waiting_approved_requests_approve',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_sessions_set_session',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_sessions_archive',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_sessions_delete',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'request_session_close',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_reports_moslh',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_reports_incoming',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_reports_outgoing',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'requests_reports_categories',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_general',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_study_levels',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_request_referral',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_nationality_list',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_cases_reasons',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_cases_categories',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_cases_close_status',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_councils_locations',
            'guard_name'    => 'web'
        ]);
        Permission::create([
            'name'          => 'settings_cases_meeting_time',
            'guard_name'    => 'web'
        ]);

        $role1 = Role::create([
            'name'          => 'موظف استقبال',
            'closed'        => 0,
            'dateadd'       => time(),
            'added_userid'  => 1,
            'is_deleted'    => 0
        ]);
        $role1->givePermissionTo('requests_attendance');
        $role1->givePermissionTo('requests_sessions_archive');

        $role2 = Role::create([
            'name'          => 'مشرف قسم',
            'closed'        => 0,
            'dateadd'       => time(),
            'added_userid'  => 1,
            'is_deleted'    => 0
        ]);
        $role2->givePermissionTo('requests_attendance');
        $role2->givePermissionTo('waiting_review_requests');
        $role2->givePermissionTo('waiting_approved_requests');
        $role2->givePermissionTo('waiting_approved_requests_approve');
        $role2->givePermissionTo('requests_sessions_set_session');
        $role2->givePermissionTo('requests_sessions_archive');
        $role2->givePermissionTo('request_session_close');
        $role2->givePermissionTo('requests_reports_moslh');
        $role2->givePermissionTo('requests_reports_incoming');
        $role2->givePermissionTo('requests_reports_outgoing');
        $role2->givePermissionTo('requests_reports_categories');
        $role2->givePermissionTo('settings_study_levels');
        $role2->givePermissionTo('settings_request_referral');
        $role2->givePermissionTo('settings_nationality_list');
        $role2->givePermissionTo('settings_cases_reasons');
        $role2->givePermissionTo('settings_cases_categories');
        $role2->givePermissionTo('settings_cases_close_status');
        $role2->givePermissionTo('settings_councils_locations');
        $role2->givePermissionTo('settings_cases_meeting_time');

        $role3 = Role::create([
            'name'          => 'المدير التنفيذي',
            'closed'        => 0,
            'dateadd'       => time(),
            'added_userid'  => 1,
            'is_deleted'    => 0
        ]);
        $role3->givePermissionTo('requests_attendance');
        $role3->givePermissionTo('waiting_review_requests');
        $role3->givePermissionTo('waiting_review_requests_delete');
        $role3->givePermissionTo('waiting_approved_requests');
        $role3->givePermissionTo('waiting_approved_requests_delete');
        $role3->givePermissionTo('waiting_approved_requests_approve');
        $role3->givePermissionTo('requests_sessions_delete');
        $role3->givePermissionTo('requests_sessions_set_session');
        $role3->givePermissionTo('requests_sessions_archive');
        $role3->givePermissionTo('request_session_close');
        $role3->givePermissionTo('requests_reports_moslh');
        $role3->givePermissionTo('requests_reports_incoming');
        $role3->givePermissionTo('requests_reports_outgoing');
        $role3->givePermissionTo('requests_reports_categories');
        $role3->givePermissionTo('settings_general');
        $role3->givePermissionTo('settings_study_levels');
        $role3->givePermissionTo('settings_request_referral');
        $role3->givePermissionTo('settings_nationality_list');
        $role3->givePermissionTo('settings_cases_reasons');
        $role3->givePermissionTo('settings_cases_categories');
        $role3->givePermissionTo('settings_cases_close_status');
        $role3->givePermissionTo('settings_councils_locations');
        $role3->givePermissionTo('settings_cases_meeting_time');

        $role4 = Role::create([
            'name'          => 'موظف',
            'closed'        => 0,
            'dateadd'       => time(),
            'added_userid'  => 1,
            'is_deleted'    => 0
        ]);
        $role4->givePermissionTo('requests_attendance');
        $role4->givePermissionTo('waiting_review_requests');
        $role4->givePermissionTo('waiting_approved_requests');
        $role4->givePermissionTo('waiting_approved_requests_approve');
        $role4->givePermissionTo('requests_sessions_set_session');
        $role4->givePermissionTo('requests_sessions_archive');
        $role4->givePermissionTo('request_session_close');
        $role4->givePermissionTo('settings_cases_meeting_time');

        $role5 = Role::create([
            'name'          => 'مصلح أسري',
            'closed'        => 0,
            'dateadd'       => time(),
            'added_userid'  => 1,
            'is_deleted'    => 0
        ]);
        $role6 = Role::create([
            'name'          => 'رئيس مجلس الإدارة',
            'closed'        => 0,
            'dateadd'       => time(),
            'added_userid'  => 1,
            'is_deleted'    => 0
        ]);

        $users = User::where('usergroup', 3)->get();
        foreach ($users as $user){
            if ($user->job_title_id == 1){
                $user->assignRole($role6);
            }elseif ($user->job_title_id == 2){
                $user->assignRole($role5);
            }elseif ($user->job_title_id == 3){
                $user->assignRole($role4);
            }elseif ($user->job_title_id == 4){
                $user->assignRole($role3);
            }elseif ($user->job_title_id == 5){
                $user->assignRole($role2);
            }elseif ($user->job_title_id == 6){
                $user->assignRole($role1);
            }
        }
    }
}
