<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\UserRoles;

class AccessPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (session()->get('user-type') != 'MASTER_ADMIN') {

            $user_id = session()->get('loginId');
            $user_role_id = DB::table('users')->select('role_id')->where('id', $user_id)->first();
            $user_roles = DB::table('user_role')->select('user_role_id', 'name', 'access_permission', 'modify_permission', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->where('user_role_id', $user_role_id->role_id)->first();

            if(empty($user_roles)){
                successOrErrorMessage("Access denied for this module", 'error');
                return redirect('access-denied');
            }

            $access_permission = json_decode($user_roles->access_permission);
            $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->whereIn('module_id', $access_permission)->get();
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $args = explode('/', $url);

            if (!empty($user_roles) && !empty($module)) {
                $i=0;
                $access_list=array();
                foreach ($module as $row) {
                    if ($row->slug == $args[3]) {
                        $i=1;
                    }
                }
                if($i==0){
                    successOrErrorMessage("Access denied for this module", 'error');
                    return redirect('access-denied');
                }
            }
        }
        return $next($request);
    }
}
