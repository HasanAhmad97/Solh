<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\DB;
  
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function login()
    {
        return view('backend.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('backend.register');
    }    
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = User::where('email', $request->get('email'))->where('password', md5($request->get('password')))->first();
        // $credentials = $request->only('email', 'password');
        if ($credentials) {
            Auth::login($credentials);

            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        
        $meetings = DB::select(DB::raw("select users.name as moslh_name,moslh_session_userid,moslh_extra_userid,moslh_extra_second_userid, sessionid,husband_present_date,wife_present_date, moslh_present_date, husband_name,wife_name,session_date_end, session_start_time,session_end_time,session_date , councils_meeting_location.council_id,room_code,level_code,meeting_location,councils_meeting_location.reqid from councils_meeting_location LEFT JOIN request_sessions on request_sessions.is_deleted = 0 and request_sessions.council_id = councils_meeting_location.council_id and request_sessions.session_date < " . time() . " and request_sessions.session_date_end > " . time() . " Left JOIN users on request_sessions.moslh_userid = users.userid lEFT join requests_info ON requests_info.reqid = request_sessions.reqid order by order_level asc"));
            
        if(Auth::check()){
        return view('backend.index', compact('meetings'));
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' =>  md5($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
      public function password_reset(){
        return view('backend.password-reset');
    }
}