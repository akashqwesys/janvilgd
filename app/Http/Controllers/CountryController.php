<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Country;
use DataTables;

class CountryController extends Controller {

    public function index() {
        $data['title'] = 'List-Country';
        return view('admin.country.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Country';
        return view('admin.country.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('country')->insert([
            'name' => $request->name,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);

        activity($request,"inserted",'country');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/country');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Country::select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('country_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                    ->editColumn('date_added', function ($row) {                                
                                return date_formate($row->date_added);
                            })
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

                                $actionBtn = '<a href="/admin/country/edit/' . $row->country_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="country" data-id="' . $row->country_id . '" data-table="country" data-wherefield="country_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->country_id . '" data-status="' . $row->is_active . '" data-table="country" data-wherefield="country_id" data-module="country">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->rawColumns(['action'])
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('country')->where('country_id', $id)->first();
        $data['title'] = 'Edit-Country';
        $data['result'] = $result;
        return view('admin.country.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('country')->where('country_id', $request->id)->update([
            'name' => $request->name,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request,"updated",'country');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/country');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
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
                'date_updated' => date("Y-m-d h:i:s")
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

