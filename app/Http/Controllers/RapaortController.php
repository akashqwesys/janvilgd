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
use App\Imports\RapaportImport;

class RapaortController extends Controller {

    public function index() {
        $data['title'] = 'List-Rapaport';
        return view('admin.rapaport.list', ["data" => $data]);
    }
    public function update_price(Request $request) {        
        if (!empty(session('refRapaport_type_id'))) {
            $rapa_sheet_data=DB::table('rapaport')->where('refRapaport_type_id',session('refRapaport_type_id'))->get();
            $data_array = array();
            $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
            $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
            foreach ($rapa_sheet_data as $row) {
                $diamond_ids = DB::table('diamonds_attributes')->select('diamonds_attributes.*', 'attributes.name as at_name', 'attribute_groups.name as ag_name', 'diamonds.*', 'categories.category_type')
                        ->join('attributes', 'diamonds_attributes.refAttribute_id', '=', 'attributes.attribute_id')
                        ->join('attribute_groups', 'diamonds_attributes.refAttribute_group_id', '=', 'attribute_groups.attribute_group_id')
                        ->join('diamonds', 'diamonds_attributes.refDiamond_id', '=', 'diamonds.diamond_id')
                        ->join('categories', 'diamonds.refCategory_id', '=', 'categories.category_id')
                        ->where(
                                [['diamonds.expected_polish_cts', '>=', $row->from_range]]
                        )
                        ->where(
                                [['diamonds.expected_polish_cts', '<=', $row->to_range]]
                        )
                        ->whereRaw(
                                [['attribute_groups.name = ?', 'COLOR'],
                                    ['lower(attributes.name) = ?', strtolower($row->color)]]
                        )
                        ->orWhereRaw(
                                [['attribute_groups.name = ?', 'CLARITY'],
                                    ['lower(attributes.name) = ?', strtolower($row->clarity)]]
                        )
                        ->orWhereRaw(
                                [['attribute_groups.name = ?', 'SHAPE'],
                                    ['lower(attributes.name) = ?', strtolower($row->shape)]]
                        )
                        ->get();             
                if (!empty($diamond_ids)) {
                    $final_d = [];
                    $k = 0;
                    $diamond_id_array = array();
                    foreach ($diamond_ids as $v_row) {
                        array_push($diamond_id_array, $v_row->diamond_id);
                    }
                    $diamond_id_array = array_unique($diamond_id_array);

                    if (isset($diamond_ids[0])) {                        
                        $final_d[0] = $diamond_ids[0];
                        foreach ($diamond_ids as $v_row) {
                            foreach ($diamond_id_array as $dim_row) {
                                if ($dim_row == $v_row->diamond_id) {
                                    $i = 0;
                                    $v_row->{$v_row->ag_name} = $v_row->at_name;
                                    if (!empty($final_d)) {
                                        foreach ($final_d as $f_row) {
                                            if ($f_row->diamond_id == $dim_row) {
                                                $f_row->{$v_row->ag_name} = $v_row->at_name;
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
                        $array = array();
                        if (!empty($final_d)) {
                            $final_update_array = array();
                            foreach ($final_d as $row_1) {
                                if ($row_1->category_type == config('constant.CATEGORY_TYPE_4P')) {
                                    if (isset($row_1->SHAPE) && isset($row_1->CLARITY) && isset($row_1->COLOR)) {
                                        $total = abs(($row->rapaport_price * $row_1->expected_polish_cts * ($row_1->discount - 1))) - $labour_charge_4p->amount;
                                        $data_array = [
                                            'rapaport_price' => $row->rapaport_price,
                                            'total' => $total
                                        ];                                    
                                    Diamonds::where('diamond_id',$row_1->diamond_id)->update(['total'=> DB::raw($data_array['total']),'rapaport_price'=> DB::raw($data_array['rapaport_price'])]);
                                    }
                                }
                                if ($row_1->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                                    if (isset($row_1->SHAPE)) {
                                        $price = abs($row->rapaport_price * ($row_1->discount - 1));
                                        $amount = abs($price * doubleval($row_1->expected_polish_cts));
                                        $ro_amount = abs($amount / doubleval($row_1->makable_cts));
                                        $final_price = $ro_amount - $labour_charge_rough->amount;
                                        $total = abs($final_price * (doubleval($row_1->makable_cts)));

                                        $data_array = [
                                            'rapaport_price' => $row->rapaport_price,
                                            'total' => $total
                                        ];                                       
                                       Diamonds::where('diamond_id',$row_1->diamond_id)->update(['total'=> DB::raw($data_array['total']),'rapaport_price'=> DB::raw($data_array['rapaport_price'])]);                                                                     
                                    }
                                }
                                if ($row_1->category_type == config('constant.CATEGORY_TYPE_POLISH')) {
                                    if (isset($row_1->SHAPE) && isset($row_1->CLARITY) && isset($row_1->COLOR)) {
                                        $total = abs(($row->rapaport_price * $row_1->expected_polish_cts * ($row_1->discount)));
                                        $data_array = [
                                            'rapaport_price' => $row->rapaport_price,
                                            'total' => $total
                                        ];                                    
                                    Diamonds::where('diamond_id',$row_1->diamond_id)->update(['total'=> DB::raw($data_array['total']),'rapaport_price'=> DB::raw($data_array['rapaport_price'])]);                                                                      
                                    }
                                }
                            }
                        }
                    }
                }
            }            
        }
    }
    public function rapaportPrice(Request $request) {
        $rapa_price=array();
        if($request->cat_type==1 || $request->cat_type==3){
            
            if(isset($request->shape) && isset($request->color) && isset($request->clarity) && isset($request->expected_polish_cts)){                   
                $rapa_price = DB::table('rapaport')
//                    ->select(DB::raw('count(*) as user_count, status'))
                    ->whereRaw('lower(shape) = ?', strtolower($request->shape))                
                    ->whereRaw('lower(color) = ?', strtolower($request->color))               
                    ->whereRaw('lower(clarity) = ?', strtolower($request->clarity))                       
                    ->where('from_range','<=',$request->expected_polish_cts)
                    ->where('to_range','>=',$request->expected_polish_cts)                    
                    ->first();      
            }  
        }
        if($request->cat_type==2){
            if(isset($request->shape) && isset($request->expected_polish_cts)){
                $rapa_price = DB::table('rapaport')                
                    ->whereRaw('lower(shape) = ?', strtolower($request->shape))                                       
                    ->where('from_range','<=',$request->expected_polish_cts)
                    ->where('to_range','>=',$request->expected_polish_cts)               
                    ->first();      
            }
        }
        if (!empty($rapa_price)) {
            $data = array(
                'suceess' => true,
                'rapa_price' => $rapa_price->rapaport_price
            );
        } else {
            $data = array(
                'fail' => false
            );
        }
        return response()->json($data);
    }
    public function fileImport(Request $request) {
        $request->session()->put("import_refRapaport_type_id", $request->rapaport_type_id); 
        $rapa_type = DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->first();        
        DB::table('rapaport')->where('refRapaport_type_id',$request->rapaport_type_id)->delete();         
        $res=Excel::import(new RapaportImport, request()->file('file'));                
         $date=date("Y-m-d h:i:s");
        if ($rapa_type->rapaport_category == 1) {                                   
                DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->update(['date_updated'=>$date]);            
                $request->session()->put("request_check", 1);
                $request->session()->put("refRapaport_type_id", $request->rapaport_type_id);

        } 
        if ($rapa_type->rapaport_category == 2) {                                                                                                           
                DB::table('rapaport_type')->where('rapaport_type_id', $request->rapaport_type_id)->update(['date_updated'=>$date]);          
                $request->session()->put("request_check", 1);
                $request->session()->put("refRapaport_type_id", $request->rapaport_type_id);

        } 
        
        activity($request, "inserted", 'rapaport');
        successOrErrorMessage("Data added Successfully", 'success');        
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
                                return date_formate($row->date_updated);
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
