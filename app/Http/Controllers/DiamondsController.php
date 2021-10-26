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
        $data['title'] = 'List-Diamonds';
        $data['cat_id'] = $cat_id;
        return view('admin.diamonds.list', ["data" => $data]);
    }   

    public function fileImport(Request $request) {
        $res = Excel::toArray(new DiamondsImport, request()->file('file'));        
        $attribute_groups = DB::table('attribute_groups')->where('is_active', 1)->where('refCategory_id', $request->refCategory_id)->where('is_deleted', 0)->get();
//        echo '<pre>';print_r($attribute_groups);die;        
        $attr_group_array = array();
        if (!empty($res)) {
//            foreach ($res as $row_1) {
            foreach ($res[0] as $row) {
                if (isset($row['barcode'])) {
                    $barcode=DB::table('diamonds')->where('barcode', $row['barcode'])->first();
                    if (empty($row['barcode'])) {
                        //update ni query karvani
                        break;
                    }
                    if(empty($barcode)){                       
                        if (!empty($row['barcode'])) {
                        $row['rapa'] = str_replace(',', '', $row['rapa']);
                        $row['discount'] = str_replace('-', '', $row['discount']);
                        $row['weight_loss'] = str_replace('-', '', $row['weight_loss']);
                        $row['rapa'] = doubleval($row['rapa']);
                        $row['discount'] = doubleval($row['discount']);
                        $row['weight_loss'] = 100-((doubleval($row['exp_pol_cts'])*100)/doubleval($row['mkbl_cts']));                                                
                        
                        $data_array = [
                            'barcode' => strval($row['barcode']),
                            'packate_no' => strval($row['main_pktno']),
                            'actual_pcs' => doubleval($row['pcs']),
                            'available_pcs' => doubleval($row['pcs']),
                            'makable_cts' => doubleval($row['mkbl_cts']),
                            'expected_polish_cts' => doubleval($row['exp_pol_cts']),
                            'remarks' => strval($row['remarks']),
                            'rapaport_price' => $row['rapa'],
                            'discount' => $row['discount'],
                            'weight_loss' => $row['weight_loss'],
                            'video_link' => strval($row['video_link']),
                            'image' => 0,
                            'refCategory_id' => $request->refCategory_id,
                            'added_by' => session()->get('loginId'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                            'date_added' => date("Y-m-d h:i:s"),
                            'date_updated' => date("Y-m-d h:i:s")
                        ];
                        DB::table('diamonds')->insert($data_array);
                        $Id = DB::getPdo()->lastInsertId();

//                    shape
//                    exp_pol_size
//                    color
//                    clarity
//                    half_cut_dia
//                    half_cut_hgt
//                    po_diameter

                        foreach ($attribute_groups as $atr_grp_row) {
                            $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();
                            if ($atr_grp_row->name === "HALF-CUT DIA") {
                                if(!empty($row['half_cut_dia'])){
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['half_cut_dia'];
                                array_push($attr_group_array, $insert_array);
                                }
                            }
                            if ($atr_grp_row->name === "PO. DIAMETER") {
                                if(!empty($row['po_diameter'])){
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['po_diameter'];
                                array_push($attr_group_array, $insert_array);
                                }
                            }
                            if ($atr_grp_row->name === "HALF-CUT HGT") {
                                 if(!empty($row['half_cut_hgt'])){
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['half_cut_hgt'];
                                array_push($attr_group_array, $insert_array);
                                 }
                            }
                            if ($atr_grp_row->name === "EXP POL SIZE") {
                                 if(!empty($row['exp_pol_size'])){
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['exp_pol_size'];
                                array_push($attr_group_array, $insert_array);
                                 }
                            }
                            if ($atr_grp_row->name === "SHAPE") {
                                if(!empty($row['shape'])){
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
                                 if(!empty($row['color'])){
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
                            if ($atr_grp_row->name === "CLARITY") {
                                if(!empty($row['clarity'])){
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
                        }
                    }
                    }
                }
                if (isset($row['stock'])) {                
                    if (empty($row['stock']) || $row['stock'] == 'TOTAL' || $row['stock'] == 'total' || $row['stock'] == 'Total') {                        
                        break;
                    }                    
                    if (!empty($row['stock'])) {                        
//                        $row['rap'] = str_replace(',', '', $row['rap']);
                        $row['discount_percent'] = str_replace('-', '', $row['discount_percent']);
//                        $row['rap'] = doubleval($row['rap']);
                        $row['discount_percent'] = doubleval($row['discount_percent']);
                        if(empty($row['image_link'])){
                            $image=0;
                        }else{
                            $image=$row['image_link'];
                        }
                        $data_array = [                                                                                                                
                            'discount' => $row['discount_percent'],
                            'image' => $image,
                            'video_link' => $row['video_link'],
                            'refCategory_id' => $request->refCategory_id,
                            'added_by' => session()->get('loginId'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                            'date_added' => date("Y-m-d h:i:s"),
                            'date_updated' => date("Y-m-d h:i:s")
                        ];
                        DB::table('diamonds')->insert($data_array);
                        $Id = DB::getPdo()->lastInsertId();

                        foreach ($attribute_groups as $atr_grp_row) {                            
                            $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();

                            if ($atr_grp_row->name === "WEIGHT") {
                                if(!empty($row['weight'])){
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['weight'];
                                array_push($attr_group_array, $insert_array);
                                }
                            }
                                                        
                             if ($atr_grp_row->name === "DEPTH PERCENT") {                                 
                                if(!empty($row['depth_percent'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['depth_percent'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                                                 
                            }
                            
                            if ($atr_grp_row->name === "TABLE PERCENT") {
                                
                                if(!empty($row['table_percent'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['table_percent'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                                                                                 
                            }
                            
                             if ($atr_grp_row->name === "CERTIFICATE") {
                                 
                                  if(!empty($row['certificate'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['certificate'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                 
                            }
                            
                            if ($atr_grp_row->name === "GIRDLE PERCENT") {
                                
                                 if(!empty($row['girdle_percent'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['girdle_percent'];
                                    array_push($attr_group_array, $insert_array);
                                }                                   
                            }
                            
                            
                            if ($atr_grp_row->name === "PAVILION DEPTH") {
                                
                                 if(!empty($row['pavilion_depth'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['pavilion_depth'];
                                    array_push($attr_group_array, $insert_array);
                                }   
                            }
                            if ($atr_grp_row->name === "CROWN HEIGHT") {
                                
                                 if(!empty($row['crown_height'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['crown_height'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                 
                            }
                            if ($atr_grp_row->name === "CROWN ANGLE") {
                                
                                 if(!empty($row['crown_angle'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['crown_angle'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                 
                            }
                            if ($atr_grp_row->name === "PAVILION ANGLE") {
                                
                                if(!empty($row['pavilion_angle'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['pavilion_angle'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                 
                            }
                            if ($atr_grp_row->name === "GROWTH TYPE") {
                                
                                 if(!empty($row['growth_type'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['growth_type'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                 
                            }
                            
                            if ($atr_grp_row->name === "MEASUREMENTS") {
                                 if(!empty($row['measurements'])){
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['measurements'];
                                array_push($attr_group_array, $insert_array);  
                                 }
                            } 
                                                                                    
                            if ($atr_grp_row->name === "CERTIFICATE URL") {
                                 if(!empty($row['certificate_url'])){
                                    $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['certificate_url'];
                                array_push($attr_group_array, $insert_array);
                                 }
                            }
                           
                            if ($atr_grp_row->name === "STOCK") {                                
                                  if(!empty($row['stock'])){
                                    $insert_array = array();
                                    $insert_array['refDiamond_id'] = $Id;
                                    $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                    $insert_array['refAttribute_id'] = 0;
                                    $insert_array['value'] = $row['stock'];
                                    array_push($attr_group_array, $insert_array);
                                }                                                                                              
                            }
                            if ($atr_grp_row->name === "AVAILABILITY") {
                                if(!empty($row['availability'])){
                                $availability = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['availability'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $availability = 1;
                                    }
                                }
                                if ($availability == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['availability'],
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
                                if(!empty($row['shape'])){
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
                                }}
                            }
                            if ($atr_grp_row->name === "CLARITY") {
                                if(!empty($row['clarity'])){
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
                                if(!empty($row['color'])){
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
                                }}
                            }

                            if ($atr_grp_row->name === "CUT GRADE") {
                                
                                if(!empty($row['cut_grade'])){
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
                                if(!empty($row['polish'])){
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
                                if(!empty($row['symmetry'])){
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
                                if(!empty($row['lab'])){
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
                                if(!empty($row['culet_size'])){
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
                                if(!empty($row['girdle_condition'])){
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
                
                if (isset($row['pktno'])) {
                    if (empty($row['pktno']) || $row['pktno'] == 'TOTAL' || $row['pktno'] == 'total' || $row['pktno'] == 'Total') {
                        break;
                    }
                    if (!empty($row['pktno'])) {
                        $row['rap'] = str_replace(',', '', $row['rap']);
                        $row['dis'] = str_replace('-', '', $row['dis']);
                        $row['rap'] = doubleval($row['rap']);
                        $row['dis'] = doubleval($row['dis']);

                        $data_array = [
                            'packate_no' => strval($row['pktno']),
                            'makable_cts' => doubleval($row['org_cts']),
                            'expected_polish_cts' => doubleval($row['exp_pol']),
                            'rapaport_price' => $row['rap'],
                            'discount' => $row['dis'],
                            'refCategory_id' => $request->refCategory_id,
                            'added_by' => session()->get('loginId'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                            'date_added' => date("Y-m-d h:i:s"),
                            'date_updated' => date("Y-m-d h:i:s")
                        ];
                        DB::table('diamonds')->insert($data_array);
                        $Id = DB::getPdo()->lastInsertId();
//                        print_r($attribute_groups);die;
                        foreach ($attribute_groups as $atr_grp_row) {
                            
                            $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();
                            if ($atr_grp_row->name === "PURITY") { 
                                if(!empty($row['purity'])){
                                $purity = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['purity'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $purity = 1;
                                    }
                                }
                                if ($purity == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['purity'],
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
                                if(!empty($row['shape'])){
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
        return redirect('admin/diamonds');
    }

    public function addExcel() {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();       
        $data['category'] = $categories;              
        $data['title'] = 'Add-Diamonds';
        return view('admin.diamonds.import', ["data" => $data]);
    }
    public function add() {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
        $attribute_groups = DB::table('attribute_groups')->where('is_active', 1)->where('is_deleted', 0)->get();
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
        $data['title'] = 'Add-Diamonds';
        return view('admin.diamonds.add', ["data" => $data]);
    }

    public function save(Request $request) {
        echo '<pre>';print_r($_REQUEST);die;
        $imageName=0;
        if (isset($request->image)) {
        
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        DB::table('diamonds')->insert([           
            'name' => isset($request->name) ? $request->name : 0,
            'barcode' => isset($request->barcode) ? $request->barcode : 0,
            'packate_no' => isset($request->packate_no) ? $request->packate_no : 0,
            'actual_pcs' => isset($request->actual_pcs) ? $request->actual_pcs : 0,
            'available_pcs' => isset($request->available_pcs) ? $request->available_pcs : 0,
            'makable_cts' => isset($request->makable_cts) ? $request->makable_cts : 0,
            'expected_polish_cts' => isset($request->expected_polish_cts) ? $request->expected_polish_cts : 0,
            'remarks' => isset($request->remarks) ? $request->remarks : 0,
            'rapaport_price' => isset($request->rapaport_price) ? $request->rapaport_price : 0,
            'discount' => isset($request->discount) ? $request->discount : 0,
            'weight_loss' => isset($request->weight_loss) ? $request->weight_loss : 0,
            'video_link' => isset($request->video_link) ? $request->video_link : 0,
            'image' => $imageName,
            'refCategory_id' => isset($request->refCategory_id) ? $request->refCategory_id : 0,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")            
        ]);

        $Id = DB::getPdo()->lastInsertId();
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
            array_push($batch_array, $insert_array);
            $i = $i + 1;
        }
        if (!empty($batch_array)) {
            DB::table('diamonds_attributes')->insert($batch_array);
        }
        activity($request, "inserted", 'diamonds');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('diamonds');
    }

    public function list(Request $request) {
//        print_r($request->refCategory_id);die;
        if ($request->ajax()) {            
            $data = DB::table('diamonds')->select('diamonds.*', 'categories.name as category_name')->leftJoin('categories', 'diamonds.refCategory_id', '=', 'categories.category_id')->where('refCategory_id',$request->refCategory_id)->orderBy('diamond_id', 'desc')->get();
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
        $result = DB::table('diamonds')->where('diamond_id', $id)->first();       
        $diamond_attributes = DB::table('diamonds_attributes')->where('refDiamond_id', $id)->get();
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
        $attribute_groups = DB::table('attribute_groups')->where('is_active', 1)->where('refCategory_id', $result->refCategory_id)->where('is_deleted', 0)->get();
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
       
        $data['title'] = 'Edit-Diamonds';
        $data['result'] = $result;
        return view('admin.diamonds.edit', ["data" => $data]);
    }

    public function update(Request $request) {         
        $imageName=0;
        if (isset($request->image)) {        
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        DB::table('diamonds')->where('diamond_id', $request->id)->update([
            'name' => isset($request->name) ? $request->name : 0,
            'barcode' => isset($request->barcode) ? $request->barcode : 0,
            'packate_no' => isset($request->packate_no) ? $request->packate_no : 0,
            'actual_pcs' => isset($request->actual_pcs) ? $request->actual_pcs : 0,
            'available_pcs' => isset($request->available_pcs) ? $request->available_pcs : 0,
            'makable_cts' => isset($request->makable_cts) ? $request->makable_cts : 0,
            'expected_polish_cts' => isset($request->expected_polish_cts) ? $request->expected_polish_cts : 0,
            'remarks' => isset($request->remarks) ? $request->remarks : 0,
            'rapaport_price' => isset($request->rapaport_price) ? $request->rapaport_price : 0,
            'discount' => isset($request->discount) ? $request->discount : 0,
            'weight_loss' => isset($request->weight_loss) ? $request->weight_loss : 0,
            'image' => $imageName,
            'video_link' => isset($request->video_link) ? $request->video_link : 0,           
            'refCategory_id' => isset($request->refCategory_id) ? $request->refCategory_id : 0,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
//        echo '<pre>';print_r($_REQUEST);die;
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
            array_push($batch_array, $insert_array);
            $i = $i + 1;
        }
        if (!empty($batch_array)) {
            DB::table('diamonds_attributes')->insert($batch_array);
        }

        activity($request, "updated", 'diamonds');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/diamonds');
    }

    public function delete(Request $request) {
        if (isset($_REQUEST['table_id'])) {

            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
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
            activity($request, "updated", $_REQUEST['module']);
            return response()->json($data);
        }
    }

}
