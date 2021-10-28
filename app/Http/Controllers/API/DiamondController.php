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
                $attr[$attr_groups[$j]][] = [
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
        return $this->successResponse('Success', $attr);
    }

    public function searchDiamonds(Request $request)
    {
        $main = $request->all();
        $attribute_groups = array_keys($main);

        $attr = [];
        foreach ($attribute_groups as $a) {
            $attr[$a] = collect($main[$a])->pluck('attribute_id')->values()->all();
        }

        $q = null;
        foreach ($attr as $k => $v) {
            $q .= '("da"."refAttribute_group_id" = ' . $k . ' and "da"."refAttribute_id" in ('.implode(',', $v).')) or ';
        }

        $data = DB::table('diamonds_attributes as da')
            ->join('diamonds as d', 'da.refDiamond_id', '=', 'd.diamond_id')
            ->whereRaw(rtrim($q, 'or '))
            ->select('d.diamond_id')
            ->where('d.is_active', 1)
            ->where('d.is_deleted', 0)
            ->groupBy('d.diamond_id')
            ->orderBy('d.diamond_id', 'desc')
            ->get();

        return $this->successResponse('Success', $data);
    }
}
