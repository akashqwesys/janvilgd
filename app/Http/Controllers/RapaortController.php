<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Rapaport;
use App\Models\Diamonds;
use DataTables;
use Excel;
use Batch;
use App\Imports\RapaportImport;
use App\Http\Controllers\API\DiamondController as APIDiamond;

class RapaortController extends Controller
{

    public function index()
    {
        $data['title'] = 'List-Rapaport';
        return view('admin.rapaport.list', ["data" => $data]);
    }

    public function update_price(Request $request)
    {   $value=[];
        if (!empty(session('refRapaport_type_id'))) {
            $rapa_sheet_data = DB::table('rapaport')->where('refRapaport_type_id', session('refRapaport_type_id'))->get();
            $data_array = array();
            $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
            $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();

            $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
            $merge_array = array();

            $new_request = new Request;
            $new_request['gateway'] = 'web';
            foreach ($categories as $cat_row) {
                $new_request['category'] = $cat_row->category_id;
                $response = $new_request->all();
                $q = null;
                $ag_names = null;
                $diamond_ids = DB::table('diamonds as d');
                $ij = 0;
                foreach ($response as $k => $v) {
                    if ($k == 'category' || $k == 'gateway') {
                        continue;
                    }
                    $q .= '("da' . $k . '"."refAttribute_group_id" = ' . $k . ' and "da' . $k . '"."refAttribute_id" in (' . implode(',', $v) . ') ) and ';
                    $diamond_ids = $diamond_ids->join('diamonds_attributes as da' . $k, 'd.diamond_id', '=', 'da' . $k . '.refDiamond_id')
                        ->join('attribute_groups as ag' . $k, 'da' . $k . '.refAttribute_group_id', '=', 'ag' . $k . '.attribute_group_id')
                        ->join('attributes as a' . $k, 'da' . $k . '.refAttribute_id', '=', 'a' . $k . '.attribute_id');

                    $ag_names .= 'a' . $k . '.name as name_' . $ij . ', ag' . $k . '.name as ag_name_' . $ij . ', ';
                    $ij++;
                }
                if (empty($q)) {
                    $diamond_ids = $diamond_ids->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
                        ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
                        ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id');
                    $ag_names = '"a"."name" as "name_0", "ag"."name" as "ag_name_0", ';
                    $ij = 1;
                }

                $diamond_ids = $diamond_ids->select('d.diamond_id', 'd.discount', 'd.refCategory_id', 'd.makable_cts', 'd.name as diamond_name', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price', 'd.barcode')
                    ->selectRaw(rtrim($ag_names, ', '));
                if (!empty($q)) {
                    $diamond_ids = $diamond_ids->whereRaw(rtrim($q, 'and '));
                }
                $diamond_ids = $diamond_ids->where('d.is_active', 1)
                    ->where('d.is_deleted', 0)
                    ->where('d.refCategory_id', $response['category'])
                    ->orderBy('d.diamond_id', 'desc')
                    ->get()
                    ->toArray();
                $final_d = [];
                foreach ($diamond_ids as $v_row) {
                    for ($i = 0; $i < $ij; $i++) {
                        $final_d[$v_row->diamond_id]['attributes'][$v_row->{'ag_name_' . $i}] = $v_row->{'name_' . $i};
                    }
                    $final_d[$v_row->diamond_id]['diamond_id'] = $v_row->diamond_id;
                    $final_d[$v_row->diamond_id]['barcode'] = $v_row->barcode;
                    $final_d[$v_row->diamond_id]['diamond_name'] = $v_row->diamond_name;
                    $final_d[$v_row->diamond_id]['carat'] = $v_row->carat;
                    $final_d[$v_row->diamond_id]['image'] = json_decode($v_row->image);
                    $final_d[$v_row->diamond_id]['price'] = $v_row->price;
                    $final_d[$v_row->diamond_id]['discount'] = $v_row->discount;
                    $final_d[$v_row->diamond_id]['refCategory_id'] = $v_row->refCategory_id;
                    $final_d[$v_row->diamond_id]['makable_cts'] = $v_row->makable_cts;
                }
                if (!empty($final_d)) {
                    $merge_array = array_merge($merge_array, $final_d);
                }
            }
            foreach ($categories as $cat_row) {
                foreach ($merge_array as $d_row_1) {
                    $d_row = (object) $d_row_1;
                    $d_row->expected_polish_cts = $d_row->carat;
                    if ($cat_row->category_id == $d_row->refCategory_id) {
                        if ($cat_row->category_type == config('constant.CATEGORY_TYPE_4P') || $cat_row->category_type == config('constant.CATEGORY_TYPE_POLISH')) {
                            
                            $d_row->shape = $d_row->attributes['SHAPE'];
                            $d_row->color = $d_row->attributes['COLOR'];
                            $d_row->clarity = $d_row->attributes['CLARITY'];

                            
                            if ($cat_row->category_type == config('constant.CATEGORY_TYPE_4P')) {
                                $d_row->color = substr($d_row->color, 2, 1);

                                // $org_clarity = $d_row->clarity;
                                $d_row->clarity2 = '';
                                if ($d_row->clarity == 'VS') {
                                    $d_row->clarity = 'VS1';
                                    $d_row->clarity2 = 'VS2';
                                }
                                if ($d_row->clarity == 'SI') {
                                    $d_row->clarity = 'SI1';
                                    // $d_row->clarity2 = '';
                                }
                            }

                            $shape = $d_row->shape;
                            if ($d_row->shape == 'ROUND' || $d_row->shape == 'RO' || $d_row->shape == 'Round Brilliant') {
                                $shape = "BR";
                            }
                            if ($d_row->shape != 'ROUND' && $d_row->shape != 'RO' && $d_row->shape != 'Round Brilliant') {
                                $shape = "PS";
                            }
                            foreach ($rapa_sheet_data as $row_rapa) {
                                $rapa_price=0;
                                if ($cat_row->category_type == config('constant.CATEGORY_TYPE_4P')) {                                   
                                    if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($d_row->color) && strtolower($row_rapa->clarity) == strtolower($d_row->clarity) && $d_row->expected_polish_cts >= $row_rapa->from_range && $d_row->expected_polish_cts <= $row_rapa->to_range) {
                                        $rapa_price1 = $row_rapa->rapaport_price;                                                                                                                                                                
                                    }

                                    $rapa_price2 = 0;
                                    if ($d_row->clarity == 'VS') {
                                        if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($d_row->color) && strtolower($row_rapa->clarity) == strtolower($d_row->clarity2) && $d_row->expected_polish_cts >= $row_rapa->from_range && $d_row->expected_polish_cts <= $row_rapa->to_range) {
                                            $rapa_price2 = $row_rapa->rapaport_price;
                                        }
                                    }

                                    if ($rapa_price2 != 0) {                                        
                                        $rapa_price1 = ($rapa_price1 + $rapa_price2) / 2;
                                    }
                                   
                                    $total = abs(($rapa_price1 * $d_row->expected_polish_cts * ($d_row->discount - 1))) - ($labour_charge_4p->amount * $d_row->expected_polish_cts);
                                    $data_array = [
                                        'diamond_id'=>$d_row->diamond_id,
                                        'rapaport_price' => $rapa_price1,
                                        'total' => $total
                                    ];
                                    array_push($value,$data_array);
                                    // Diamonds::where('diamond_id', $d_row->diamond_id)->update(['total' => DB::raw($data_array['total']), 'rapaport_price' => DB::raw($data_array['rapaport_price'])]);
                                }

                                if ($cat_row->category_type == config('constant.CATEGORY_TYPE_POLISH')) {
                                    if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($d_row->color) && strtolower($row_rapa->clarity) == strtolower($d_row->clarity) && $d_row->expected_polish_cts >= $row_rapa->from_range && $d_row->expected_polish_cts <= $row_rapa->to_range) {                                
                                        $rapa_price = $row_rapa->rapaport_price;
                                        $total = abs(($rapa_price * $d_row->expected_polish_cts * ($d_row->discount - 1)));
                                        $data_array = [
                                            'diamond_id'=>$d_row->diamond_id,
                                            'rapaport_price' => $rapa_price,
                                            'total' => $total
                                        ];
                                        array_push($value,$data_array);
                                        // Diamonds::where('diamond_id', $d_row->diamond_id)->update(['total' => DB::raw($data_array['total']), 'rapaport_price' => DB::raw($data_array['rapaport_price'])]);
                                    }
                                }
                            }
                        }
                        if ($cat_row->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                            $d_row->expected_polish_cts = $d_row->carat;
                            $d_row->shape = $d_row->attributes['SHAPE'];
                            $d_row->color = $d_row->attributes['COLOR'];
                            $d_row->clarity = $d_row->attributes['CLARITY'];

                            $shape = $d_row->shape;
                            if ($d_row->shape == 'ROUND' || $d_row->shape == 'RO' || $d_row->shape == 'Round Brilliant') {
                                $shape = "BR";
                            }
                            if ($d_row->shape != 'ROUND' && $d_row->shape != 'RO' && $d_row->shape != 'Round Brilliant') {
                                $shape = "PS";
                            }
                            foreach ($rapa_sheet_data as $row_rapa) {
                                if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($d_row->color) && $d_row->expected_polish_cts >= $row_rapa->from_range && $d_row->expected_polish_cts <= $row_rapa->to_range && strtolower($row_rapa->clarity) == strtolower($d_row->clarity)) {
                                    $rapa_price = $row_rapa->rapaport_price;
                                    if ($cat_row->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                                        $price = abs($rapa_price * ($d_row->discount - 1));
                                        $amount = abs($price * doubleval($d_row->expected_polish_cts));
                                        $ro_amount = abs($amount / doubleval($d_row->makable_cts));
                                        $final_price = $ro_amount - $labour_charge_rough->amount;
                                        $total = abs($final_price * (doubleval($d_row->makable_cts)));
                                        $data_array = [
                                            'diamond_id'=>$d_row->diamond_id,
                                            'rapaport_price' => $rapa_price,
                                            'total' => $total
                                        ];
                                        array_push($value,$data_array);
                                        // Diamonds::where('diamond_id', $d_row->diamond_id)->update(['total' => DB::raw($data_array['total']), 'rapaport_price' => DB::raw($data_array['rapaport_price'])]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $diamondsInstance = new Diamonds;        
        $index = 'diamond_id';
        Batch::update($diamondsInstance, $value, $index);
    }

    public function rapaportPrice(Request $request)
    {
        $rapa_price = 0;
        $rapaport = DB::table('rapaport')->orderBy('rapaport_price', 'desc')->get();
        if ($request->cat_type == 1 || $request->cat_type == 3) {

            $labour_charge = DB::table('labour_charges')->select('amount')->where('labour_charge_id', 1)->first();
            $request->clarity = str_replace(' ', '', $request->clarity);

            if ($request->cat_type == config('constant.CATEGORY_TYPE_4P')) {


                $org_clarity = $request->clarity;
                $request->clarity2 = '';
                if ($request->clarity == 'VS') {
                    $request->clarity = 'VS1';
                    $request->clarity2 = 'VS2';
                }
                if ($request->clarity == 'SI') {
                    $request->clarity = 'SI1';
                    $request->clarity2 = '';
                }

                $color = substr($request->color, 2, 1);
                $request->color = $color;
            }

            if (isset($request->shape) && isset($request->color) && isset($request->clarity) && isset($request->expected_polish_cts)) {

                $shape = $request->shape;
                if ($request->shape == 'ROUND' || $request->shape == 'RO' || $request->shape == 'Round Brilliant') {
                    $shape = "BR";
                }
                if ($request->shape != 'ROUND' && $request->shape != 'RO' && $request->shape != 'Round Brilliant') {
                    $shape = "PS";
                }

                foreach ($rapaport as $row_rapa) {
                    if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($request->color) && strtolower($row_rapa->clarity) == strtolower($request->clarity) && $request->expected_polish_cts >= $row_rapa->from_range && $request->expected_polish_cts <= $row_rapa->to_range) {
                        $rapa_price = $row_rapa->rapaport_price;
                        break;
                    }
                }
                if ($request->clarity == 'VS1') {
                    if ($request->cat_type == config('constant.CATEGORY_TYPE_4P')) {
                        $rapa_price2 = 0;
                        foreach ($rapaport as $row_rapa) {
                            if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($request->color) && strtolower($row_rapa->clarity) == strtolower($request->clarity2) && $request->expected_polish_cts >= $row_rapa->from_range && $request->expected_polish_cts <= $row_rapa->to_range) {
                                $rapa_price2 = $row_rapa->rapaport_price;
                                break;
                            }
                        }
                        if ($rapa_price2 != 0) {
                            $rapa_price = ($rapa_price + $rapa_price2) / 2;
                        }
                    }
                }
            }
        }
        if ($request->cat_type == 2) {

            $labour_charge = DB::table('labour_charges')->select('amount')->where('labour_charge_id', 2)->first();

            if (isset($request->shape) && isset($request->expected_polish_cts)) {

                $shape = $request->shape;
                if ($request->shape == 'ROUND' || $request->shape == 'RO' || $request->shape == 'Round Brilliant') {
                    $shape = "BR";
                }
                if ($request->shape != 'ROUND' && $request->shape != 'RO' && $request->shape != 'Round Brilliant') {
                    $shape = "PS";
                }

                foreach ($rapaport as $row_rapa) {
                    if (strtolower($row_rapa->shape) == strtolower($shape) && strtolower($row_rapa->color) == strtolower($request->color) && $request->expected_polish_cts >= $row_rapa->from_range && $request->expected_polish_cts <= $row_rapa->to_range && strtolower($row_rapa->clarity) == strtolower($request->clarity)) {
                        $rapa_price = $row_rapa->rapaport_price;
                        break;
                    }
                }
            }
        }
        if (!empty($rapa_price)) {
            $data = array(
                'suceess' => true,
                'rapa_price' => $rapa_price,
                'labour_charge' => $labour_charge->amount
            );
        } else {
            $data = array(
                'fail' => false
            );
        }
        return response()->json($data);
    }

    public function fileImport(Request $request)
    {
        $request->session()->put("import_refRapaport_type_id", $request->rapaport_type_id);
        $rapa_type = DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->first();
        DB::table('rapaport')->where('refRapaport_type_id', $request->rapaport_type_id)->delete();


        // $exist_file = DB::table('customer_company_details')->where('refCustomer_id', $request->id)->first();
        // if ($exist_file) {
        //     if(file_exists('/public/user_files/' . $exist_file->pan_gst_attachment)){
        //         unlink(base_path('/storage/app/public/user_files/' . $exist_file->pan_gst_attachment));
        //     }
        // }        
        $csv = time() . '_' . preg_replace('/\s+/', '_', $request->file('file')->getClientOriginalName());
        $request->file('file')->storeAs("public/user_files", $csv);

        $res = Excel::import(new RapaportImport, request()->file('file'));
        $date = date("Y-m-d h:i:s");
        if ($rapa_type->rapaport_category == 1) {
            DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->update(['date_updated' => $date, 'csv_link' => $csv]);
            $request->session()->put("request_check", 1);
            $request->session()->put("refRapaport_type_id", $request->rapaport_type_id);
        }
        if ($rapa_type->rapaport_category == 2) {
            DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->update(['date_updated' => $date, 'csv_link' => $csv]);
            $request->session()->put("request_check", 1);
            $request->session()->put("refRapaport_type_id", $request->rapaport_type_id);
        }

        activity($request, "inserted", 'rapaport');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/rapaport');
    }

    public function addExcel()
    {
        $rapa_type = DB::table('rapaport_type')->get();
        $data['rapa_type'] = $rapa_type;
        $data['title'] = 'Add-Rapaport';
        return view('admin.rapaport.import', ["data" => $data]);
    }

    public function add()
    {
        $data['title'] = 'Add-Rapaport-CSV-TYPE';
        return view('admin.rapaport.add', ["data" => $data]);
    }

    public function save(Request $request)
    {
        DB::table('rapaport_type')->insert([
            'name' => $request->name,
            'rapaport_category' => $request->rapaport_category,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        $Id = DB::getPdo()->lastInsertId();
        activity($request, "inserted", 'rapaport', $Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/rapaport');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('rapaport_type')->get();
            return Datatables::of($data)
                ->addColumn('index', '')
                ->editColumn('date_updated', function ($row) {
                    return date_time_formate($row->date_updated);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = ' <a href="/storage/user_files/' . $row->csv_link . '" class="btn btn-xs btn-info" target="_blank">&nbsp;CSV&nbsp;<em class="icon ni ni-eye-fill"></em></a>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $result = DB::table('rapaport_type')->where('rapaport_type_id', $id)->first();
        $data['title'] = 'Edit-Rapaport-CSV-TYPE';
        $data['result'] = $result;
        return view('admin.rapaport.edit', ["data" => $data]);
    }

    public function update(Request $request)
    {
        DB::table('rapaport_type')->where('rapaport_type_id', $request->id)->update([
            'name' => $request->name,
            'rapaport_category' => $request->rapaport_category,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request, "updated", 'rapaport', $request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/rapaport');
    }
}
