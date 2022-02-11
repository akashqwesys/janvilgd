<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;
use App\Models\User;
use DB;
class CustomAuthController extends Controller {

    public function home()
    {
        $data['title']='Home';
        return view('admin.home',["data"=>$data]);
    }

    public function accessDenied()
    {
        $data['title']='Access-Denied';
        return view('admin.accessDenied',["data"=>$data]);
    }

    public function auth_admin_customer(Request $request, $token)
    {
        $user = DB::table('customer')->select('customer_id')->where('email', decrypt($token, false))->first();
        Auth::loginUsingId($user->customer_id);
        if ($request->redirect) {
            return redirect($request->redirect);
        } else {
            return redirect('/customer/search-diamonds/polish-diamonds');
        }
    }

    public function loginView()
    {
        if(Session()->has('loginId')){
            return redirect('/admin/dashboard/inventory');
        }
        $data['title']='Login';
        return view('admin.login', ["data"=>$data]);
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = DB::table('users')->select('id', 'name', 'mobile', 'email', 'user_type', 'password', 'role_id')->where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $agent = new \Jenssegers\Agent\Agent;
                $logintype = 'web';
                if ($agent->isMobile()) {
                    $logintype = "mobile";
                }
                if ($agent->isDesktop()) {
                    $logintype = "web";
                }

                DB::table('users')->where('id', $user->id)->update([
                    'last_login_type' => $logintype,
                    'last_login_date_time' => date("Y-m-d H:i:s")
                ]);
                // Auth::loginUsingId($user->id);
                $request->session()->put('loginId', $user->id);
                $request->session()->put('user-type', $user->user_type);
                $request->session()->put('user-role', $user->role_id);
                $request->session()->put('user_email', $user->email);
                $request->session()->put('user_fullname', $user->name);

                $this->getLeftMenu($request);
                if ($user->user_type == 'MASTER_ADMIN') {
                    return redirect('admin/dashboard/inventory');
                } else {
                    return redirect('admin/employee-dashboard');
                }
            } else {
                return back()->with('fail', 'Password does not matched');
            }
        } else {
            return back()->with('fail', 'User does not exist');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin/login');
    }

    public function getLeftMenu(Request $request)
    {
        if (session()->get('user-type') != 'MASTER_ADMIN') {
            $user_id = session()->get('loginId');
            $user_role_id =  DB::table('users')->select('role_id')->where('id', $user_id)->first();
            $user_roles = DB::table('user_role')->select('user_role_id', 'name', 'access_permission', 'modify_permission', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->where('user_role_id', $user_role_id->role_id)->first();

            if (empty($user_roles)) {
                successOrErrorMessage("Access denied for this module", 'error');
                return redirect('access-denied');
            }

            $access_permission = json_decode($user_roles->access_permission);

            $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('is_active', 1)->where('is_deleted', 0)->orderByRaw('menu_level, sort_order asc')->get();

            if (!empty($module)) {
                $module = json_decode(json_encode($module), true);

                $all_levels = [];
                foreach ($access_permission as $v) {
                    $level_2 = find_parent_id($v, $module);
                    $level_3 = find_parent_id($level_2, $module);
                    $level_4 = find_parent_id($level_3, $module);
                    $all_levels[] = $v;
                    $all_levels[] = $level_2;
                    $all_levels[] = $level_3;
                    $all_levels[] = $level_4;
                }

                foreach ($module as $m) {
                    if (!in_array($m['module_id'], $all_levels)) {
                        continue;
                    }
                    if ($m['menu_level'] == 1) {
                        $menu_array[$m['module_id']] = $m;
                    } else if ($m['menu_level'] == 2) {
                        $menu_array[$m['parent_id']]['sub'][$m['module_id']] = $m;
                    } else if ($m['menu_level'] == 3) {
                        $main_parent_id = find_parent_id($m['parent_id'], $module);
                        $menu_array[$main_parent_id]['sub'][$m['parent_id']]['sub'][$m['module_id']] = $m;
                    } else {
                        $parent_parent_id = find_parent_id($m['parent_id'], $module);
                        $main_parent_id = find_parent_id($parent_parent_id, $module);
                        $menu_array[$main_parent_id]['sub'][$parent_parent_id]['sub'][$m['parent_id']]['sub'][$m['module_id']] = $m;
                    }
                }
            }
        }
        else if (session()->get('user-type') == 'MASTER_ADMIN') {
            $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('is_active', 1)->where('is_deleted', 0)->orderByRaw('menu_level, sort_order asc')->get();

            if (!empty($module)) {
                $module = json_decode(json_encode($module), true);

                foreach ($module as $m) {
                    if ($m['menu_level'] == 1) {
                        $menu_array[$m['module_id']] = $m;
                    } else if ($m['menu_level'] == 2) {
                        $menu_array[$m['parent_id']]['sub'][$m['module_id']] = $m;
                    } else if ($m['menu_level'] == 3) {
                        $main_parent_id = find_parent_id($m['parent_id'], $module);
                        $menu_array[$main_parent_id]['sub'][$m['parent_id']]['sub'][$m['module_id']] = $m;
                    } else {
                        $parent_parent_id = find_parent_id($m['parent_id'], $module);
                        $main_parent_id = find_parent_id($parent_parent_id, $module);
                        $menu_array[$main_parent_id]['sub'][$parent_parent_id]['sub'][$m['parent_id']]['sub'][$m['module_id']] = $m;
                    }
                }
            }
        }

        $categories = DB::table('categories')->select('name', 'category_id', 'slug')->get();

        $request->session()->put('module', $module);
        $request->session()->put('menu', $menu_array);
        $request->session()->put('categories', $categories);
    }
}

function find_parent_id($id, $array)
{
    foreach ($array as $a) {
        if ($a['module_id'] == $id) {
            return $a['parent_id'];
        }
    }
}