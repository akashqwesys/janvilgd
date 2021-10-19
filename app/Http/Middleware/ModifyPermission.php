<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\UserRoles;

class ModifyPermission {

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
            $user_roles = DB::table('user_role')->where('is_active', 1)->where('is_deleted', 0)->where('user_role_id', $user_role_id->role_id)->first();

            if (empty($user_roles)) {
                successOrErrorMessage("Access denied for this module", 'error');
                return redirect('access-denied');
            }

            if (!empty(session()->get('access_list'))) {
                $access_permission = session()->get('access_list');
                $access_module = DB::table('modules')->where('is_active', 1)->where('is_deleted', 0)->whereIn('module_id', $access_permission)->get();
            }
            $modify_permission = json_decode($user_roles->modify_permission);
            $module = DB::table('modules')->where('is_active', 1)->where('is_deleted', 0)->whereIn('module_id', $modify_permission)->get();
            $main_url = $request->fullUrlWithoutQuery('unwanted_parameter');
            $args = explode('/', $main_url);
            if(isset($args[4])){
                if(strpos($args[4],'?')){
                    $args[4] = substr($args[4], 0, strpos($args[4], '?'));
                }                
            }                      
            if (!empty($user_roles) && !empty($module)) {
                $i = 0;
                foreach ($module as $row) {
                    if (isset($args[4])) {                       
                        if ($row->slug . '/add' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }
                        if ($row->slug . '/save' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }
                        if ($row->slug . '/update' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }
                        if ($row->slug . '/edit' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }
                        if ($row->slug . '/delete' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }
                        if ($row->slug . '/status' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }
                        if ($row->slug . '/list' === $args[3] . '/' . $args[4]) {
                            $i = 1;
                        }                        
                    }
                }
                if (!empty(session()->get('access_list'))) {
                    if (!empty($access_module)) {
                        foreach ($access_module as $access_row) {
                            if (!isset($args[4]) && $access_row->slug==$args[3]) {
                                $i = 1;
                            }
                            if (isset($args[4]) && $access_row->slug . '/list' === $args[3] . '/' . $args[4]) {
                                $i = 1;
                            }
                        }
                    }
                }                
                if ($i == 0) {
                    successOrErrorMessage("Access denied for this module", 'error');
                    return redirect('access-denied');
                }
            }
        }

        return $next($request);
    }

}
