<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;
use App\Models\User;
use DB;
class CustomAuthController extends Controller {

    public function home() {
        $data['title']='Home';
        return view('admin.home',["data"=>$data]);
    }

    public function accessDenied() {
        $data['title']='Access-Denied';
        return view('admin.accessDenied',["data"=>$data]);
    }

    public function auth_admin_customer($token)
    {
        $user = DB::table('customer')->select('customer_id')->where('email', decrypt($token, false))->first();
        Auth::loginUsingId($user->customer_id);
        return redirect('/customer/dashboard');
    }

    public function loginView() {
        if(Session()->has('loginId')){
            return redirect('/admin/dashboard');
        }
        $data['title']='Login';
        return view('admin.login',["data"=>$data]);
    }
    public function userLogin(Request $request) {
        $password=md5($request->password);
        $pass=hash('sha256', $password);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user=DB::table('users')->select('id', 'name', 'mobile', 'email', 'user_type', 'password')->where('email','=',$request->email)->first();
        if($user){
            if($pass==$user->password){

                $agent = new \Jenssegers\Agent\Agent;
                $logintype='web';
                if($agent->isMobile()){
                    $logintype="mobile";
                }
                if($agent->isDesktop()){
                    $logintype="web";
                }

                DB::table('users')->where('id', $user->id)->update([
                    'last_login_type' => $logintype,
                    'last_login_date_time' => date("Y-m-d h:i:s")
                ]);
                Auth::loginUsingId($user->id);
                $request->session()->put('loginId',$user->id);
                $request->session()->put('user-type',$user->user_type);
                return redirect('admin/dashboard');
            }else{
                return back()->with('fail','Password not matches');
            }
        }else{
            return back()->with('fail','This email is not exist');
        }
    }

    public function dashboard() {
        $data['title']= config("constants.ADMIN_DASHBOARD_TITLE");
        return view('admin.dashboard',["data"=>$data]);
    }

    public function logout() {
        Session::flush();
        return redirect('/admin/login');
    }
}
