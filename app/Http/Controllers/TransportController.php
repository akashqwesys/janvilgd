<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Transport;
use DataTables;

class TransportController extends Controller {

    public function index() {
        $data['title'] = 'List-Transport';
        return view('admin.transport.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Transport';
        return view('admin.transport.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('transport')->insert([
            'name' => $request->name,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        $Id = DB::getPdo()->lastInsertId();
        activity($request,"inserted",'transport',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/transport');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Transport::select('transport_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('transport_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
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
                                $actionBtn = '<a href="/admin/transport/edit/' . $row->transport_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="transport" data-id="' . $row->transport_id . '" data-table="transport" data-wherefield="transport_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->transport_id . '" data-status="' . $row->is_active . '" data-table="transport" data-wherefield="transport_id" data-module="transport">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('transport')->select('transport_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('transport_id', $id)->first();
        $data['title'] = 'Edit-Transport';
        $data['result'] = $result;
        return view('admin.transport.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('transport')->where('transport_id', $request->id)->update([
            'name' => $request->name,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request,"updated",'transport',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/transport');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module'],$request['table_id']);
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
            activity($request,"updated",$request['module'],$request['table_id']);
            return response()->json($data);
        }
    }
}
