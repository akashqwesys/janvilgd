<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\AttributeGroups;
use DataTables;

class AttributeGroupsController extends Controller {

    public function index() {
        $data['title'] = 'List-Attribute-Groups';
        return view('admin.attributeGroups.list', ["data" => $data]);
    }

    public function add() {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['category'] = $categories;
        $data['title'] = 'Add-Attribute-Groups';
        return view('admin.attributeGroups.add', ["data" => $data]);
    }

    public function save(Request $request) {        
        DB::table('attribute_groups')->insert([
            'name' => $request->name,
            'image_required' => $request->image_required,
            'field_type' => $request->field_type,
            'refCategory_id' => $request->refCategory_id,
            'is_required' => $request->is_required,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);

        activity($request, "updated", 'attribute-groups');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('attribute-groups');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('attribute_groups')->select('attribute_groups.*', 'categories.name as category_name')->leftJoin('categories', 'attribute_groups.refCategory_id', '=', 'categories.category_id')->orderBy('attribute_group_id', 'desc')->get();
//            $data = Sliders::latest()->orderBy('slider_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('image_required', function ($row) {
                                $image_required = '';
                                if ($row->image_required == 1) {
                                    $image_required = '<span class="badge badge-success">Required</span>';
                                }
                                if ($row->image_required == 0) {
                                    $image_required = '<span class="badge badge-danger">Not Required</span>';
                                }
                                return $image_required;
                            })
                            ->editColumn('field_type', function ($row) {
                                $field_type = '';
                                if ($row->field_type == 1) {
                                    $field_type = '<span class="badge badge-success">SELECT</span>';
                                }
                                if ($row->field_type == 0) {
                                    $field_type = '<span class="badge badge-danger">TEXT</span>';
                                }
                                return $field_type;
                            })
                            ->editColumn('is_required', function ($row) {
                                $is_required = '';
                                if ($row->is_required == 1) {
                                    $is_required = '<span class="badge badge-success">Required</span>';
                                }
                                if ($row->is_required == 0) {
                                    $is_required = '<span class="badge badge-danger">Not Required</span>';
                                }
                                return $is_required;
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

                                if ($row->is_active == 1) {
                                    $str = '<em class="icon ni ni-cross"></em>';
                                    $class = "btn-danger";
                                }
                                if ($row->is_active == 0) {
                                    $str = '<em class="icon ni ni-check-thick"></em>';
                                    $class = "btn-success";
                                }

                                $actionBtn = '<a href="/attribute-groups/edit/' . $row->attribute_group_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="attribute-groups" data-id="' . $row->attribute_group_id . '" data-table="attribute_groups" data-wherefield="attribute_group_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->attribute_group_id . '" data-status="' . $row->is_active . '" data-table="attribute_groups" data-wherefield="attribute_group_id" data-module="attribute-groups">' . $str . '</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['category'] = $categories;
        $result = DB::table('attribute_groups')->where('attribute_group_id', $id)->first();
        $data['title'] = 'Edit-Attribute-Groups';
        $data['result'] = $result;
        return view('admin.attributeGroups.edit', ["data" => $data]);
    }

    public function update(Request $request) {      
        DB::table('attribute_groups')->where('attribute_group_id', $request->id)->update([
            'name' => $request->name,
            'image_required' => $request->image_required,
            'field_type' => $request->field_type,
            'refCategory_id' => $request->refCategory_id,
            'is_required' => $request->is_required,           
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request, "updated", 'attribute-groups');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('attribute-groups');
    }
    public function delete(Request $request) {
        if (isset($_REQUEST['table_id'])) {
            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("yy-m-d h:i:s")
            ]);
            activity($request, "deleted", $_REQUEST['module']);
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
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
        if (isset($_REQUEST['table_id'])) {

            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
                'is_active' => $_REQUEST['status'],
                'date_updated' => date("yy-m-d h:i:s")
            ]);
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request, "updated", $_REQUEST['module']);
            return response()->json($data);
        }
    }

}
