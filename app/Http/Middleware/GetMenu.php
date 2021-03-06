<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Modules;

class GetMenu {

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
            $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('is_active', 1)->where('is_deleted', 0)->get();

            if (!empty($module)) {
                $access_list=array();
                $menu_array = array();
                foreach ($module as $row_module) {
                    if ($row_module->parent_id == 0) {
                        $row_module->submenu = array();
                        array_push($menu_array, $row_module);
                    }
                }
                foreach ($menu_array as $row) {
                    foreach ($module as $row1) {
                        $i = 0;
                        foreach ($access_permission as $access_row) {
                            if ($access_row == $row1->module_id) {
                                $i = 1;
                            }
                        }
                        if ($i == 1) {
                            if ($row->module_id == $row1->parent_id) {
                                array_push($row->submenu, $row1);
                                array_push($access_list,$row1->module_id);
                            }
                        }
                    }
                }
                session()->put('access_list',$access_list);
            }
        }
        if (session()->get('user-type') == 'MASTER_ADMIN') {
            $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('is_active', 1)->where('is_deleted', 0)->orderByRaw('menu_level, sort_order asc')->get();

            if (!empty($module)) {
                $module = json_decode(json_encode($module), true);

                foreach ($module as $m) {
                    if ($m['menu_level'] == 1) {
                        $menu_array[$m['module_id']] = $m;
                    } else if ($m['menu_level'] == 2) {
                        $menu_array[$m['parent_id']]['sub'][$m['module_id']] = $m;
                    } else if ($m['menu_level'] == 3) {
                        $main_parent_id = find_parent_id($m['parent_id'],$module);
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

        // $columns = array_column($menu_array, 'sort_order');
        // array_multisort($columns, SORT_ASC, $menu_array);
        if (Session()->has('loginId')) {
            $request->session()->forget('menu');
            $request->session()->forget('module');
            $request->session()->forget('categories');
        }
        $request->session()->put('module', $module);
        $request->session()->put('menu', $menu_array);
         $request->session()->put('categories', $categories);

        return $next($request);
    }

}
function find_parent_id($id,$array) {
    foreach ($array as $a) {
        if($a['module_id'] == $id) {
            return $a['parent_id'];
        }
    }
}