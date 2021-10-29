<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use App\Mail\EmailVerification;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DiamondController extends Controller
{
    use APIResponse;

    public function getAttributes(Request $request)
    {
        $data = DB::table('attributes as a')
            ->join('attribute_groups as ag', 'a.attribute_group_id', '=', 'ag.attribute_group_id')
            ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image')
            ->orderBy('attribute_group_id')
            ->get()
            ->toArray();
        $attr_groups = collect($data)->pluck('attribute_group_id')->unique()->values()->all();
        $j = 0;
        $attr = [];
        foreach ($data as $v) {
            if ($attr_groups[$j] == $v->attribute_group_id) {
                $attr[$attr_groups[$j]]['name'] = $v->ag_name;
                $attr[$attr_groups[$j]]['attributes'][] = [
                    'attribute_id' => $v->attribute_id,
                    'name' => $v->name,
                    'image' => $v->image
                ];
            } else {
                $j++;
                $attr[$attr_groups[$j]]['name'] = $v->ag_name;
                $attr[$attr_groups[$j]]['attributes'][] = [
                    'attribute_id' => $v->attribute_id,
                    'name' => $v->name,
                    'image' => $v->image
                ];
            }
        }
        return $this->successResponse('Success', $attr);
    }

    public function searchDiamonds(Request $request)
    {
        $response = $request->all();
        $attribute_groups = array_keys($response);

        $attr = [];
        foreach ($attribute_groups as $a) {
            $attr[$a] = collect($response[$a])->values()->all();
        }

        $attribute_ids = [];
        foreach ($attr as $a) {
            $attribute_ids = array_merge($attribute_ids, array_values($a));
        }

        $attrg_attr = [];
        foreach ($response as $k => $v) {
            foreach ($v as $v_row) {
                $dummy_array=array();
                $dummy_array['ag']=$k;
                $dummy_array['atr']=$v_row;
                array_push($attrg_attr, $dummy_array);
            }
        }

        $q = null;
        foreach ($attrg_attr as $v) {
            $q .= '("da"."refAttribute_group_id" = ' . $v['ag'] . ' and "da"."refAttribute_id" = ' . $v['atr'] . ' and ';
            $q .= '"ag"."attribute_group_id" = ' . $v['ag'] . ' and ';
            $q .= '"a"."attribute_id" = ' . $v['atr'] . ') or ';
        }

        $diamond_ids = DB::table('diamonds as d')
            ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('d.diamond_id', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price','a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name')
            ->whereRaw(rtrim($q, 'or '))
            ->where('da.refAttribute_id', '<>', 0)
            ->where('d.is_active', 1)
            ->where('d.is_deleted', 0)
            // ->groupBy('d.diamond_id')
            ->orderBy('d.diamond_id', 'desc')
            ->get()
            // ->pluck('diamond_id')
            ->toArray();
        dd($diamond_ids);
        $final_d = [];
        $final_d2 = [];
        $k=0;

        $diamond_id_array=array();
        foreach ($diamond_ids as $v_row) {
            array_push($diamond_id_array, $v_row->diamond_id);
        }
        $diamond_id_array = array_unique($diamond_id_array);

        $final_d[0]=$diamond_ids[0];

        foreach ($diamond_ids as $v_row) {
            foreach ($diamond_id_array as $dim_row) {
                if($dim_row==$v_row->diamond_id){
                    $i=0;
                    $v_row->{$v_row->ag_name} = $v_row->name;
                    if(!empty($final_d)){
                        foreach ($final_d as $f_row) {
                            if($f_row->diamond_id == $dim_row){
                                $f_row->{$v_row->ag_name} = $v_row->name;
                                $i=1;
                            }
                        }
                    }
                    if($i==0){
                        array_push($final_d, $v_row);
                    }
                }
            }
        }
        // die;
        dd($diamond_ids);

        /* $data = DB::table('diamonds as d')
            ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->select('da.refAttribute_id', 'd.diamond_id', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price')
            ->whereRaw(rtrim($q, 'or '))
            ->where('da.refAttribute_id', '<>', 0)
            ->where('d.is_active', 1)
            ->where('d.is_deleted', 0)
            ->groupBy('d.diamond_id', 'da.refAttribute_id')
            ->orderBy('d.diamond_id', 'desc')
            ->get()
            ->toArray(); */

        $data = [];
        foreach ($diamond_ids as $k => $v) {
            $data[] = DB::table('diamonds as d')
                ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
                ->join('attribute_groups as ag', 'a.attribute_group_id', '=', 'ag.attribute_group_id')
                ->select('da.refAttribute_id', 'd.diamond_id', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price')
                ->where('d.diamond_id', $v)
                ->whereIn('da.refAttribute_id', $attribute_ids)
                ->where('da.refAttribute_id', '<>', 0)
                ->orderBy('d.diamond_id', 'desc')
                ->get()
                ->toArray();
        }
        // dd($data);

        $attr_grp_data = DB::table('attributes as a')
            ->join('attribute_groups as ag', 'a.attribute_group_id', '=', 'ag.attribute_group_id')
            ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image')
            ->whereIn('a.attribute_id', $attribute_ids)
            ->orderBy('attribute_group_id')
            ->get()
            ->toArray();
        dd($attr_grp_data);
        $diamonds = [];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {
                for ($k = 0; $k < count($attr_grp_data); $k++) {
                    if ($attr_grp_data[$k]->attribute_id == $data[$i][$j]->refAttribute_id) {
                        if ($data[$i][$j]->diamond_id == $data[$i][$j]->diamond_id) {
                            $diamonds[] = [
                                'diamond_id' => $data[$i][$j]->diamond_id,
                                $attr_grp_data[$k]->ag_name => $attr_grp_data[$k]->name,
                                'image' => $data[$i][$j]->image
                            ];
                        }
                    }
                }
            }
        }
        dd($diamonds);
        return $this->successResponse('Success', $data);
    }

    /* public function searchDiamonds(Request $request)
    {
        $response = $request->all();
        $attribute_groups = array_keys($response);

        $attr = [];
        foreach ($attribute_groups as $a) {
            $attr[$a] = collect($response[$a]['attributes'])->pluck('attribute_id')->values()->all();
        }

        $attribute_ids = [];
        foreach ($attr as $a) {
            $attribute_ids = array_merge($attribute_ids, array_values($a));
        }

        $q = null;
        foreach ($attr as $k => $v) {
            $q .= '("da"."refAttribute_group_id" = ' . $k . ' and "da"."refAttribute_id" in ('.implode(',', $v).')) or ';
        }

        $diamond_ids = DB::table('diamonds as d')
            ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->select('d.diamond_id', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price')
            ->whereRaw(rtrim($q, 'or '))
            ->where('da.refAttribute_id', '<>', 0)
            ->where('d.is_active', 1)
            ->where('d.is_deleted', 0)
            ->groupBy('d.diamond_id')
            ->orderBy('d.diamond_id', 'desc')
            ->pluck('diamond_id')
            ->toArray();

        // $data = DB::table('diamonds as d')
        //     ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
        //     ->select('da.refAttribute_id', 'd.diamond_id', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price')
        //     ->whereRaw(rtrim($q, 'or '))
        //     ->where('da.refAttribute_id', '<>', 0)
        //     ->where('d.is_active', 1)
        //     ->where('d.is_deleted', 0)
        //     ->groupBy('d.diamond_id', 'da.refAttribute_id')
        //     ->orderBy('d.diamond_id', 'desc')
        //     ->get()
        //     ->toArray();

        $data = [];
        foreach ($diamond_ids as $k => $v) {
            $data[] = DB::table('diamonds as d')
                ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
                ->select('da.refAttribute_id', 'd.diamond_id', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price')
                ->where('d.diamond_id', $v)
                ->orderBy('d.diamond_id', 'desc')
                ->get()
                ->toArray();
        }

        $diamonds = [];
        $i = 0;
        foreach ($data as $k => $v) {
            foreach ($response as $k1 => $v1) {
                if ($response[$k1]['attributes'][$i]['attribute_id'] == $v->refAttribute_id) {
                    $data[$k]['attributes'][] = [
                        'ag_name' => $v->ag_name,
                        'attribute_id' => $v->attribute_id,
                        'name' => $v->name,
                        'image' => $v->image
                    ];
                } else {
                    $j++;
                    $attr[$attr_groups[$j]][] = [
                        'ag_name' => $v->ag_name,
                        'attribute_id' => $v->attribute_id,
                        'name' => $v->name,
                        'image' => $v->image
                    ];
                }
            }
        }
        return $this->successResponse('Success', $data);
    } */
}
