<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Diamonds;
use DataTables;
use Excel;
use App\Imports\DiamondsImport;

class DiamondsController extends Controller {

    public function index($cat_id) {
        session()->put('add_category',$cat_id);
        $cat_type = DB::table('categories')->where('is_active', 1)->where('category_id', $cat_id)->where('is_deleted', 0)->first();
        $data['title'] = 'List-Diamonds';
        $data['cat_id'] = $cat_id;
        $data['cat_type'] = $cat_type->category_type;
        $data['cat_name'] = $cat_type->name;
        return view('admin.diamonds.list', ["data" => $data]);
    }

    public function fileImport(Request $request) {
        $res = Excel::toArray(new DiamondsImport, request()->file('file'));

        // print_r($res);die;

        $attribute_groups = DB::table('attribute_groups')->where('is_active', 1)->where('refCategory_id', $request->refCategory_id)->where('is_deleted', 0)->get();
        
        $rapaport = DB::table('rapaport')->orderBy('rapaport_price','desc')->get();        
        
        $cat_type = DB::table('categories')->where('is_active', 1)->where('category_id', $request->refCategory_id)->where('is_deleted', 0)->first();
        $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
        $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
        $attr_group_array = array();
        if (!empty($res)) {
            foreach ($res[0] as $row) {
                if ($cat_type->category_type == config('constant.CATEGORY_TYPE_4P')) {                    
                    if (isset($row['barcode']) && is_numeric($row['mkbl_cts']) && is_numeric($row['exp_pol_cts']) && !empty($row['color']) && !empty($row['shape']) && !empty($row['clarity']) && ($row['clarity']=='VS' || $row['clarity']=='SI')) {
                        if (empty($row['barcode']) || $row['barcode'] == 'TOTAL' || $row['barcode'] == 'total' || $row['barcode'] == 'Total') {
                            break;
                        }
                        $barcode = DB::table('diamonds')->where('barcode', $row['barcode'])->first();
                        if (!empty($row['barcode'])) {

                            $row['shape']=trim($row['shape']);
                            $row['color']=trim($row['color']);
                            
                            $color = substr($row['color'], 2, 1);                            

                            $row['clarity']=trim(str_replace(' ','', $row['clarity']));
                            $org_clarity=$row['clarity'];
                            $row['clarity2']='';
                            if($row['clarity']=='VS'){
                                $row['clarity']='VS1';
                                $row['clarity2']='VS2';
                            }
                            if($row['clarity']=='SI'){
                                $row['clarity']='SI1';
                                $row['clarity2']='';
                            }
                            
                            $shape=$row['shape'];
                            $shape1=$row['shape'];
                            
                            if($row['shape']=='ROUND' || $row['shape']=='RO' ||  $row['shape']=='Round Brilliant'){                                
                                $shape="BR";
                            }else{
                                $shape="PS";
                            }                           
                            // if($row['shape']!='ROUND' && $row['shape']!='RO' && $row['shape']!='Round Brilliant'){
                            //     $shape="PS";
                            // }                           
                            foreach ($rapaport as $row_rapa){
                                if(strtolower($row_rapa->shape)==strtolower($shape) && strtolower($row_rapa->color)==strtolower($color) && strtolower($row_rapa->clarity)==strtolower($row['clarity']) && $row['exp_pol_cts']>=$row_rapa->from_range && $row['exp_pol_cts']<=$row_rapa->to_range){
                                    $row['rapa']=$row_rapa->rapaport_price;                                                                         
                                    break;
                                }                                
                            }

                            $row['rapa2']=0;
                            if(!empty($row['clarity2'])){
                                foreach ($rapaport as $row_rapa){
                                    if(strtolower($row_rapa->shape)==strtolower($shape) && strtolower($row_rapa->color)==strtolower($color) && strtolower($row_rapa->clarity)==strtolower($row['clarity2']) && $row['exp_pol_cts']>=$row_rapa->from_range && $row['exp_pol_cts']<=$row_rapa->to_range){
                                        $row['rapa2']=$row_rapa->rapaport_price; 
                                        break;
                                    }
                                }
                            }
                           

                            if($row['rapa2']!=0){
                                $row['rapa']=($row['rapa']+$row['rapa2'])/2;
                            }
                                                                                                           
                            $row['discount'] = str_replace('-', '', $row['discount']);                            
                            $row['discount'] = doubleval($row['discount']);
                                                                                                          
                            $row['weight_loss'] = 100 - ((doubleval($row['exp_pol_cts']) * 100) / doubleval($row['mkbl_cts']));
                            $total=abs(($row['rapa'] * $row['exp_pol_cts'] * ($row['discount']-1))) - ($labour_charge_4p->amount*$row['exp_pol_cts']);
                                                    
                            $image=array();
                            if(isset($row['image_link'])){
                                $image[0]=$row['image_1'];
                                $image[1]=$row['image_2'];
                                $image[2]=$row['image_3'];
                                $image[3]=$row['image_4'];
                            }
                            $img_json= json_encode($image);
                                    
                            $name=$row['exp_pol_cts'].' Carat '.$row['shape'].' Shape  • '.$row['color'].' Color  • '.$org_clarity.' Clarity :: 4P Diamond';

                            $data_array = [
                                'name' => $name,
                                'barcode' => strval($row['barcode']),
                                'packate_no' => strval($row['main_pktno']),
                                'actual_pcs' => 0,
                                'available_pcs' => 0,
                                'makable_cts' => doubleval($row['mkbl_cts']),
                                'expected_polish_cts' => doubleval($row['exp_pol_cts']),
                                'remarks' => strval($row['remarks']),
                                'rapaport_price' => $row['rapa'],
                                'discount' => $row['discount'],
                                'weight_loss' => $row['weight_loss'],
                                'video_link' => strval($row['video_link']),
                                'image' => $img_json,
                                'refCategory_id' => $request->refCategory_id,
                                'total' => $total,
                                'added_by' => session()->get('loginId'),
                                'is_active' => 1,
                                'is_deleted' => 0,
                                'date_added' => date("Y-m-d h:i:s"),
                                'date_updated' => date("Y-m-d h:i:s")
                            ];

                            if (!empty($barcode)) {
                                DB::table('diamonds')->where('diamond_id', $barcode->diamond_id)->update($data_array);
                                DB::table('diamonds_attributes')->where('refDiamond_id', $barcode->diamond_id)->delete();
                                $Id = $barcode->diamond_id;
                            } else {
                                DB::table('diamonds')->insert($data_array);
                                $Id = DB::getPdo()->lastInsertId();
                            }

                            foreach ($attribute_groups as $atr_grp_row) {
                                
                                $atr_grp_row->name=trim($atr_grp_row->name);
                                
                                $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();
                                if ($atr_grp_row->name === "HALF-CUT DIA") {
                                    if (!empty($row['half_cut_dia'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['half_cut_dia']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "PO. DIAMETER") {
                                    if (!empty($row['po_diameter'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['po_diameter']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "HALF-CUT HGT") {
                                    if (!empty($row['half_cut_hgt'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['half_cut_hgt']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "EXP POL SIZE") {
                                    if (!empty($row['exp_pol_size'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim(str_replace('=','+',$row['exp_pol_size']));
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "SHAPE") {
                                    if (!empty($row['shape'])) {
                                        $shape = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['shape'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $shape = 1;
                                            }
                                        }
                                        if ($shape == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['shape'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "CLARITY") {
                                    if (!empty($org_clarity)) {
                                        $clarity = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $org_clarity && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $clarity = 1;
                                            }
                                        }
                                        if ($clarity == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $org_clarity,
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "COLOR") {
                                    if (!empty($row['color'])) {
                                        $color = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['color'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $color = 1;
                                            }
                                        }
                                        if ($color == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['color'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                if ($cat_type->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                    if (isset($row['barcode']) && is_numeric($row['org_cts']) && is_numeric($row['exp_pol']) && !empty($row['color']) && !empty($row['shape']) && !empty($row['clarity'])) {
                                                
                        if (empty($row['barcode']) || $row['barcode'] == 'TOTAL' || $row['barcode'] == 'total' || $row['barcode'] == 'Total') {
                            break;
                        }
                        $barcode = DB::table('diamonds')->where('barcode', $row['barcode'])->first();
                        if (!empty($row['barcode'])) {                             
                            $row['shape']=trim($row['shape']);                            
                            $row['clarity']=trim(str_replace(' ','', $row['clarity']));                                                         
                            
                            $shape=$row['shape'];
                            if($row['shape']=='ROUND' || $row['shape']=='RO' ||  $row['shape']=='Round Brilliant'){                                
                                $shape="BR";
                            }
                            if($row['shape']!='ROUND' && $row['shape']!='RO' && $row['shape']!='Round Brilliant'){
                                $shape="PS";
                            }
                            foreach ($rapaport as $row_rapa){
                                if(strtolower($row_rapa->shape)==strtolower($shape) && $row['exp_pol']>=$row_rapa->from_range && $row['exp_pol']<=$row_rapa->to_range && strtolower($row_rapa->color)==strtolower($row['color']) && strtolower($row_rapa->clarity)==strtolower($row['clarity'])){                                    
                                    $row['rap']=$row_rapa->rapaport_price; 
                                    break;
                                }
                            }
                            
                            $row['dis']=$row['discount'];
                            $row['dis'] = doubleval($row['dis']);
                            $row['dis'] = str_replace('-', '', $row['dis']);
                            
                            $price=abs($row['rap']*($row['dis']-1));
                            $amount=abs($price*doubleval($row['exp_pol']));
                            $ro_amount=abs($amount/doubleval($row['org_cts']));
                            $final_price=$ro_amount-$labour_charge_rough->amount;
                            $total=abs($final_price*(doubleval($row['org_cts'])));

                            $image=array();
                            if(isset($row['image_link'])){
                               $image[0]=$row['image_1'];
                                $image[1]=$row['image_2'];
                                $image[2]=$row['image_3'];
                                $image[3]=$row['image_4'];
                            }
                            $img_json= json_encode($image);

                            $name=$row['exp_pol'].' Carat '.$row['shape'].' Shape  • '.$row['color'].' Color  • '.$row['clarity'].' Clarity :: Rough Diamond';

                            if(empty($row['video'])){
                                $row['video']=NULL;                                    
                            }
                            
                            $data_array = [
                                'name' =>$name,
                                'barcode' => strval($row['barcode']),
                                'packate_no' => strval($row['pktno']),
                                'makable_cts' => doubleval($row['org_cts']),
                                'expected_polish_cts' => doubleval($row['exp_pol']),
                                'rapaport_price' => $row['rap'],
                                'discount' => $row['dis'],
                                'refCategory_id' => $request->refCategory_id,
                                'total' => $total,
                                'image' => $img_json,
                                'video_link'=>$row['video'],
                                'added_by' => session()->get('loginId'),
                                'is_active' => 1,
                                'is_deleted' => 0,
                                'date_added' => date("Y-m-d h:i:s"),
                                'date_updated' => date("Y-m-d h:i:s")
                            ];
                            if (!empty($barcode)) {
                                DB::table('diamonds')->where('diamond_id', $barcode->diamond_id)->update($data_array);
                                DB::table('diamonds_attributes')->where('refDiamond_id', $barcode->diamond_id)->delete();
                                $Id = $barcode->diamond_id;
                            } else {
                                DB::table('diamonds')->insert($data_array);
                                $Id = DB::getPdo()->lastInsertId();
                            }
                            foreach ($attribute_groups as $atr_grp_row) {
                                
                                $atr_grp_row->name=trim($atr_grp_row->name);
                                
                                $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();
                                if ($atr_grp_row->name === "CLARITY") {
                                    if (!empty($row['clarity'])) {
                                        $clarity = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['clarity'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $clarity = 1;
                                            }
                                        }
                                        if ($clarity == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['clarity'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "SHAPE") {
                                    if (!empty($row['shape'])) {
                                        $shape = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['shape'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $shape = 1;
                                            }
                                        }
                                        if ($shape == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['shape'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }
                                 if ($atr_grp_row->name === "COLOR") {
                                    if (!empty($row['color'])) {
                                        $color = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['color'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $color = 1;
                                            }
                                        }
                                        if ($color == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['color'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                } 
                            }
                        }
                    }
                }
                if ($cat_type->category_type == config('constant.CATEGORY_TYPE_POLISH')) {                    
                        if (isset($row['stock']) && is_numeric($row['weight']) && !empty($row['color']) && !empty($row['shape']) && !empty($row['clarity'])) {

                        if (empty($row['stock']) || $row['stock'] == 'TOTAL' || $row['stock'] == 'total' || $row['stock'] == 'Total') {
                            break;
                        }
                        $barcode = DB::table('diamonds')->where('barcode', $row['certificate'])->first();
                        if (!empty($row['stock'])) {

                            $row['shape']=trim($row['shape']);
                            $row['color']=trim($row['color']);
                            $row['clarity']=trim(str_replace(' ','', $row['clarity']));
                            $row['cut_grade']=trim($row['cut_grade']);
                            $row['polish']=trim($row['polish']);
                            $row['symmetry']=trim($row['symmetry']);
                            $row['lab']=trim($row['lab']);
                            $row['culet_size']=trim($row['culet_size']);
                            $row['girdle_condition']=trim($row['girdle_condition']);                                                                                                                
                            
                            $shape=$row['shape'];
                            if($row['shape']=='ROUND' || $row['shape']=='RO' ||  $row['shape']=='Round Brilliant'){                                
                                $shape="BR";
                            }
                            if($row['shape']!='ROUND' && $row['shape']!='RO' && $row['shape']!='Round Brilliant'){
                                $shape="PS";
                            }
                            foreach ($rapaport as $row_rapa){
                                if(strtolower($row_rapa->shape)==strtolower($shape) && strtolower($row_rapa->color)==strtolower($row['color']) && strtolower($row_rapa->clarity)==strtolower($row['clarity']) && $row['weight']>=$row_rapa->from_range && $row['weight']<=$row_rapa->to_range){
                                    $row['price']=$row_rapa->rapaport_price;   
                                    break;
                                }
                            }                                 
                            $row['discount_percent'] = str_replace('-', '', $row['discount_percent']);
                            $row['discount_percent'] = doubleval($row['discount_percent']);
                            $row['weight'] = doubleval($row['weight']);                                                                                                    
                            $total=abs($row['price']*$row['weight']*($row['discount_percent']-1));

                            $image=array();
                            if(isset($row['image_link'])){
                               $image[0]=$row['image_1'];
                                $image[1]=$row['image_2'];
                                $image[2]=$row['image_3'];
                                $image[3]=$row['image_4'];
                            }
                            $img_json= json_encode($image);


                            $name=$row['weight'].' Carat '.$row['shape'].' Shape  • '.$row['color'].' Color  • '.$row['clarity'].' Clarity :: Polish Diamond';

                            $data_array = [
                                'name' =>$name,
                                'barcode' => $row['certificate'],
                                'packate_no' => $row['stock'],
                                'discount' => $row['discount_percent'],
                                'expected_polish_cts' => $row['weight'],
                                'rapaport_price' => $row['price'],
                                'image' => $img_json,
                                'video_link' => $row['video_link'],
                                'refCategory_id' => $request->refCategory_id,
                                'total' => $total,
                                'added_by' => session()->get('loginId'),
                                'is_active' => 1,
                                'is_deleted' => 0,
                                'date_added' => date("Y-m-d h:i:s"),
                                'date_updated' => date("Y-m-d h:i:s")
                            ];
                            if (!empty($barcode)) {
                                DB::table('diamonds')->where('diamond_id', $barcode->diamond_id)->update($data_array);
                                DB::table('diamonds_attributes')->where('refDiamond_id', $barcode->diamond_id)->delete();
                                $Id = $barcode->diamond_id;
                            } else {
                                DB::table('diamonds')->insert($data_array);
                                $Id = DB::getPdo()->lastInsertId();
                            }

                            foreach ($attribute_groups as $atr_grp_row) {
                                
                                $atr_grp_row->name=trim($atr_grp_row->name);
                                
                                $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();

                                if ($atr_grp_row->name === "DEPTH PERCENT") {
                                    if (!empty($row['depth_percent'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['depth_percent']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }

                                if ($atr_grp_row->name === "TABLE PERCENT") {

                                    if (!empty($row['table_percent'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['table_percent']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }

                                if ($atr_grp_row->name === "CERTIFICATE") {

                                    if (!empty($row['certificate'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['certificate']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }

                                if ($atr_grp_row->name === "GIRDLE PERCENT") {

                                    if (!empty($row['girdle_percent'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['girdle_percent']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }


                                if ($atr_grp_row->name === "PAVILION DEPTH") {

                                    if (!empty($row['pavilion_depth'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['pavilion_depth']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "CROWN HEIGHT") {

                                    if (!empty($row['crown_height'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['crown_height']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "CROWN ANGLE") {
                                    if (!empty($row['crown_angle'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['crown_angle']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "PAVILION ANGLE") {

                                    if (!empty($row['pavilion_angle'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['pavilion_angle']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "GROWTH TYPE") {

                                    if (!empty($row['growth_type'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['growth_type']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }

                                if ($atr_grp_row->name === "MEASUREMENTS") {
                                    if (!empty($row['measurements'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['measurements']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "CERTIFICATE URL") {
                                    if (!empty($row['certificate_url'])) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = 0;
                                        $insert_array['value'] = trim($row['certificate_url']);
                                        array_push($attr_group_array, $insert_array);
                                    }
                                }
                                if ($atr_grp_row->name === "SHAPE") {
                                    if (!empty($row['shape'])) {
                                        $shape = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['shape'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $shape = 1;
                                            }
                                        }
                                        if ($shape == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['shape'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }
                                if ($atr_grp_row->name === "CLARITY") {
                                    if (!empty($row['clarity'])) {
                                        $clarity = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['clarity'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $clarity = 1;
                                            }
                                        }
                                        if ($clarity == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['clarity'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }
                                if ($atr_grp_row->name === "COLOR") {
                                    if (!empty($row['color'])) {
                                        $color = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['color'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $color = 1;
                                            }
                                        }
                                        if ($color == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['color'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }                                                               
                                if ($atr_grp_row->name === "CUT GRADE") {

                                    if (!empty($row['cut_grade'])) {
                                        $cut_grade = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['cut_grade'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $cut_grade = 1;
                                            }
                                        }
                                        if ($cut_grade == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['cut_grade'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }
                                if ($atr_grp_row->name === "POLISH") {
                                    if (!empty($row['polish'])) {
                                        $polish = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['polish'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $polish = 1;
                                            }
                                        }
                                        if ($polish == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['polish'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "SYMMETRY") {
                                    if (!empty($row['symmetry'])) {
                                        $symmetry = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['symmetry'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $symmetry = 1;
                                            }
                                        }
                                        if ($symmetry == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['symmetry'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "LAB") {
                                    if (!empty($row['lab'])) {
                                        $lab = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['lab'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $lab = 1;
                                            }
                                        }
                                        if ($lab == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['lab'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "CULET SIZE") {
                                    if (!empty($row['culet_size'])) {
                                        $culet_size = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['culet_size'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $culet_size = 1;
                                            }
                                        }
                                        if ($culet_size == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['culet_size'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }

                                if ($atr_grp_row->name === "GRIDLE CONDITION") {
                                    if (!empty($row['girdle_condition'])) {
                                        $girdle_condition = 0;
                                        foreach ($attribute as $atr_row) {
                                            if ($atr_row->name == $row['girdle_condition'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                                $insert_array = array();
                                                $insert_array['refDiamond_id'] = $Id;
                                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                                $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                                $insert_array['value'] = 0;
                                                array_push($attr_group_array, $insert_array);
                                                $girdle_condition = 1;
                                            }
                                        }
                                        if ($girdle_condition == 0) {
                                            DB::table('attributes')->insert([
                                                'name' => $row['girdle_condition'],
                                                'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                                'added_by' => $request->session()->get('loginId'),
                                                'is_active' => 1,
                                                'is_deleted' => 0,
                                                'date_added' => date("Y-m-d h:i:s"),
                                                'date_updated' => date("Y-m-d h:i:s")
                                            ]);
                                            $attr_id = DB::getPdo()->lastInsertId();
                                            $insert_array = array();
                                            $insert_array['refDiamond_id'] = $Id;
                                            $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                            $insert_array['refAttribute_id'] = $attr_id;
                                            $insert_array['value'] = 0;
                                            array_push($attr_group_array, $insert_array);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($attr_group_array)) {
            DB::table('diamonds_attributes')->insert($attr_group_array);
        }

        activity($request, "inserted", 'diamonds');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/diamonds/list/'.$request->refCategory_id);
    }

    public function addExcel() {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->orderBy('sort_order','asc')->get();
        $data['category'] = $categories;
        $data['title'] = 'Add-Diamonds';
        return view('admin.diamonds.import', ["data" => $data]);
    }

    public function add() {

        $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
        $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->orderBy('sort_order','asc')->get();
        $attribute_groups = DB::table('attribute_groups')
                ->select('attribute_groups.*','categories.category_type')
                ->join('categories', 'attribute_groups.refCategory_id', '=', 'categories.category_id')
                ->where('attribute_groups.is_active', 1)
                ->where('attribute_groups.is_deleted', 0)
                ->orderBy('attribute_groups.sort_order', 'asc')
                ->get();
        $attribute_array = array();
        foreach ($attribute_groups as $row) {
            if ($row->field_type == 1) {
                array_push($attribute_array, $row->attribute_group_id);
            }
        }
        $attributes = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->whereIn('attribute_group_id', $attribute_array)->get();
        $data['category'] = $categories;
        $data['attribute_groups'] = $attribute_groups;
        $data['attributes'] = $attributes;
        $data['labour_charge_4p'] = $labour_charge_4p->amount;
        $data['labour_charge_rough'] = $labour_charge_rough->amount;
        $data['title'] = 'Add-Diamonds';
        return view('admin.diamonds.add', ["data" => $data]);
    }

    public function save(Request $request) {
//        echo '<pre>';print_r($_REQUEST);die;
        $categories = DB::table('categories')->where('category_id',$request->refCategory_id)->where('is_active', 1)->where('is_deleted', 0)->first();
        $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
        $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
        $refAttribute_grp = DB::table('attribute_groups')->where('refCategory_id',$request->refCategory_id)->where('is_active', 1)->where('is_deleted', 0)->get();

        $batch_array1 = array();
        $i = 0;
        foreach ($request->attribute_group_id as $row) {
            $sts=0;
            foreach ($refAttribute_grp as $row_ag){
                if($row_ag->attribute_group_id==$row){
                    $sts=1;
                }
            }
            if($sts=1){
            $main_value = explode('_', $request->attribute_group_id_value[$i]);
                if (isset($main_value[1])) {
                    if ($main_value[1] == $row) {
                        $refAttribute_id = $main_value[0];
                        array_push($batch_array1, $refAttribute_id);
                    }
                }
            }
            $i = $i + 1;
        }

       $name_data = DB::table('attributes')->select('attributes.name as at_name','attribute_groups.name as ag_name')
               ->leftJoin('attribute_groups', 'attributes.attribute_group_id', '=', 'attribute_groups.attribute_group_id')
               ->whereIn('attributes.attribute_id',$batch_array1)->get();
        $shape='';
        $color='';
        $clarity='';

        if(!empty($name_data)){
            foreach ($name_data as $row){
                if($row->ag_name=='SHAPE'){
                    $shape=$row->at_name.' Shape  • ';
                }                
                if($row->ag_name=='COLOR'){
                    $color=$row->at_name.' Color  • ';
                }               
                if($row->ag_name=='CLARITY'){
                    $clarity=$row->at_name.' Clarity ';
                }                
            }
        }
        $name=$request->expected_polish_cts.' Carat '.$shape.$color.$clarity.':: '.$categories->name;

        if($categories->category_type== config('constant.CATEGORY_TYPE_4P')){

        $categories = DB::table('categories')->where('category_id',$request->refCategory_id)->where('is_active', 1)->where('is_deleted', 0)->first();
            $discount=((100-$request->discount)/100);
            $total=abs($request->rapaport_price * $request->expected_polish_cts * $discount) - ($labour_charge_4p->amount*$request->expected_polish_cts);
        }

        if($categories->category_type== config('constant.CATEGORY_TYPE_ROUGH')){
            
            $discount=((100-$request->discount)/100);
            $price=abs($request->rapaport_price*($discount));
            $amount=abs($price*doubleval($request->expected_polish_cts));
            $ro_amount=abs($amount/doubleval($request->makable_cts));
            $final_price=$ro_amount-$labour_charge_rough->amount;
            $total=abs($final_price*(doubleval($request->makable_cts)));
        }
        if($categories->category_type== config('constant.CATEGORY_TYPE_POLISH')){
            $discount=((100-$request->discount)/100);
            $total=abs($request->rapaport_price*doubleval($request->expected_polish_cts)*$discount);
        }
        $discount=abs(($request->discount)/100);

        $imgData = array();
        if($request->hasfile('image')) {
            $request->validate([
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $i=0;
            foreach($request->file('image') as $file)
            {
                $imageName = time() . $i . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->storeAs("public/other_images", $imageName);
                array_push($imgData,$imageName);
                $i=$i+1;
            }
        }
        $image=json_encode($imgData);

        DB::table('diamonds')->insert([
            'name'=>$name,
            'barcode' => isset($request->barcode) ? $request->barcode : 0,            
            'packate_no' => isset($request->packate_no) ? $request->packate_no : 0,
            'actual_pcs' => isset($request->actual_pcs) ? $request->actual_pcs : 0,
            'available_pcs' => isset($request->available_pcs) ? $request->available_pcs : 0,
            'makable_cts' => isset($request->makable_cts) ? $request->makable_cts : 0,
            'expected_polish_cts' => isset($request->expected_polish_cts) ? $request->expected_polish_cts : 0,
            'remarks' => isset($request->remarks) ? $request->remarks : 0,
            'rapaport_price' => isset($request->rapaport_price) ? $request->rapaport_price : 0,
            'discount' => isset($request->discount) ? $discount : 0,
            'weight_loss' => isset($request->weight_loss) ? $request->weight_loss : 0,
            'video_link' => isset($request->video_link) ? $request->video_link : NULL,
            'image' => $image,
            'refCategory_id' => isset($request->refCategory_id) ? $request->refCategory_id : 0,
            'total'=>$total,
            'added_by' => $request->session()->get('loginId'),
            'is_recommended' => isset($request->is_recommended) ? $request->is_recommended : 0,
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);

        $Id = DB::getPdo()->lastInsertId();
        $batch_array = array();
        $i = 0;
        foreach ($request->attribute_group_id as $row) {

            $sts=0;
            foreach ($refAttribute_grp as $row_ag){
                if($row_ag->attribute_group_id==$row){
                    $sts=1;
                }
            }
            if($sts=1){

                $insert_array = array();
                $insert_array['refDiamond_id'] = $Id;
                $insert_array['refAttribute_group_id'] = $row;
                $main_value = explode('_', $request->attribute_group_id_value[$i]);
                if (isset($main_value[1])) {
                    if ($main_value[1] == $row) {
                        $insert_array['refAttribute_id'] = $main_value[0];
                        $insert_array['value'] = 0;
                    }
                } else {
                    $insert_array['refAttribute_id'] = 0;
                    $insert_array['value'] = $request->attribute_group_id_value[$i];
                }
                if($request->attribute_group_id_value[$i]!='' && $request->attribute_group_id_value[$i]!='default'){
                    array_push($batch_array, $insert_array);
                }
            }
            $i = $i + 1;
        }
        if (!empty($batch_array)) {
            DB::table('diamonds_attributes')->insert($batch_array);
        }
        activity($request, "inserted", 'diamonds',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/diamonds/list/'.$request->refCategory_id);
    }

    public function list(Request $request) {
//        print_r($request->refCategory_id);die;
        if ($request->ajax()) {
            $data = DB::table('diamonds')->select('diamonds.*', 'categories.name as category_name')->leftJoin('categories', 'diamonds.refCategory_id', '=', 'categories.category_id')->where('refCategory_id', $request->refCategory_id)->orderBy('diamond_id', 'desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('date_added', function ($row) {
                                return date_formate($row->date_added);
                            })
                            ->editColumn('discount', function ($row) {
                                return ($row->discount*100);
                            })
                            ->editColumn('total', function ($row) {
                                return round($row->total,2);
                            })
                            ->editColumn('weight_loss', function ($row) {
                                return round($row->weight_loss,2);
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
                                $actionBtn = '<a href="/admin/diamonds/edit/' . $row->diamond_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="diamonds" data-id="' . $row->diamond_id . '" data-table="diamonds" data-wherefield="diamond_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->diamond_id . '" data-status="' . $row->is_active . '" data-table="diamonds" data-wherefield="diamond_id" data-module="diamonds">' . $str . '</button>';                               
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
        $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
        $result = DB::table('diamonds')->where('diamond_id', $id)->first();
        $diamond_attributes = DB::table('diamonds_attributes')->where('refDiamond_id', $id)->get();
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->orderBy('sort_order','asc')->get();
        $attribute_groups = DB::table('attribute_groups')
                ->select('attribute_groups.*','categories.category_type')
                ->join('categories', 'attribute_groups.refCategory_id', '=', 'categories.category_id')
                ->where('attribute_groups.is_active', 1)
                ->where('attribute_groups.is_deleted', 0)
                ->orderBy('attribute_groups.sort_order', 'asc')
                ->get();
        $attribute_array = array();
        foreach ($attribute_groups as $row) {
            if ($row->field_type == 1) {
                array_push($attribute_array, $row->attribute_group_id);
            }
        }
        $attributes = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->whereIn('attribute_group_id', $attribute_array)->get();
        $data['category'] = $categories;
        $data['attribute_groups'] = $attribute_groups;
        $data['attributes'] = $attributes;

        $data['diamond_attributes'] = $diamond_attributes;
        $data['labour_charge_4p'] = $labour_charge_4p->amount;
        $data['labour_charge_rough'] = $labour_charge_rough->amount;
        $data['title'] = 'Edit-Diamonds';
        $data['result'] = $result;
        return view('admin.diamonds.edit', ["data" => $data]);
    }

    public function update(Request $request) {

        $categories = DB::table('categories')->where('category_id',$request->refCategory_id)->where('is_active', 1)->where('is_deleted', 0)->first();
        $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
        $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();



        $refAttribute_grp = DB::table('attribute_groups')->where('refCategory_id',$request->refCategory_id)->where('is_active', 1)->where('is_deleted', 0)->get();
        $batch_array1 = array();
        $i = 0;
        foreach ($request->attribute_group_id as $row) {
            $sts=0;
            foreach ($refAttribute_grp as $row_ag){
                if($row_ag->attribute_group_id==$row){
                    $sts=1;
                }
            }
            if($sts=1){
            $main_value = explode('_', $request->attribute_group_id_value[$i]);
                if (isset($main_value[1])) {
                    if ($main_value[1] == $row) {
                        $refAttribute_id = $main_value[0];
                        array_push($batch_array1, $refAttribute_id);
                    }
                }
            }
            $i = $i + 1;
        }

        $name_data = DB::table('attributes')->select('attributes.name as at_name','attribute_groups.name as ag_name')
               ->leftJoin('attribute_groups', 'attributes.attribute_group_id', '=', 'attribute_groups.attribute_group_id')
               ->whereIn('attributes.attribute_id',$batch_array1)->get();
        $shape='';
        $color='';
        $clarity='';

        if(!empty($name_data)){
            foreach ($name_data as $row){
                if($row->ag_name=='SHAPE'){
                    $shape=$row->at_name.' Shape  • ';
                }                
                if($row->ag_name=='COLOR'){
                    $color=$row->at_name.' Color  • ';
                }                
                if($row->ag_name=='CLARITY'){
                    $clarity=$row->at_name.' Clarity ';
                }               
            }
        }
        $name=$request->expected_polish_cts.' Carat '.$shape.$color.$clarity.':: '.$categories->name;


        if($categories->category_type== config('constant.CATEGORY_TYPE_4P')){
            $discount=((100-$request->discount)/100);
            $total=abs($request->rapaport_price * $request->expected_polish_cts * $discount) - ($labour_charge_4p->amount*$request->expected_polish_cts);
        }

        if($categories->category_type== config('constant.CATEGORY_TYPE_ROUGH')){
            $discount=((100-$request->discount)/100);
            $price=abs($request->rapaport_price*($discount));
            $amount=abs($price*doubleval($request->expected_polish_cts));
            $ro_amount=abs($amount/doubleval($request->makable_cts));
            $final_price=$ro_amount-$labour_charge_rough->amount;
            $total=abs($final_price*(doubleval($request->makable_cts)));
        }        
        $discount=abs(($request->discount)/100);     
        if($categories->category_type== config('constant.CATEGORY_TYPE_POLISH')){
            $total=abs($request->rapaport_price*doubleval($request->expected_polish_cts) * ($discount-1));
        }
//        $discount=abs(($request->discount)/100);

        $imgData = array();
        if($request->hasfile('image')) {
            $request->validate([
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $i=0;
            $exist_file = DB::table('attributes')->where('attribute_id', $request->id)->first();
            foreach($request->file('image') as $file)
            {
                if ($exist_file) {
                    $arr_imgs = json_decode($exist_file->image);
                    if (count($arr_imgs)) {
                        foreach ($arr_imgs as $v) {
                            unlink(base_path('/storage/app/public/other_images/' . $v));
                        }
                    }
                }
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->storeAs("public/other_images", $imageName);
                array_push($imgData,$imageName);
                $i=$i+1;
            }
        }
        $image=json_encode($imgData);


        DB::table('diamonds')->where('diamond_id', $request->id)->update([
            'name' => $name,
            'barcode' => isset($request->barcode) ? $request->barcode : 0,
            'packate_no' => isset($request->packate_no) ? $request->packate_no : 0,
            'actual_pcs' => isset($request->actual_pcs) ? $request->actual_pcs : 0,
            'available_pcs' => isset($request->available_pcs) ? $request->available_pcs : 0,
            'makable_cts' => isset($request->makable_cts) ? $request->makable_cts : 0,
            'expected_polish_cts' => isset($request->expected_polish_cts) ? $request->expected_polish_cts : 0,
            'remarks' => isset($request->remarks) ? $request->remarks : 0,
            'rapaport_price' => isset($request->rapaport_price) ? $request->rapaport_price : 0,
            'discount' => isset($request->discount) ? $discount : 0,
            'weight_loss' => isset($request->weight_loss) ? $request->weight_loss : 0,
            'image' => $image,
            'is_recommended' => isset($request->is_recommended) ? $request->is_recommended : 0,
            'video_link' => isset($request->video_link) ? $request->video_link : NULL,
            'refCategory_id' => isset($request->refCategory_id) ? $request->refCategory_id : 0,
            'total'=>$total,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        $Id = $request->id;
        $res = DB::table('diamonds_attributes')->where('refDiamond_id', $Id)->delete();
        $batch_array = array();
        $i = 0;
        foreach ($request->attribute_group_id as $row) {
            $insert_array = array();
            $insert_array['refDiamond_id'] = $Id;
            $insert_array['refAttribute_group_id'] = $row;
            $main_value = explode('_', $request->attribute_group_id_value[$i]);
            if (isset($main_value[1])) {
                if ($main_value[1] == $row) {
                    $insert_array['refAttribute_id'] = $main_value[0];
                    $insert_array['value'] = 0;
                }
            } else {
                $insert_array['refAttribute_id'] = 0;
                $insert_array['value'] = $request->attribute_group_id_value[$i];
            }
            if($request->attribute_group_id_value[$i]!='' && $request->attribute_group_id_value[$i]!='default'){
                array_push($batch_array, $insert_array);
            }
            $i = $i + 1;
        }
        if (!empty($batch_array)) {
            DB::table('diamonds_attributes')->insert($batch_array);
        }

        activity($request, "updated", 'diamonds',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/diamonds/list/'.$request->refCategory_id);
    }

    public function delete(Request $request) {
        if (isset($_REQUEST['table_id'])) {

            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request, "deleted", $_REQUEST['module'],$_REQUEST['table_id']);
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
                'date_updated' => date("Y-m-d h:i:s")
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
            activity($request, "updated",$_REQUEST['module'],$_REQUEST['table_id']);
            return response()->json($data);
        }
    }

}
