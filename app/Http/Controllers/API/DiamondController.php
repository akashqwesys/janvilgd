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
        $rules = [
            'category' => ['required', 'integer']
        ];

        $message = [
            'category.required' => 'Please select diamond category',
            'category.integer' => 'Please select valid diamond category'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $data = DB::table('attributes as a')
            ->join('attribute_groups as ag', 'a.attribute_group_id', '=', 'ag.attribute_group_id')
            ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image')
            ->where('ag.refCategory_id', $request->category)
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

        $attrg_attr = [];
        if (is_array($response)) {
            foreach ($response as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $v_row) {
                        $dummy_array=array();
                        $dummy_array['ag']=$k;
                        $dummy_array['atr']=$v_row;
                        array_push($attrg_attr, $dummy_array);
                    }
                }
            }
        }

        $q = null;
        foreach ($attrg_attr as $v) {
            $q .= '("da"."refAttribute_group_id" = ' . $v['ag'] . ' and "da"."refAttribute_id" = ' . $v['atr'] . ') or ';
            // $q .= '"ag"."attribute_group_id" = ' . $v['ag'] . ' and ';
            // $q .= '"a"."attribute_id" = ' . $v['atr'] . ') or ';
        }

        $diamond_ids = DB::table('diamonds as d')
            ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('d.diamond_id','d.name as diamond_name', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price','a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name');
        if (!empty($q)) {
            $diamond_ids = $diamond_ids->whereRaw('(' . rtrim($q, 'or ') . ')');
        }
        $diamond_ids = $diamond_ids->where('da.refAttribute_id', '<>', 0);
        if (isset($response['price_min']) && isset($response['price_max'])) {
            $diamond_ids = $diamond_ids->where('d.total', '<=', $response['price_max'])->where('d.total', '>=', $response['price_min']);
        }
        if (isset($response['carat_min']) && isset($response['carat_max'])) {
            $diamond_ids = $diamond_ids->where('d.expected_polish_cts', '<=', $response['carat_max'])->where('d.expected_polish_cts', '>=', $response['carat_min']);
        }
        $diamond_ids = $diamond_ids->where('d.is_active', 1)
            ->where('d.is_deleted', 0)
            // ->groupBy('d.diamond_id')
            ->orderBy('d.diamond_id', 'desc')
            ->get()
            // ->pluck('diamond_id')
            ->toArray();

        if (!count($diamond_ids)) {
            if ($request->web == 'web') {
                return response()->json(['error' => 1, 'message' => 'No records found', 'data' => '']);
            }
            return $this->successResponse('No diamond found');
        }

        $final_d = [];
        $temp_diamond_id = null;

        foreach ($diamond_ids as $v_row) {
            if ($temp_diamond_id != $v_row->diamond_id) {
                $temp_diamond_id = $v_row->diamond_id;
                $final_d[$v_row->diamond_id]['diamond_id'] = $v_row->diamond_id;
                $final_d[$v_row->diamond_id]['diamond_name'] = $v_row->diamond_name;
                $final_d[$v_row->diamond_id]['carat'] = $v_row->carat;
                $final_d[$v_row->diamond_id]['image'] = json_decode($v_row->image);
                $final_d[$v_row->diamond_id]['price'] = $v_row->price;
                $final_d[$v_row->diamond_id]['attributes'] = [];
            } else {
                $final_d[$v_row->diamond_id]['attributes'][$v_row->ag_name] = $v_row->name;
            }
        }

        if ($request->web == 'web') {
            $html = '';
            foreach ($final_d as $v) {
                if (count($v['image'])) {
                    $img_src = $v['image'][0];
                } else {
                    $img_src = '/assets/images/No-Preview-Available.jpg';
                }
                $html .= '<tr data-diamond="' . $v['diamond_id'] . '" data-price="$' . round($v['price'], 2) . '" data-name="' . $v['diamond_name'] . '" data-image="' . $img_src . '">
                            <td scope="col" class="text-center">' . $v['carat'] . '</td>
                            <td scope="col" class="text-center">' . round($v['price'], 2) . '</td>';
                if (isset($v['attributes']['SHAPE'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['SHAPE'] . '</td>';
                } else {
                    $html .= '<td scope="col" class="text-center"> - </td>';
                }
                if (isset($v['attributes']['CUT GRADE'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['CUT GRADE'] . '</td>';
                } else {
                    $html .= '<td scope="col" class="text-center"> - </td>';
                }
                if (isset($v['attributes']['COLOR'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['COLOR'] . '</td>';
                } else {
                    $html .= '<td scope="col" class="text-center"> - </td>';
                }
                if (isset($v['attributes']['CLARITY'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['CLARITY'] . '</td>';
                } else {
                    $html .= '<td scope="col" class="text-center"> - </td>';
                }
                $html .= '<td scope="col" class="text-center">
                            <div class="compare-checkbox">
                                <label class="custom-check-box">
                                    <input type="checkbox" class="diamond-checkbox" data-id="' . $v['diamond_id'] . '" >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </td>
                    </tr>';
            }
            return response()->json(['success' => 1, 'message' => 'Data updated', 'data' => $html]);
        }

        return $this->successResponse('Success', $final_d);
    }

    public function detailshDiamonds($diamond_id)
    {
        $response_array=array();
        $diamonds = DB::table('diamonds as d')
            ->leftJoin('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->leftJoin('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->leftJoin('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price','a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name')
            ->where('diamond_id',$diamond_id)
            ->get();

        if(!empty($diamonds) && isset($diamonds[0])){
            $response_array['data']=$diamonds[0];
            $response_array['attribute']=[];
            foreach ($diamonds as $value){
                $newArray=array();
                $newArray['ag_name']=$value->ag_name;
                $newArray['at_name']=$value->name;
                array_push($response_array['attribute'],$newArray);
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('No such diamond found');
        }
        return $this->successResponse('Success', $response_array);
    }

    public function getCart()
    {
        $customer_id=Auth::id();
        $response_array=array();
        $diamonds = DB::table('customer_cart as c')
            ->join('diamonds as d', 'c.refDiamond_id', '=', 'd.diamond_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price')
            ->where('c.refCustomer_id',$customer_id)
            ->get();
        if(!empty($diamonds) && isset($diamonds[0])){
            foreach ($diamonds as $value){
                array_push($response_array,$value);
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('Data not found');
        }
        return $this->successResponse('Success', $response_array);
    }

    public function addToCart(Request $request)
    {
        $rules = [
            'diamond_id' => ['required', 'integer']
        ];

        $message = [
            'diamond_id.required' => 'Please select diamond',
            'diamond_id.integer' => 'Please select valid diamond'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $customer_id = Auth::id();
        $exist_cart = DB::table('customer_cart')
                ->where('refDiamond_id',$request->diamond_id)
                ->where('refCustomer_id',$customer_id)
                ->first();
        if(empty($exist_cart)){
            $data_array = [
                'refCustomer_id' => $customer_id,
                'refDiamond_id' => $request->diamond_id,
                'date_added' => date("Y-m-d h:i:s")
            ];
            $res=DB::table('customer_cart')->insert($data_array);
            $Id = DB::getPdo()->lastInsertId();
            if (empty($res)) {
                return $this->errorResponse('Sorry, we are not able to add this diamond to your cart');
            }
            return $this->successResponse('Success', $Id);
        } else{
            return $this->errorResponse('Selected diamond is already in the cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        $rules = [
            'diamond_id' => ['required', 'integer']
        ];

        $message = [
            'diamond_id.required' => 'Please select diamond',
            'diamond_id.integer' => 'Please select valid diamond'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $customer_id = Auth::id();
        $exist_cart = DB::table('customer_cart')
                ->where('refDiamond_id',$request->diamond_id)
                ->where('refCustomer_id',$customer_id)
                ->first();
        if(empty($exist_cart)){
            return $this->errorResponse('No such diamond in your cart');
        } else {
            DB::table('customer_cart')
            ->where('refDiamond_id',$request->diamond_id)
            ->where('refCustomer_id',$customer_id)
            ->delete();
            return $this->successResponse('Success',[],3);
        }
    }

    public function getWishlist()
    {
        $customer_id = Auth::id();
        $response_array=array();
        $diamonds = DB::table('customer_whishlist as cw')
            ->join('diamonds as d', 'cw.refdiamond_id', '=', 'd.diamond_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price')
            ->where('cw.refCustomer_id',$customer_id)
            ->get();
        if(!empty($diamonds) && isset($diamonds[0])){
            foreach ($diamonds as $value){
                array_push($response_array,$value);
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('Your wishlist is empty');
        }
        return $this->successResponse('Success', $response_array);
    }

    public function addToWishlist(Request $request)
    {
        $rules = [
            'diamond_id' => ['required', 'integer']
        ];

        $message = [
            'diamond_id.required' => 'Please select diamond',
            'diamond_id.integer' => 'Please select valid diamond'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $customer_id = Auth::id();
        $exist_wishlist = DB::table('customer_whishlist')
                ->where('refdiamond_id',$request->diamond_id)
                ->where('refCustomer_id',$customer_id)
                ->first();
        if(empty($exist_wishlist)){
            $data_array = [
                'refCustomer_id' => $customer_id,
                'refdiamond_id' => $request->diamond_id,
                'date_added' => date("Y-m-d h:i:s")
            ];
            $res=DB::table('customer_whishlist')->insert($data_array);
            $Id = DB::getPdo()->lastInsertId();
            if (empty($res)) {
                return $this->errorResponse('Sorry, we are not able to add this diamond to your wishlist');
            }
            return $this->successResponse('Success', $Id);
        } else {
            return $this->errorResponse('Selected diamond is already there in your wishlist');
        }
    }

    public function removeFromWishlist(Request $request)
    {
        $rules = [
            'diamond_id' => ['required', 'integer']
        ];

        $message = [
            'diamond_id.required' => 'Please select diamond',
            'diamond_id.integer' => 'Please select valid diamond'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $customer_id = Auth::id();
        $exist_wishlist = DB::table('customer_whishlist')
                ->where('refdiamond_id',$request->diamond_id)
                ->where('refCustomer_id',$customer_id)
                ->first();
        if(empty($exist_wishlist)){
            return $this->errorResponse('Data not found');
        } else {
            DB::table('customer_whishlist')
            ->where('refdiamond_id',$request->diamond_id)
            ->where('refCustomer_id',$customer_id)
            ->delete();
            return $this->successResponse('Success', [], 3);
        }
    }
}
