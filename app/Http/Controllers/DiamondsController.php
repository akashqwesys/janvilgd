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

    public function index() {
        $data['title'] = 'List-Diamonds';
        return view('admin.diamonds.list', ["data" => $data]);
    }

    public function fileImport(Request $request) {
        $res = Excel::toArray(new DiamondsImport, request()->file('file'));
        $attribute_groups = DB::table('attribute_groups')->where('is_active', 1)->where('refCategory_id', $request->refCategory_id)->where('is_deleted', 0)->get();
//        echo '<pre>';print_r($res);die;        
        $attr_group_array = array();
        if (!empty($res)) {
//            foreach ($res as $row_1) {
            foreach ($res[0] as $row) {
                if (isset($row['barcode'])) {
                    if (empty($row['barcode'])) {
                        break;
                    }
                    if (!empty($row['barcode'])) {
                        $row['rapa'] = str_replace(',', '', $row['rapa']);
                        $row['discount'] = str_replace('-', '', $row['discount']);
                        $row['weight_loss'] = str_replace('-', '', $row['weight_loss']);
                        $row['rapa'] = doubleval($row['rapa']);
                        $row['discount'] = doubleval($row['discount']);
                        $row['weight_loss'] = doubleval($row['weight_loss']);

                        $data_array = [
                            'barcode' => strval($row['barcode']),
                            'packate_no' => strval($row['main_pktno']),
                            'actual_pcs' => doubleval($row['pcs']),
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
                            'date_added' => date("yy-m-d h:i:s"),
                            'date_updated' => date("yy-m-d h:i:s")
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
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['half_cut_dia'];
                                array_push($attr_group_array, $insert_array);
                            }
                            if ($atr_grp_row->name === "PO. DIAMETER") {
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['po_diameter'];
                                array_push($attr_group_array, $insert_array);
                            }
                            if ($atr_grp_row->name === "HALF-CUT HGT") {
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['half_cut_hgt'];
                                array_push($attr_group_array, $insert_array);
                            }
                            if ($atr_grp_row->name === "EXP POL SIZE") {
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['exp_pol_size'];
                                array_push($attr_group_array, $insert_array);
                            }
                            if ($atr_grp_row->name === "SHAPE") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "COLOR") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "CLARITY") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            'date_added' => date("yy-m-d h:i:s"),
                            'date_updated' => date("yy-m-d h:i:s")
                        ];
                        DB::table('diamonds')->insert($data_array);
                        $Id = DB::getPdo()->lastInsertId();

                        foreach ($attribute_groups as $atr_grp_row) {
                            $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();

                            if ($atr_grp_row->name === "WEIGHT") {
                                $insert_array = array();
                                $insert_array['refDiamond_id'] = $Id;
                                $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                $insert_array['refAttribute_id'] = 0;
                                $insert_array['value'] = $row['weight'];
                                array_push($attr_group_array, $insert_array);
                            }


                            if ($atr_grp_row->name === "STOCK") {
                                $stock = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['stock'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $stock = 1;
                                    }
                                }
                                if ($stock == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['stock'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "AVAILABILITY") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "SHAPE") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "CLARITY") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "COLOR") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "CUT GRADE") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "POLISH") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "SYMMETRY") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "DEPTH PERCENT") {
                                $depth_percent = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['depth_percent'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $depth_percent = 1;
                                    }
                                }
                                if ($depth_percent == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['depth_percent'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "TABLE PERCENT") {
                                $table_percent = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['table_percent'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $table_percent = 1;
                                    }
                                }
                                if ($table_percent == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['table_percent'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "CERTIFICATE") {
                                $certificate = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['certificate'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $certificate = 1;
                                    }
                                }
                                if ($certificate == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['certificate'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "CERTIFICATE URL") {
                                $certificate_url = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['certificate_url'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $certificate_url = 1;
                                    }
                                }
                                if ($certificate_url == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['certificate_url'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "CULET SIZE") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "GIRDLE PERCENT") {
                                $girdle_percent = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['girdle_percent'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $girdle_percent = 1;
                                    }
                                }
                                if ($girdle_percent == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['girdle_percent'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "GRIDLE CONDITION") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "MEASUREMENTS") {
                                $measurements = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['measurements'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $measurements = 1;
                                    }
                                }
                                if ($measurements == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['measurements'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "PAVILION DEPTH") {
                                $pavilion_depth = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['pavilion_depth'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $pavilion_depth = 1;
                                    }
                                }
                                if ($pavilion_depth == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['pavilion_depth'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "CROWN HEIGHT") {
                                $crown_height = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['crown_height'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $crown_height = 1;
                                    }
                                }
                                if ($crown_height == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['crown_height'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "CROWN ANGLE") {
                                $crown_angle = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['crown_angle'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $crown_angle = 1;
                                    }
                                }
                                if ($crown_angle == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['crown_angle'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "PAVILION ANGLE") {
                                $pavilion_angle = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['pavilion_angle'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $pavilion_angle = 1;
                                    }
                                }
                                if ($pavilion_angle == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['pavilion_angle'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
                            if ($atr_grp_row->name === "GROWTH TYPE") {
                                $growth_type = 0;
                                foreach ($attribute as $atr_row) {
                                    if ($atr_row->name == $row['growth_type'] && $atr_grp_row->attribute_group_id == $atr_row->attribute_group_id) {
                                        $insert_array = array();
                                        $insert_array['refDiamond_id'] = $Id;
                                        $insert_array['refAttribute_group_id'] = $atr_grp_row->attribute_group_id;
                                        $insert_array['refAttribute_id'] = $atr_row->attribute_id;
                                        $insert_array['value'] = 0;
                                        array_push($attr_group_array, $insert_array);
                                        $growth_type = 1;
                                    }
                                }
                                if ($growth_type == 0) {
                                    DB::table('attributes')->insert([
                                        'name' => $row['growth_type'],
                                        'attribute_group_id' => $atr_grp_row->attribute_group_id,
                                        'added_by' => $request->session()->get('loginId'),
                                        'is_active' => 1,
                                        'is_deleted' => 0,
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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


                if (isset($row['stock'])) {
                    if (empty($row['stock']) || $row['stock'] == 'TOTAL' || $row['stock'] == 'total' || $row['stock'] == 'Total') {
                        break;
                    }
                    if (!empty($row['stock'])) {
//                        $row['rap'] = str_replace(',', '', $row['rap']);
                        $row['discount_percent'] = str_replace('-', '', $row['discount_percent']);
//                        $row['rap'] = doubleval($row['rap']);
                        $row['discount_percent'] = doubleval($row['discount_percent']);

                        $data_array = [
                            'discount' => $row['discount_percent'],
                            'image' => $row['image_link'],
                            'video_link' => $row['video_link'],
                            'refCategory_id' => $request->refCategory_id,
                            'added_by' => session()->get('loginId'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                            'date_added' => date("yy-m-d h:i:s"),
                            'date_updated' => date("yy-m-d h:i:s")
                        ];
                        DB::table('diamonds')->insert($data_array);
                        $Id = DB::getPdo()->lastInsertId();

                        foreach ($attribute_groups as $atr_grp_row) {
                            $attribute = DB::table('attributes')->where('is_active', 1)->where('is_deleted', 0)->get();
                            if ($atr_grp_row->name === "PURITY") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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

                            if ($atr_grp_row->name === "SHAPE") {
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
                                        'date_added' => date("yy-m-d h:i:s"),
                                        'date_updated' => date("yy-m-d h:i:s")
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
        if (!empty($attr_group_array)) {
            DB::table('diamonds_attributes')->insert($attr_group_array);
        }

        activity($request, "inserted", 'diamonds');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/diamonds');
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

//        echo get_rapaport_price();die;

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        DB::table('diamonds')->insert([
            'name' => $request->name,
            'barcode' => $request->barcode,
            'packate_no' => $request->packate_no,
            'actual_pcs' => $request->actual_pcs,
            'available_pcs' => $request->available_pcs,
            'makable_cts' => $request->makable_cts,
            'expected_polish_cts' => $request->expected_polish_cts,
            'remarks' => $request->remarks,
            'rapaport_price' => $request->rapaport_price,
            'discount' => $request->discount,
            'weight_loss' => $request->weight_loss,
            'video_link' => $request->video_link,
            'image' => $imageName,
            'refCategory_id' => $request->refCategory_id,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
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
        if ($request->ajax()) {
            $data = DB::table('diamonds')->select('diamonds.*', 'categories.name as category_name')->leftJoin('categories', 'diamonds.refCategory_id', '=', 'categories.category_id')->orderBy('diamond_id', 'desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
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
                                $actionBtn = '<a href="/diamonds/edit/' . $row->diamond_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="diamonds" data-id="' . $row->diamond_id . '" data-table="diamonds" data-wherefield="diamond_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->diamond_id . '" data-status="' . $row->is_active . '" data-table="diamonds" data-wherefield="diamond_id" data-module="diamonds">' . $str . '</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {

        $diamond_attributes = DB::table('diamonds_attributes')->where('refDiamond_id', $id)->get();
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

        $data['diamond_attributes'] = $diamond_attributes;
        $result = DB::table('diamonds')->where('diamond_id', $id)->first();
        $data['title'] = 'Edit-Diamonds';
        $data['result'] = $result;
        return view('admin.diamonds.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        if (isset($request->image)) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            DB::table('diamonds')->where('diamond_id', $request->id)->update([
                'name' => $request->name,
                'barcode' => $request->barcode,
                'packate_no' => $request->packate_no,
                'actual_pcs' => $request->actual_pcs,
                'available_pcs' => $request->available_pcs,
                'makable_cts' => $request->makable_cts,
                'expected_polish_cts' => $request->expected_polish_cts,
                'remarks' => $request->remarks,
                'rapaport_price' => $request->rapaport_price,
                'discount' => $request->discount,
                'weight_loss' => $request->weight_loss,
                'video_link' => $request->video_link,
                'image' => $imageName,
                'refCategory_id' => $request->refCategory_id,
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        } else {
            DB::table('diamonds')->where('diamond_id', $request->id)->update([
                'name' => $request->name,
                'barcode' => $request->barcode,
                'packate_no' => $request->packate_no,
                'actual_pcs' => $request->actual_pcs,
                'available_pcs' => $request->available_pcs,
                'makable_cts' => $request->makable_cts,
                'expected_polish_cts' => $request->expected_polish_cts,
                'remarks' => $request->remarks,
                'rapaport_price' => $request->rapaport_price,
                'discount' => $request->discount,
                'weight_loss' => $request->weight_loss,
                'video_link' => $request->video_link,
                'refCategory_id' => $request->refCategory_id,
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        }

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
        return redirect('diamonds');
    }

    public function delete(Request $request) {
        if (isset($_REQUEST['table_id'])) {

            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("yy-m-d h:i:s")
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
                'date_updated' => date("yy-m-d h:i:s")
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
