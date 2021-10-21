<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\City;
use DataTables;

class CityController extends Controller {

    public function index() {
        $data['title'] = 'List-City';
        return view('admin.city.list', ["data" => $data]);
    }

    public function add() {
        $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['state'] = $state;
        $data['title'] = 'Add-City';
        return view('admin.city.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('city')->insert([
            'name' => $request->name,
            'refState_id' => $request->refState_id,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);

        activity($request,"inserted",'city');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('city');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('city')->select('city.*','state.name as state_name')->leftJoin('state', 'city.refState_id', '=', 'state.state_id')->orderBy('city_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('is_active', function ($row) {
                                $active_inactive_button='';
                                if($row->is_active==1){
                                    $active_inactive_button='<span class="badge badge-success">Active</span>';
                                }
                                if($row->is_active==0){
                                    $active_inactive_button='<span class="badge badge-danger">inActive</span>';
                                }
                                return $active_inactive_button;
                            })
                            ->editColumn('is_deleted', function ($row) {
                                $delete_button='';
                                if($row->is_deleted==1){
                                    $delete_button='<span class="badge badge-danger">Deleted</span>';
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

                                $actionBtn = '<a href="/city/edit/' . $row->city_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="city" data-id="' . $row->city_id . '" data-table="city" data-wherefield="city_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->city_id . '" data-status="' . $row->is_active . '" data-table="city" data-wherefield="city_id" data-module="city">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->rawColumns(['action'])
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $result = DB::table('city')->where('city_id', $id)->first();
        $data['title'] = 'Edit-City';
        $data['result'] = $result;
        $data['state'] = $state;
        return view('admin.city.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('city')->where('city_id', $request->id)->update([
            'name' => $request->name,
            'refState_id' => $request->refState_id,
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"updated",'city');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('city');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("yy-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module']);
//            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
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
                'date_updated' => date("yy-m-d h:i:s")
            ]);
//            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$request['module']);
            return response()->json($data);
        }
    }
}
