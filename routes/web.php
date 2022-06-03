<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest', 'namespace' => 'Admin'], static function(){
    Route::get('/login', 'AuthController@login')->name('admin.login');
    Route::post('/post-login', 'AuthController@postLogin')->name('admin.postLogin');
    Route::get('/registration', 'AuthController@registration')->name('admin.register');
    Route::post('/post-registration', 'AuthController@postRegistration')->name('admin.postRegistration'); 
    Route::get('/password-reset', 'AuthController@password_reset')->name('admin.password.reset');
    Route::get('/dashboard', 'AuthController@dashboard'); 
    Route::get('/complete/{req_uuid}', 'RequestController@complete')->name('user.completeinfo');
    Route::any('/store/complete', 'RequestController@storeComplete')->name('admin.request.store.complete');
    Route::get('/message', 'RequestController@message')->name('message');

});

    Route::get('/ulogout', 'Admin\AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], static function(){

    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/sms/{id}/{reqtype}/{phone}', 'DashboardController@sms')->name('admin.sms');


    Route::group(['prefix' => 'zoom'], static function(){
        Route::get('/', 'ZoomController@index')->name('admin.zoom');
    });

    Route::group(['prefix' => 'add-court-request'], static function(){
        Route::get('/', 'RequestController@create')->name('admin.request.create');
        Route::post('/store', 'RequestController@store')->name('admin.request.store');
    });
    
     Route::post('/getreferral', 'RequestController@getreferral')->name('admin.request.getreferral');
     
     Route::group(['prefix' => 'requests-attendance'], static function(){
            Route::get('/', 'RequestController@attendance')->name('admin.request.attendance');
        });
         Route::get('/getattendance/{id}/{type}', 'RequestController@getattendance')->name('admin.request.getattendance');
            Route::any('/attendancefilter', 'RequestController@attendance_filter')->name('admin.request.attendance.filter');
            
    Route::group(['prefix' => 'waiting-request'], static function(){
        Route::get('/', 'RequestController@waiting')->name('admin.request.waiting');
        Route::get('/self', 'RequestController@selfwaiting')->name('admin.request.selfwaiting');

    });
        Route::any('/waiting-result', 'RequestController@filter')->name('admin.request.waiting.filter');
        Route::get('/request-view/{id}/{status}', 'RequestController@view')->name('admin.request.view');
        Route::get('/request-edit/{id}', 'RequestController@edit')->name('admin.request.edit');
        Route::get('/request-delete/{id}', 'RequestController@delete')->name('admin.request.delete');
        Route::post('/request-edit-post', 'RequestController@editpost')->name('admin.request.edit.post');
        Route::post('/close', 'RequestController@close')->name('admin.request.close');
        
    Route::group(['prefix' => 'waiting-approve-request'], static function(){
        Route::get('/', 'RequestController@waiting_approve')->name('admin.request.waiting.approve');
    });
        Route::post('/request-approve', 'RequestController@approve')->name('admin.request.approve');

    Route::group(['prefix' => 'request-sessions'], static function(){
        Route::get('/', 'RequestSessionController@index')->name('admin.request.session');
    });
        Route::post('/sf', 'RequestSessionController@filter')->name('admin.request.session.filter');

    Route::group(['prefix' => 'request-archive'], static function(){
        Route::get('/', 'ArchiveController@request_archive')->name('admin.archive.request');
    });
        Route::any('/af', 'ArchiveController@filter')->name('admin.archive.request.filter');
        Route::any('/archive/search', 'ArchiveController@search')->name('admin.archive.request.search');
        Route::get('/session/approve/{id}', 'RequestSessionController@session_approve')->name('admin.session.approve');
        Route::post('/approve_post', 'RequestSessionController@session_approve_post')->name('admin.session.approve.post');
        Route::post('/gettime', 'RequestSessionController@get_time')->name('gettime');
        Route::get('/gettime', 'RequestSessionController@management')->name('admin.session.management');

    Route::group(['prefix' => 'sessions-archive'], static function(){
        Route::get('/', 'ArchiveController@session_archive')->name('admin.archive.sessions');
    });

    Route::group(['prefix' => 'reports'], static function(){

        Route::group(['prefix' => 'mslh'], static function(){
            Route::get('/', 'ReportController@mslh')->name('admin.report.mslh');
        });

        Route::group(['prefix' => 'incoming'], static function(){
            Route::get('/', 'ReportController@incoming')->name('admin.report.incoming');
        });

        Route::group(['prefix' => 'outgoing'], static function(){
            Route::get('/', 'ReportController@outgoing')->name('admin.report.outgoing');
        });

        Route::group(['prefix' => 'categories'], static function(){
            Route::get('/', 'ReportController@categories')->name('admin.report.categories');
        });
    });

    Route::group(['prefix' => 'users'], static function(){
        Route::get('/', 'UserController@index')->name('admin.users');
        Route::get('/create', 'UserController@create')->name('admin.users.create');
        Route::post('/store', 'UserController@store')->name('admin.users.store');
        Route::get('/delete/{id}', 'UserController@delete')->name('admin.users.delete');
        Route::get('/close/{id}', 'UserController@close')->name('admin.users.close');
        Route::get('/active/{id}', 'UserController@active')->name('admin.users.active');
        Route::get('/edit/{id}', 'UserController@edit')->name('admin.users.edit');
        Route::post('/update/{userid}', 'UserController@update')->name('admin.users.update');
        Route::get('/mslh', 'UserController@mslh')->name('admin.users.mslh');
        Route::get('/staff', 'UserController@staff')->name('admin.users.staff');
        Route::get('/staff/create', 'UserController@staff_create')->name('admin.users.staff.create');
        Route::get('/staff/edit/{id}', 'UserController@staff_edit')->name('admin.users.staff.edit');
        Route::get('/admins', 'UserController@admins')->name('admin.users.admins');
    });

    Route::group(['prefix' => 'settings'], static function (){
        Route::get('/', 'SettingController@index')->name('admin.settings');
        Route::post('/update', 'SettingController@update')->name('admin.settings.update');

        Route::group(['prefix' => 'study-levels'], static function (){
            Route::get('/', 'StudyController@index')->name('admin.settings.study');
            Route::get('/create', 'StudyController@create')->name('admin.settings.study.create');
            Route::post('/store', 'StudyController@store')->name('admin.settings.study.store');
            Route::get('/delete/{id}', 'StudyController@delete')->name('admin.settings.study.delete');
            Route::get('/edit/{id}', 'StudyController@edit')->name('admin.settings.study.edit');
            Route::post('/update/{id}', 'StudyController@update')->name('admin.settings.study.update');
        });

        Route::group(['prefix' => 'jobs'], static function (){
            Route::get('/', 'JobController@index')->name('admin.settings.jobs');
            Route::get('/create', 'JobController@create')->name('admin.settings.jobs.create');
            Route::post('/store', 'JobController@store')->name('admin.settings.jobs.store');
            Route::get('/delete/{id}', 'JobController@delete')->name('admin.settings.jobs.delete');
            Route::get('/edit/{id}', 'JobController@edit')->name('admin.settings.jobs.edit');
            Route::post('/update', 'JobController@update')->name('admin.settings.jobs.update');
        });

        Route::group(['prefix' => 'referral'], static function (){
            Route::get('/', 'ReferralController@index')->name('admin.settings.referral');
            Route::get('/create', 'ReferralController@create')->name('admin.settings.referral.create');
            Route::post('/store', 'ReferralController@store')->name('admin.settings.referral.store');
            Route::get('/delete/{id}', 'ReferralController@delete')->name('admin.settings.referral.delete');
            Route::get('/edit/{id}', 'ReferralController@edit')->name('admin.settings.referral.edit');
            Route::post('/update/{id}', 'ReferralController@update')->name('admin.settings.referral.update');
        });

        Route::group(['prefix' => 'nationality'], static function (){
            Route::get('/', 'NationalityController@index')->name('admin.settings.nationality');
            Route::get('/create', 'NationalityController@create')->name('admin.settings.nationality.create');
            Route::post('/store', 'NationalityController@store')->name('admin.settings.nationality.store');
            Route::get('/delete/{id}', 'NationalityController@delete')->name('admin.settings.nationality.delete');
            Route::get('/edit/{id}', 'NationalityController@edit')->name('admin.settings.nationality.edit');
            Route::post('/update/{id}', 'NationalityController@update')->name('admin.settings.nationality.update');
        });

        Route::group(['prefix' => 'cases-reasons'], static function (){
            Route::get('/', 'ReasonController@index')->name('admin.settings.reasons');
            Route::get('/create', 'ReasonController@create')->name('admin.settings.reasons.create');
            Route::post('/store', 'ReasonController@store')->name('admin.settings.reasons.store');
            Route::get('/delete/{id}', 'ReasonController@delete')->name('admin.settings.reasons.delete');
            Route::get('/edit/{id}', 'ReasonController@edit')->name('admin.settings.reasons.edit');
            Route::post('/update/{id}', 'ReasonController@update')->name('admin.settings.reasons.update');
        });

        Route::group(['prefix' => 'cases-categories'], static function (){
            Route::get('/', 'CategoryController@index')->name('admin.settings.categories');
            Route::get('/create', 'CategoryController@create')->name('admin.settings.categories.create');
            Route::post('/store', 'CategoryController@store')->name('admin.settings.categories.store');
            Route::get('/delete/{id}', 'CategoryController@delete')->name('admin.settings.categories.delete');
            Route::get('/edit/{id}', 'CategoryController@edit')->name('admin.settings.categories.edit');
            Route::post('/update/{id}', 'CategoryController@update')->name('admin.settings.categories.update');
        });

        Route::group(['prefix' => 'cases-close-status'], static function (){
            Route::get('/', 'CasesCloseController@index')->name('admin.settings.close');
            Route::get('/create', 'CasesCloseController@create')->name('admin.settings.close.create');
            Route::post('/store', 'CasesCloseController@store')->name('admin.settings.close.store');
            Route::get('/delete/{id}', 'CasesCloseController@delete')->name('admin.settings.close.delete');
            Route::get('/edit/{id}', 'CasesCloseController@edit')->name('admin.settings.close.edit');
            Route::post('/update/{id}', 'CasesCloseController@update')->name('admin.settings.close.update');
            Route::post('/getreward', 'CasesCloseController@getreward')->name('admin.settings.close.getreward');
        });
            
        Route::group(['prefix' => 'councils-locations'], static function (){
            Route::get('/', 'CouncilsController@index')->name('admin.settings.councils');
            Route::get('/create', 'CouncilsController@create')->name('admin.settings.councils.create');
            Route::post('/store', 'CouncilsController@store')->name('admin.settings.councils.store');
            Route::get('/delete/{id}', 'CouncilsController@delete')->name('admin.settings.councils.delete');
            Route::get('/edit/{id}', 'CouncilsController@edit')->name('admin.settings.councils.edit');
            Route::post('/update/{id}', 'CouncilsController@update')->name('admin.settings.councils.update');
        });

        Route::group(['prefix' => 'cases-meeting-time'], static function (){
            Route::get('/', 'MeetingTimeController@index')->name('admin.settings.meeting');
            Route::get('/create', 'MeetingTimeController@create')->name('admin.settings.meeting.create');
            Route::post('/store', 'MeetingTimeController@store')->name('admin.settings.meeting.store');
            Route::get('/delete/{id}', 'MeetingTimeController@delete')->name('admin.settings.meeting.delete');
            Route::get('/edit/{id}', 'MeetingTimeController@edit')->name('admin.settings.meeting.edit');
            Route::post('/update/{id}', 'MeetingTimeController@update')->name('admin.settings.meeting.update');
        });
    });
});

