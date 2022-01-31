<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Modules;
use DataTables;

class ModulesController extends Controller {

    public function index() {
        $data['title'] = 'List-Modules';
        return view('admin.modules.list', ["data" => $data]);
    }

    public function add() {
        $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('is_active',1)->where('is_deleted',0)->where('menu_level', '<>', 4)->get();
        $data['title'] = 'Add-Modules';
        $data['module'] = $module;
        return view('admin.modules.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $parent = DB::table('modules')->select('module_id', 'name', 'menu_level')->where('module_id', $request->parent_id)->first();
        $last_id = DB::table('modules')->select('module_id')->orderBy('module_id','desc')->pluck('module_id')->first();
        if ($parent) {
            if ($request->slug == null) {
                $slug = null;
            } else {
                $slug = clean_string($request->slug);
            }
            DB::table('modules')->insert([
                'module_id' => ($last_id + 1),
                'name' => $request->name,
                'icon' => $request->icon,
                'slug' => $slug,
                'parent_id' => $request->parent_id,
                'sort_order' => $request->sort_order,
                'menu_level' => $parent->menu_level + 1,
                'added_by' => $request->session()->get('loginId'),
                'is_active' => 1,
                'is_deleted' => 0,
                'date_added' => date("Y-m-d h:i:s"),
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            // $Id = DB::getPdo()->lastInsertId();
            activity($request,"inserted",'modules', ($last_id + 1));
            successOrErrorMessage("Data added Successfully", 'success');
        } else {
            successOrErrorMessage("Not a valid parent module", 'error');
        }
        return redirect('admin/modules');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Modules::select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->orderBy('module_id','desc')->get();
            return Datatables::of($data)
                // ->addIndexColumn()
                ->addColumn('index', '')
                ->editColumn('date_added', function ($row) {
                    return date_formate($row->date_added);
                })
                ->editColumn('is_active', function ($row) {
                    $active_inactive_button = '';
                    if ($row->is_active == 1) {
                        $active_inactive_button = '<span class="badge badge-success">Active</span>';
                    }
                    if ($row->is_active == 0) {
                        $active_inactive_button = '<span class="badge badge-danger">inActive</span>';
                    }
                    return $active_inactive_button;
                })
                ->editColumn('is_deleted', function ($row) {
                    $delete_button = '';
                    if ($row->is_deleted == 1) {
                        $delete_button = '<span class="badge badge-danger">Deleted</span>';
                    }
                    return $delete_button;
                })
                ->addColumn('action', function ($row) {
                    if($row->is_active==1){
                        $str='<em class="icon ni ni-cross"></em>';
                        $class="btn-danger";
                    }
                    if($row->is_active==0){
                        $str='<em class="icon ni ni-check-thick"></em>';
                        $class="btn-success";
                    }
                    $actionBtn = '<a href="/admin/modules/edit/' . $row->module_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="modules" data-id="' . $row->module_id . '" data-table="modules" data-wherefield="module_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->module_id . '" data-status="' . $row->is_active . '" data-table="modules" data-wherefield="module_id" data-module="modules">'.$str.'</button>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function edit($id) {
        $module = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('menu_level', '<>', 4)->get();
        $result = DB::table('modules')->select('module_id', 'name', 'icon', 'slug', 'parent_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'sort_order', 'menu_level')->where('module_id', $id)->first();
        $data['title'] = 'Edit-Modules';
        $data['result'] = $result;
        $data['module'] = $module;
        return view('admin.modules.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $parent = DB::table('modules')->select('module_id', 'name', 'menu_level')->where('module_id', $request->parent_id)->first();
        if ($parent) {
            DB::table('modules')->where('module_id', $request->id)->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'slug' => clean_string($request->slug),
                'menu_level' => $parent->menu_level + 1,
                'parent_id' => $request->parent_id,
                'sort_order' => $request->sort_order,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request,"updated",'modules',$request->id);
            successOrErrorMessage("Data updated Successfully", 'success');
        } else {
            successOrErrorMessage("Not a valid parent module", 'error');
        }
        return redirect('admin/modules');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {
            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module'],$request['table_id']);
            // $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            return response()->json($data);
        }
    }

    public function status(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_active' => $request['status'],
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            // $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$request['module'],$request['table_id']);
            return response()->json($data);
        }
    }
}

