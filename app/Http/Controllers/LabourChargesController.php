<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\LabourCharges;
use App\Models\Diamonds;
use DataTables;
use Elastic\Elasticsearch\ClientBuilder;

class LabourChargesController extends Controller {

    public function index() {
        $data['title'] = 'List-Labour-Charges';
        return view('admin.labourCharges.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Labour-Charges';
        return view('admin.labourCharges.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('labour_charges')->insert([
            'name' => $request->name,
            'amount' => $request->amount,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        ]);
        $Id = DB::getPdo()->lastInsertId();
        activity($request,"inserted",'labour-charges',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/labour-charges');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = LabourCharges::select('labour_charge_id', 'name', 'amount', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('labour_charge_id','desc')->get();
            return Datatables::of($data)
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

                                $actionBtn = '<a href="/admin/labour-charges/edit/' . $row->labour_charge_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="labour-charges" data-id="' . $row->labour_charge_id . '" data-table="labour_charges" data-wherefield="labour_charge_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->labour_charge_id . '" data-status="' . $row->is_active . '" data-table="labour_charges" data-wherefield="labour_charge_id" data-module="labour-charges">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('labour_charges')->select('labour_charge_id', 'name', 'amount', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('labour_charge_id', $id)->first();
        $data['title'] = 'Edit-Labour-Charges';
        $data['result'] = $result;
        return view('admin.labourCharges.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $ids = [];
        $cts = [];
        $total = [];
        $ppc = [];
        $labour_charge = LabourCharges::select('amount')->where('labour_charge_id',$request->id)->first();
        $charge = $labour_charge->amount-$request->amount;
        if($request->id == 1){
            $cat_id = DB::table('categories')->select('category_id')->where('category_type',1)->first();
            Diamonds::where('refCategory_id', $cat_id->category_id)->update(['total'=> DB::raw("total+($charge*expected_polish_cts)")]);
            $params = [
                'index' => 'diamonds',
                'size' => 10000,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => $cat_id->category_id]]
                            ]
                        ]
                    ]
                ]
            ];
            $response = $client->search($params);
            if (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {
                foreach ($response['hits']['hits'] as $v) {
                    $ids[] = $v['_id'];
                    $cts[] = $v['_source']['expected_polish_cts'];
                    $total[] = $v['_source']['total'];
                    // $ppc[] = $v['_source']['price_ct'];
                }
            }

        }
        if($request->id == 2){
            $cat_id = DB::table('categories')->select('category_id')->where('category_type', 2)->first();
            $res=Diamonds::where('refCategory_id', $cat_id->category_id)->update(['total'=> DB::raw("total+($charge*makable_cts)")]);
            $params = [
                'index' => 'diamonds',
                'size' => 10000,
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => $cat_id->category_id]]
                            ]
                        ]
                    ]
                ]
            ];
            $response = $client->search($params);
            if (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {
                foreach ($response['hits']['hits'] as $v) {
                    $ids[] = $v['_id'];
                    $cts[] = $v['_source']['makable_cts'];
                    $total[] = $v['_source']['total'];
                    // $ppc[] = $v['_source']['price_ct'];
                }
            }
        }

        if(count($ids)){
            $params = array();
            $params = ['body' => []];
            $j=1;
            for ($i = 0; $i < count($ids); $i++) {
                $total_price=$total[$i]+($cts[$i] * $charge);
                $batch_row=array();
                $batch_row['total'] = $total_price;
                $batch_row['price_ct'] = $total_price / $cts[$i];
                    $params["body"][] = [
                            "update" => [
                                "_index" => 'diamonds',
                                "_id" => $ids[$i],
                            ]
                        ];
                    $params["body"][] = [
                        "doc"=>$batch_row
                    ];
                    if ($j % 1000 == 0) {
                        $responses = $client->bulk($params);
                        $params = ['body' => []];
                        unset($responses);
                    }
                $j=$j+1;
            }
            // Send the last batch if it exists
            if (!empty($params['body'])) {
                $responses = $client->bulk($params);
            }
        }

        DB::table('labour_charges')->where('labour_charge_id', $request->id)->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'added_by' => $request->session()->get('loginId'),
            'date_updated' => date("Y-m-d H:i:s")
        ]);

        activity($request,"updated",'labour-charges',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/labour-charges');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            activity($request,"deleted",$request['module'],$request['table_id']);
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
