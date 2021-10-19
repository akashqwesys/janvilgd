<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
    
    public function loginView() {
        $data['title']='Login';         
        return view('admin.login',["data"=>$data]);
    }
    
    public function userLogin(Request $request) {        
        
        $user=DB::table('users')->get();
        echo '<pre>';print_r($user);
        
        $password=md5('123');
        $pass=hash('sha256', $password);
//        echo $pass;die;
        DB::table('users')->update([
            'password' =>$pass 
        ]);
        
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user=DB::table('users')->where('email','=',$request->email)->first();  
        if($user){
            if($request->password==$user->password){
                $request->session()->put('loginId',$user->id);
                $request->session()->put('user-type',$user->user_type);
                return redirect('dashboard');
            }else{
                return back()->with('fail','Password not matches');
            }
        }else{
            return back()->with('fail','This email is not exist');
        }
    }
    public function dashboard() {         
        $data['title']='Dashboard';         
        return view('admin.dashboard',["data"=>$data]);                      
    }
    public function logout() {
        Session::flush();
        return Redirect('login');
    }
}
