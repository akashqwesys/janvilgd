<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Taxes;
use DataTables;

class TaxesController extends Controller {

    public function index() {
        $data['title'] = 'List-Taxes';
        return view('admin.taxes.list', ["data" => $data]);
    }

    public function add() {
        $city = DB::table('city')->select('city_id', 'name', 'refState_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $country = DB::table('country')->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['city'] = $city;
        $data['state'] = $state;
        $data['country'] = $country;
        $data['title'] = 'Add-Taxes';
        return view('admin.taxes.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('taxes')->insert([
            'name' => $request->name,
            'amount' => $request->amount,
            'refCity_id' => $request->refCity_id,
            'refState_id' => $request->refState_id,
            'refCountry_id' => $request->refCountry_id,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        ]);
        $Id = DB::getPdo()->lastInsertId();
        activity($request,"inserted",'taxes',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/taxes');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('taxes')->select('taxes.*','state.name as state_name','city.name as city_name','country.name as country_name')->leftJoin('city', 'taxes.refCity_id', '=', 'city.city_id')->leftJoin('state', 'taxes.refState_id', '=', 'state.state_id')->leftJoin('country', 'taxes.refCountry_id', '=', 'country.country_id')->orderBy('tax_id','desc')->get();
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

                                $actionBtn = '<a href="/admin/taxes/edit/' . $row->tax_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="taxes" data-id="' . $row->tax_id . '" data-table="taxes" data-wherefield="tax_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->tax_id . '" data-status="' . $row->is_active . '" data-table="taxes" data-wherefield="tax_id" data-module="taxes">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->rawColumns(['action'])
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $city = DB::table('city')->select('city_id', 'name', 'refState_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $country = DB::table('country')->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['city'] = $city;
        $data['state'] = $state;
        $data['country'] = $country;

        $result = DB::table('taxes')->select('tax_id', 'name', 'amount', 'refCity_id', 'refState_id', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('tax_id', $id)->first();
        $data['title'] = 'Edit-Taxes';
        $data['result'] = $result;
        return view('admin.taxes.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('taxes')->where('tax_id', $request->id)->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'refCity_id' => $request->refCity_id,
            'refState_id' => $request->refState_id,
            'refCountry_id' => $request->refCountry_id,
            'date_updated' => date("Y-m-d H:i:s")
        ]);
        activity($request,"updated",'taxes',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/taxes');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
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
                'date_updated' => date("Y-m-d H:i:s")
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

