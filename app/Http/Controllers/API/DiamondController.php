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

        $q = null;
        $ag_names = null;
        $diamond_ids = DB::table('diamonds as d');
        $ij = 0;
        foreach ($response as $k => $v) {
            if ($k == 'price_min' || $k == 'price_max' || $k == 'carat_min' || $k == 'carat_max' || $k == 'web' || $k == 'category' || $k == 'category_slug') {
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
            $diamond_ids = $diamond_ids->join('diamonds_attributes as da' , 'd.diamond_id', '=', 'da.refDiamond_id')
            ->join('attribute_groups as ag' , 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->join('attributes as a' , 'da.refAttribute_id', '=', 'a.attribute_id');
            $ag_names = '"a"."name" as "name_0", "ag"."name" as "ag_name_0", ';
            $ij = 1;
        }

        $diamond_ids = $diamond_ids->select('d.diamond_id','d.name as diamond_name', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price', 'd.barcode')
            ->selectRaw(rtrim($ag_names, ', '));

        if (!empty($q)) {
            $diamond_ids = $diamond_ids->whereRaw(rtrim($q, 'and '));
        }

        if (isset($response['price_min']) && isset($response['price_max'])) {
            $diamond_ids = $diamond_ids->where('d.total', '<=', $response['price_max'])->where('d.total', '>=', $response['price_min']);
        }
        if (isset($response['carat_min']) && isset($response['carat_max'])) {
            $diamond_ids = $diamond_ids->where('d.expected_polish_cts', '<=', $response['carat_max'])->where('d.expected_polish_cts', '>=', $response['carat_min']);
        }

        $diamond_ids = $diamond_ids->where('d.is_active', 1)
            ->where('d.is_deleted', 0)
            ->where('d.refCategory_id', $response['category'])
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
        foreach ($diamond_ids as $v_row) {
            for ($i=0; $i < $ij; $i++) {
                $final_d[$v_row->diamond_id]['attributes'][$v_row->{'ag_name_'.$i}] = $v_row->{'name_'.$i};
            }
            $final_d[$v_row->diamond_id]['diamond_id'] = $v_row->diamond_id;
            $final_d[$v_row->diamond_id]['barcode'] = $v_row->barcode;
            $final_d[$v_row->diamond_id]['diamond_name'] = $v_row->diamond_name;
            $final_d[$v_row->diamond_id]['carat'] = $v_row->carat;
            $final_d[$v_row->diamond_id]['image'] = json_decode($v_row->image);
            $final_d[$v_row->diamond_id]['price'] = $v_row->price;
        }

        if ($request->web == 'web') {
            $html = '';
            foreach ($final_d as $v) {
                if (count($v['image'])) {
                    $img_src = '/storage/other_images/' . $v['image'][0];
                } else {
                    $img_src = '/assets/images/No-Preview-Available.jpg';
                }
                $html .= '<tr data-diamond="' . $v['diamond_id'] . '" data-price="$' . number_format(round($v['price'], 2), 2, '.', ',') . '" data-name="' . $v['diamond_name'] . '" data-image="' . $img_src . '" data-barcode="' . $v['barcode'] . '">
                            <td scope="col" class="text-right">' . $v['carat'] . '</td>
                            <td scope="col" class="text-right">$' . number_format(round($v['price'], 2), 2, '.', ',') . '</td>';
                if (isset($v['attributes']['SHAPE'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['SHAPE'] . '</td>';
                } else {
                    $html .= '<td scope="col" class="text-center"> - </td>';
                }
                if ($response['category_slug'] == 'polish-diamonds') {
                    if (isset($v['attributes']['CUT GRADE'])) {
                        $html .= '<td scope="col" class="text-center">' . $v['attributes']['CUT GRADE'] . '</td>';
                    } else {
                        $html .= '<td scope="col" class="text-center"> - </td>';
                    }
                }
                if ($response['category_slug'] != 'rough-diamonds') {
                    if (isset($v['attributes']['COLOR'])) {
                        $html .= '<td scope="col" class="text-center">' . $v['attributes']['COLOR'] . '</td>';
                    } else {
                        $html .= '<td scope="col" class="text-center"> - </td>';
                    }
                }
                if (isset($v['attributes']['CLARITY'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['CLARITY'] . '</td>';
                } else if (isset($v['attributes']['PURITY'])) {
                    $html .= '<td scope="col" class="text-center">' . $v['attributes']['PURITY'] . '</td>';
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

    public function detailshDiamonds($barcode)
    {
        $response_array=array();
        $diamonds = DB::table('diamonds as d')
            ->leftJoin('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->leftJoin('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->leftJoin('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price','a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'd.refCategory_id')
            ->where('d.barcode',$barcode)
            ->get();

        if(!empty($diamonds) && isset($diamonds[0])){

            $diamonds[0]->image = json_decode($diamonds[0]->image);
            $a = [];
            foreach ($diamonds[0]->image as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $diamonds[0]->image = $a;

            $response_array['diamond_id'] = $diamonds[0]->diamond_id;
            $response_array['total'] = $diamonds[0]->total;
            $response_array['diamond_name'] = $diamonds[0]->diamond_name;
            $response_array['barcode'] = $diamonds[0]->barcode;
            $response_array['rapaport_price'] = $diamonds[0]->rapaport_price;
            $response_array['carat'] = $diamonds[0]->carat;
            $response_array['image'] = $diamonds[0]->image;
            $response_array['video_link'] = $diamonds[0]->video_link;
            $response_array['price'] = $diamonds[0]->price;
            $response_array['attribute_id'] = $diamonds[0]->attribute_id;
            $response_array['attribute_group_id'] = $diamonds[0]->attribute_group_id;
            $response_array['name'] = $diamonds[0]->name;
            $response_array['ag_name'] = $diamonds[0]->ag_name;
            $response_array['refCategory_id'] = $diamonds[0]->refCategory_id;
            // $response_array['data']=$diamonds[0];

            $response_array['attribute']=[];
            foreach ($diamonds as $value){
                $newArray=array();
                $newArray['ag_name']=$value->ag_name;
                $newArray['at_name']=$value->name;
                $newArray['attribute_id']=$value->attribute_id;
                array_push($response_array['attribute'],$newArray);
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('No such diamond found');
        }
        else {
            $recent=array();
            $recent['refCustomer_id']=Auth::id();
            $recent['refDiamond_id']= $diamonds[0]->diamond_id;
            $recent['updated_at']=date("Y-m-d h:i:s");
            $recent['price']=$response_array['price'];
            $recent['carat']=$response_array['carat'];
            $recent['refAttribute_group_id']=0;
            $recent['refAttribute_id']=0;

            $shape='-';
            $cut='-';
            $color='-';
            $clarity='-';
            if(!empty($response_array['attribute'])){
                foreach($response_array['attribute'] as $row){
                    if($row['ag_name']=="SHAPE"){
                        $shape=$row['at_name'];
                    }
                    if($row['ag_name']=="CUT GRADE"){
                        $cut=$row['at_name'];
                    }
                    if($row['ag_name']=="COLOR"){
                        $color=$row['at_name'];
                    }
                    if($row['ag_name']=="CLARITY"){
                        $clarity=$row['at_name'];
                    }
                }
            }
            $recent['shape']=$shape;
            $recent['cut']=$cut;
            $recent['color']=$color;
            $recent['clarity']=$clarity;

            $exists = DB::table('recently_view_diamonds')
                ->select('id')
                ->where('refCustomer_id', $recent['refCustomer_id'])
                ->where('refDiamond_id', $recent['refDiamond_id'])
                ->pluck('id')
                ->first();
            if ($exists) {
                DB::table('recently_view_diamonds')
                ->where('refCustomer_id', $recent['refCustomer_id'])
                ->where('refDiamond_id', $recent['refDiamond_id'])
                ->update([
                    'updated_at' => $recent['updated_at']
                ]);
            } else {
                DB::table('recently_view_diamonds')->insert($recent);
            }
        }

        $recommended = DB::table('diamonds')
            ->select('diamond_id', 'name', 'expected_polish_cts as carat', 'rapaport_price as mrp', 'total as price', 'discount', 'image', 'barcode')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->where('is_recommended', 1)
            ->orderBy('diamond_id', 'desc')
            ->limit(5)
            ->get();
        foreach ($recommended as $v) {
            $v->image = json_decode($v->image);
            $a = [];
            foreach ($v->image as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $v->image = $a;
        }

        $similar_ids = collect($response_array['attribute'])
            ->whereIn('ag_name', ['COLOR', 'CUT GRADE', 'CLARITY'])
            ->pluck('attribute_id')
            ->all();
        $raw_attr = null;
        if (count($similar_ids)) {
            foreach ($similar_ids as $v) {
                $raw_attr .= '"da"."refAttribute_id" = ' . $v . ' and ';
            }
            $similar = DB::table('diamonds as d')
                ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
                ->select('d.diamond_id', 'd.name', 'd.expected_polish_cts as carat', 'd.rapaport_price as mrp', 'd.total as price', 'd.discount', 'd.image', 'd.barcode')
                ->where('d.is_active', 1)
                ->where('d.is_deleted', 0)
                ->where('d.diamond_id', '<>', $diamonds[0]->diamond_id)
                ->whereRaw('("d"."expected_polish_cts" >= ('. $diamonds[0]->carat .'+1) and "d"."expected_polish_cts" <= (' . $diamonds[0]->carat . '-1))')
                ->whereRaw(rtrim($raw_attr, ' and '))
                ->orderBy('d.diamond_id', 'desc')
                ->limit(5)
                ->get();
            foreach ($similar as $v) {
                $v->image = json_decode($v->image);
                $a = [];
                foreach ($v->image as $v1) {
                    $a[] = '/storage/other_images/' . $v1;
                }
                $v->image = $a;
            }
        } else {
            $similar = [];
        }
        $response_array['recommended'] = $recommended;
        $response_array['similar'] = $similar;

        return $this->successResponse('Success', $response_array);
    }

    public function getCart()
    {
        $customer_id=Auth::id();
        $response_array=array();
        $diamonds = DB::table('customer_cart as c')
            ->join('diamonds as d', 'c.refDiamond_id', '=', 'd.diamond_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price', 'd.rapaport_price as mrp')
            ->where('c.refCustomer_id',$customer_id)
            ->get();
            // ->toArray();

        if(!empty($diamonds[0]) && isset($diamonds[0])){
            $subtotal = 0;
            $weight = 0;
            foreach ($diamonds as $value){
                $value->image = json_decode($value->image);
                $a = [];
                foreach ($value->image as $v1) {
                    $a[] = '/storage/other_images/' . $v1;
                }
                $value->image = $a;
                $subtotal += $value->price;
                $weight += $value->carat;
                // $response_array[] = (array) $value;
                array_push($response_array, $value);
            }
        }

        if (!count($response_array)) {
            return $this->errorResponse('Data not found');
        }
        $discount = DB::table('discounts')
            ->select('discount')
            ->where('from_amount', '>=', $subtotal)
            ->where('to_amount', '<=', $subtotal)
            ->pluck('discount')
            ->first();
        $additional_discount = DB::table('customer as c')
            ->join('customer_type as ct', 'c.refCustomerType_id', '=', 'ct.customer_type_id')
            ->select('ct.discount')
            ->where('c.customer_id', $customer_id)
            ->pluck('discount')
            ->first();
        $tax = DB::table('customer as c')
            ->join('customer_company_details as ccd', 'c.customer_id', '=', 'ccd.refCustomer_id')
            ->join('taxes as t', 'ccd.refCountry_id', '=', 't.refCountry_id')
            ->select('t.amount')
            ->where('c.customer_id', $customer_id)
            ->pluck('amount')
            ->first();
        $shipping = DB::table('delivery_charges')
            ->select('amount')
            ->where('from_weight', '>=', $weight)
            ->where('to_weight', '<=', $weight)
            ->pluck('amount')
            ->first();
        $discount = !empty($discount) ? (($subtotal * $discount) / 100) : 0;
        $additional_discount = !empty($additional_discount) ? (($subtotal * $additional_discount) / 100) : 0;
        $tax = !empty($tax) ? (($subtotal * $tax) / 100) : 0;
        $shipping = !empty($shipping) ? $shipping : 0;
        $summary['subtotal'] = number_format(round($subtotal, 2), 2, '.', ',');
        $summary['discount'] = number_format(round($discount, 2), 2, '.', ',');
        $summary['additional_discount'] = number_format(round($additional_discount, 2), 2, '.', ',');
        $summary['tax'] = number_format(round($tax, 2), 2, '.', ',');
        $summary['shipping'] = number_format(round($shipping, 2), 2, '.', ',');
        $total = $subtotal - $discount - $additional_discount + $tax + $shipping;
        $summary['total'] = number_format(round($total, 2), 2, '.', ',');
        $data['diamonds'] = $response_array;
        $data['summary'] = $summary;
        return $this->successResponse('Success', $data);
    }

    public function getSharableCart($share_cart_id)
    {
        $diamond_id=DB::table('share_cart')->where('share_cart_id',$share_cart_id)->first();
        $response_array=array();
        if(!empty($diamond_id)){
            $dimond_id_1= json_decode($diamond_id->refDiamond_id);
            $diamonds = DB::table('diamonds as d')
                ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price')
                ->whereIn('d.diamond_id', $dimond_id_1)
                ->get();
            if(!empty($diamonds) && isset($diamonds[0])){
                foreach ($diamonds as $value){
                    array_push($response_array,$value);
                }
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('This link is not valid');
        }
        return $this->successResponse('Success', $response_array);
    }

    public function getSharableWishlist($share_wishlist_id)
    {
        $diamond_id=DB::table('share_wishlist')->where('share_wishlist_id',$share_wishlist_id)->first();
        $response_array=array();
        if(!empty($diamond_id)){
            $dimond_id_1= json_decode($diamond_id->refDiamond_id);
            $diamonds = DB::table('diamonds as d')
                ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price')
                ->whereIn('d.diamond_id', $dimond_id_1)
                ->get();
            if(!empty($diamonds) && isset($diamonds[0])){
                foreach ($diamonds as $value){
                    array_push($response_array,$value);
                }
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('This link is not valid');
        }
        return $this->successResponse('Success', $response_array);
    }

    public function addAllToCart(Request $request)
    {
        $rules = [
            'share_cart_id' => ['required', 'integer']
        ];

        $message = [
            'share_cart_id.required' => 'Please select diamond',
            'share_cart_id.integer' => 'Please select valid diamond'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $customer_id = Auth::id();
        $share_cart = DB::table('share_cart')
                ->where('share_cart_id',$request->share_cart_id)
                ->first();
        if(!empty($share_cart)){
            $diamond_id= json_decode($share_cart->refDiamond_id);
            $i=0;
            foreach ($diamond_id as $d_row){
                $exist_cart = DB::table('customer_cart')
                        ->where('refDiamond_id',$d_row)
                        ->where('refCustomer_id',$customer_id)
                        ->first();
                if(empty($exist_cart)){
                    $data_array = [
                        'refCustomer_id' => $customer_id,
                        'refDiamond_id' => $d_row,
                        'date_added' => date("Y-m-d h:i:s")
                    ];
                    $res=DB::table('customer_cart')->insert($data_array);
                    $Id = DB::getPdo()->lastInsertId();
                    if (!empty($Id)) {
                        $i=1;
                    }
                }
            }
            if($i==0){
                return $this->errorResponse('All diamonds is already in your cart');
            }
            if($i==1){
                return $this->successResponse('Success',[],3);
            }
        }
        return $this->errorResponse('No data found');
    }

    public function addAllToWishlist(Request $request)
    {
        $rules = [
            'share_wishlist_id' => ['required', 'integer']
        ];

        $message = [
            'share_wishlist_id.required' => 'Please select diamond',
            'share_wishlist_id.integer' => 'Please select valid diamond'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $customer_id = Auth::id();
        $share_wishlist = DB::table('share_wishlist')
                ->where('share_wishlist_id',$request->share_wishlist_id)
                ->first();
        if(!empty($share_wishlist)){
            $diamond_id= json_decode($share_wishlist->refDiamond_id);
            $i=0;
            foreach ($diamond_id as $d_row){
                $exist_wishlist = DB::table('customer_whishlist')
                        ->where('refdiamond_id',$d_row)
                        ->where('refCustomer_id',$customer_id)
                        ->first();
                if(empty($exist_wishlist)){
                    $data_array = [
                        'refCustomer_id' => $customer_id,
                        'refdiamond_id' => $d_row,
                        'date_added' => date("Y-m-d h:i:s")
                    ];
                    $res=DB::table('customer_whishlist')->insert($data_array);
                    $Id = DB::getPdo()->lastInsertId();
                    if (!empty($Id)) {
                        $i=1;
                    }
                }
            }
            if($i==0){
                return $this->errorResponse('All diamonds is already in your wishlist');
            }
            if($i==1){
                return $this->successResponse('Success',[],3);
            }
        }
        return $this->errorResponse('No data found');
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
            return $this->successResponse('Success', [], 3);
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
            return $this->successResponse('Success', [] ,3);
        }
    }

    public function createShareCartLink(Request $request)
    {
        $customer_id = Auth::id();
        $cart_data = DB::table('customer_cart')
                ->where('refCustomer_id',$customer_id)
                ->get();
        if(!empty($cart_data[0])){
            $refDiamond_id_array=array();
            foreach ($cart_data as $row){
                array_push($refDiamond_id_array,$row->refDiamond_id);
            }
            $data_array = [
                'refDiamond_id' => json_encode($refDiamond_id_array)
            ];
            $res=DB::table('share_cart')->insert($data_array);
            $Id = DB::getPdo()->lastInsertId();
            if (empty($Id)) {
                return $this->errorResponse('Sorry, we are not able to generate link');
            }
            return $this->successResponse('Success', $Id);
        } else {
            return $this->errorResponse('Your Cart is empty');
        }
    }

    public function createShareWishlistLink(Request $request)
    {
        $customer_id = Auth::id();
        $wishlist_data = DB::table('customer_whishlist')
                ->where('refCustomer_id',$customer_id)
                ->get();
        if(!empty($wishlist_data[0])){
            $refDiamond_id_array=array();
            foreach ($wishlist_data as $row){
                array_push($refDiamond_id_array,$row->refdiamond_id);
            }
            $data_array = [
                'refDiamond_id' => json_encode($refDiamond_id_array)
            ];
            $res=DB::table('share_wishlist')->insert($data_array);
            $Id = DB::getPdo()->lastInsertId();
            if (empty($Id)) {
                return $this->errorResponse('Sorry, we are not able to generate link');
            }
            return $this->successResponse('Success', $Id);
        } else {
            return $this->errorResponse('Your Wishlist is empty');
        }
    }

    public function getWishlist()
    {
        $customer_id = Auth::id();
        $response_array=array();
        $diamonds = DB::table('customer_whishlist as cw')
            ->join('diamonds as d', 'cw.refdiamond_id', '=', 'd.diamond_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price', 'd.rapaport_price as mrp')
            ->where('cw.refCustomer_id',$customer_id)
            ->get();
        if(!empty($diamonds[0]) && isset($diamonds[0])){
            foreach ($diamonds as $value){
                $value->image = json_decode($value->image);
                $a = [];
                foreach ($value->image as $v1) {
                    $a[] = '/storage/other_images/' . $v1;
                }
                $value->image = $a;
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
            return $this->successResponse('Success',[],3);
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
