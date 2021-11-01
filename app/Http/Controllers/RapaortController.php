<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Rapaort;
use DataTables;
use Excel;
use App\Imports\DiamondsImport;

class RapaortController extends Controller {

    public function index() {
        $data['title'] = 'List-Rapaport';
        return view('admin.rapaport.list', ["data" => $data]);
    }

    public function update_price(Request $request) {
        if (!empty(session('update_data_price'))) {
            $data_array = array();
            foreach (session('update_data_price') as $row) {
                $diamond_ids = DB::table('diamonds_attributes')->select('diamonds_attributes.*', 'attributes.name as at_name', 'attribute_groups.name as ag_name')
                        ->leftJoin('attributes', 'diamonds_attributes.refAttribute_id', '=', 'attributes.attribute_id')
                        ->leftJoin('attribute_groups', 'diamonds_attributes.refAttribute_group_id', '=', 'attribute_groups.attribute_group_id')
                        ->leftJoin('diamonds', 'diamonds_attributes.refDiamond_id', '=', 'diamonds.diamond_id')
                        ->where(
                                [['attribute_groups.name', '=', 'COLOR'],
                                    ['attributes.name', '=', $row['color']]]
                        )
                        ->orWhere(
                                [['attribute_groups.name', '=', 'CLARITY'],
                                    ['attributes.name', '=', $row['clarity']]]
                        )
                        ->orWhere(
                                [['attribute_groups.name', '=', 'SHAPE'],
                                    ['attributes.name', '=', $row['shape']]]
                        )
                        ->get();

                if (!empty($diamond_ids)) {

                    $final_d = [];
                    $final_d2 = [];
                    $k = 0;
                    $diamond_id_array = array();
                    foreach ($diamond_ids as $v_row) {
                        array_push($diamond_id_array, $v_row->diamond_id);
                    }
                    $diamond_id_array = array_unique($diamond_id_array);

                    $final_d[0] = $diamond_ids[0];

                    foreach ($diamond_ids as $v_row) {
                        foreach ($diamond_id_array as $dim_row) {
                            if ($dim_row == $v_row->diamond_id) {
                                $i = 0;
                                $v_row->{$v_row->ag_name} = $v_row->name;
                                if (!empty($final_d)) {
                                    foreach ($final_d as $f_row) {
                                        if ($f_row->diamond_id == $dim_row) {
                                            $f_row->{$v_row->ag_name} = $v_row->name;
                                            $i = 1;
                                        }
                                    }
                                }
                                if ($i == 0) {
                                    array_push($final_d, $v_row);
                                }
                            }
                        }
                    }
                    dd($final_d);
                }
            }

//            print_r($data_array);
            die;
        }
    }

    public function fileImport(Request $request) {
        $res = Excel::toArray(new DiamondsImport, request()->file('file'));
        $rapa_type = DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->first();
        $update_price = array();
        if (!empty($res)) {
            if ($rapa_type->rapaport_category == 1) {
                foreach ($res[0] as $row) {
                    $data_array = [
                        'shape' => $row['shape'],
                        'clarity' => $row['clarity'],
                        'color' => $row['color'],
                        'from_range' => $row['from'],
                        'to_range' => $row['to'],
                        'rapaport_price' => $row['rapa']
                    ];
                    $data_array_1 = [
                        'date_updated' => date("Y-m-d h:i:s")
                    ];
                    DB::table('rapaport')->insert($data_array);
                    DB::table('rapaport_type')->where('rapaport_category', $request->rapaport_type_id)->update($data_array_1);
                    array_push($update_price, $row);
                }
            }
            if ($rapa_type->rapaport_category == 2) {
                foreach ($res[0] as $row) {
                    $data_array = [
                        'name' => $name,
                        'shape' => $row['shape'],
                        'clarity' => $row['clarity'],
                        'color' => $row['color'],
                        'from_range' => $row['from'],
                        'to_range' => $row['to'],
                        'rapaport_price' => $row['rapa']
                    ];
                    $data_array_1 = [
                        'date_updated' => date("Y-m-d h:i:s")
                    ];
                    DB::table('rapaport')->insert($data_array);
                    DB::table('rapaport_type')->where('rapaport_category', $request->rapaport_type_id)->update($data_array_1);
                    array_push($update_price, $row);
                }
            }
        }
        $request->session()->put('update_data_price', $update_price);
        activity($request, "inserted", 'rapaport');
        successOrErrorMessage("Data added Successfully", 'success');
        $request->session()->put("request_check", 1);
        return redirect('admin/rapaport');
    }

    public function addExcel() {
        $rapa_type = DB::table('rapaport_type')->get();
        $data['rapa_type'] = $rapa_type;
        $data['title'] = 'Add-Rapaport';
        return view('admin.rapaport.import', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Rapaport-CSV-TYPE';
        return view('admin.rapaport.add', ["data" => $data]);
    }

    public function save(Request $request) {
        DB::table('rapaport_type')->insert([
            'name' => $request->name,
            'rapaport_category' => $request->rapaport_category,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);

        activity($request, "inserted", 'rapaport');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/rapaport');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('rapaport_type')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('date_updated', function ($row) {
                                return date_formate($row->date_added);
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('rapaport_type')->where('rapaport_type_id', $id)->first();
        $data['title'] = 'Edit-Rapaport-CSV-TYPE';
        $data['result'] = $result;
        return view('admin.rapaport.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('rapaport_type')->where('rapaport_type_id', $request->id)->update([
            'name' => $request->name,
            'rapaport_category' => $request->rapaport_category,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request, "updated", 'rapaport');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/rapaport');
    }

}
