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
use Illuminate\Support\Facades\Session;
use Elasticsearch\ClientBuilder;

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
            ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image', 'ag.is_fix')
            ->where('ag.refCategory_id', $request->category)
            ->orderBy('ag.sort_order')
            ->orderBy('a.attribute_group_id')
            ->get()
            ->toArray();
        $attr_groups = collect($data)->pluck('attribute_group_id')->unique()->values()->all();
        $j = 0;
        $attr = [];
        foreach ($data as $v) {
            if ($v->ag_name == 'GRIDLE CONDITION') {
                continue;
            }
            if ($attr_groups[$j] != $v->attribute_group_id) {
                $j++;
            }
            $attr[$attr_groups[$j]]['name'] = $v->ag_name;
            $attr[$attr_groups[$j]]['attribute_group_id'] = $v->attribute_group_id;
            $attr[$attr_groups[$j]]['is_fix'] = $v->is_fix;
            if ($v->ag_name == 'SHAPE') {
                if (in_array($v->image, ['Round Brilliant', 'ROUND', 'RO', 'BR'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Round_Brilliant.png';
                } else if (in_array($v->image, ['Oval Brilliant', 'OV', 'Oval'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Oval_Brilliant.png';
                } else if (in_array($v->image, ['Cushion', 'CU'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Cushion.png';
                } else if (in_array($v->image, ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Pear_Brilliant.png';
                } else if (in_array($v->image, ['Princess Cut', 'PR', 'Princess'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Princess_Cut.png';
                } else if (in_array($v->image, ['Emerald', 'EM'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Emerald.png';
                } else if (in_array($v->image, ['Marquise', 'MQ'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Marquise.png';
                } else if (in_array($v->image, ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                    $v->image = '/assets/images/Diamond_Shapes_Heart_Brilliant.png';
                }
            } else {
                $v->image = $v->image == 0 ? null : $v->image;
            }
            $attr[$attr_groups[$j]]['attributes'][] = [
                'attribute_id' => $v->attribute_id,
                'name' => $v->name,
                'image' => $v->image
            ];
        }
        // $new_attr = [];
        foreach ($attr as $k => $v) {
            if (count($v['attributes']) > 1) {
                $attr[$k]['skip'] = 0;
            } else {
                $attr[$k]['skip'] = 1;
            }
        }
        $max = DB::table('diamonds')
            ->selectRaw('max("total") as "max_price", min("total") as "min_price", max("expected_polish_cts") as "max_carat", min("expected_polish_cts") as "min_carat"')
            ->where('refCategory_id', $request->category)
            ->first();
        if ($max) {
            /* $min_price = (round($max->min_price - 1) < 0) ? 0 : round($max->min_price - 1);
            $max_price = round($max->max_price + 1);
            $min_carat = (round($max->min_carat - 1) < 0) ? 0 : round($max->min_carat - 1);
            $max_carat = round($max->max_carat + 1); */
            $min_price = $max->min_price;
            $max_price = $max->max_price;
            $min_carat = $max->min_carat;
            $max_carat = $max->max_carat;
        } else {
            $max_price = $min_carat = $max_carat = $min_price = 0;
        }
        $main_data['attribute_groups'] = array_values($attr);
        $main_data['price'] = ['min' => $min_price, 'max' => $max_price];
        $main_data['carat'] = ['min' => $min_carat, 'max' => $max_carat];

        return $this->successResponse('Success', $main_data);
    }

    public function searchDiamonds(Request $request)
    {
        $response = $request->all();

        $attr_to_send = [];
        foreach ($response['attr_array'] as $k => $v) {
            if ($k == 'price_min' || $k == 'price_max' || $k == 'carat_min' || $k == 'carat_max' || $k == 'web' || $k == 'category' || $k == 'category_slug' || $k == 'gateway' || $k == 'offset') {
                continue;
            }
            for ($i = 0; $i < count($v); $i++) {
                // $attr_to_send[$k]['should'][] = [ 'term' => [ 'attributes_id.'.$k => $v[$i] ] ];
                $v[$i] = intval($v[$i]);
            }
            $attr_to_send[] = [
                'nested' => [
                    'query' => [
                        'terms' => [
                            'attributes_id.attribute_id' => array_values($v)
                        ]
                    ],
                    'path' => 'attributes_id'
                ]
            ];
        }

        // $attr_to_send = array_values($attr_to_send);
        // $elastic_sub_params = [
        //     'must' => [
        //         [
        //             'bool' => $attr_to_send
        //         ], [
        //             'match' => [ 'refCategory_id' => $response['category'] ]
        //         ]
        //     ]
        // ];
        // if (isset($response['price_min']) && isset($response['price_max']) && isset($response['carat_min']) && isset($response['carat_max'])) {
        //     $elastic_sub_params = [
        //         'must' => [
        //             [
        //                 'bool' => $attr_to_send
        //             ], [
        //                 'range' => [
        //                     'total' => [ 'gte' => $response['price_min'], 'lte' => $response['price_max'] ]
        //                 ]
        //             ], [
        //                 'range' => [
        //                     'expected_polish_cts' => ['gte' => $response['carat_min'], 'lte' => $response['carat_max']]
        //                 ]
        //             ], [
        //                 'match' => [ 'refCategory_id' => $response['category'] ]
        //             ]
        //         ]
        //     ];
        // }
        $elastic_params = [
            'index' => 'diamonds',
            // 'from' => $response['offset'] ?? 0,
            'body'  => [
                'size'  => 5000,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'bool' => [
                                    'must' =>  $attr_to_send
                                ]
                            ], [
                                'bool' => [
                                    'must' => [
                                        [ 'term' => [ 'refCategory_id' => [ 'value' => intval($response['category']) ] ] ],
                                        [
                                            'range' => [
                                                'expected_polish_cts' => [
                                                    'from' => intval($response['attr_array']['carat_min'] ?? 0),
                                                    'to' => intval($response['attr_array']['carat_max'] ?? 5)
                                                ],
                                            ]
                                        ], [
                                            'range' => [
                                                'total' => [
                                                    'from' => intval($response['attr_array']['price_min'] ?? 0),
                                                    'to' => intval($response['attr_array']['price_max'] ?? 3000)
                                                ],
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $diamond_ids = $client->search($elastic_params);       

        $final_d = $final_api = [];

        if (isset($diamond_ids['hits']['hits'])) {
            if(count($diamond_ids['hits']['hits']) < 1){
                if ($request->web == 'web' && $request->scroll == 0 ) {
                    return $this->successResponse('Success', $final_d);
                }
                return $this->successResponse('No diamond found');
            }
        }
        $final_d = $diamond_ids['hits']['hits'];
        if ($response['attr_array']['gateway'] == 'api') {
            return $this->successResponse('Success', array_values( $final_d));
        } else {
            return $this->successResponse('Success', $final_d);
        }
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

            $response_array['attribute'] = [];
            foreach ($diamonds as $value){
                $newArray = array();
                $newArray['ag_name'] = $value->ag_name;
                $newArray['at_name'] = $value->name;
                $newArray['attribute_id'] = $value->attribute_id;
                array_push($response_array['attribute'], $newArray);
            }
        }
        if (!count($response_array)) {
            return $this->errorResponse('No such diamond found');
        }
        else {
            $recent=array();
            $recent['refCustomer_id'] = Auth::id();
            $recent['refDiamond_id'] =  $diamonds[0]->diamond_id;
            $recent['barcode'] =  $diamonds[0]->barcode;
            $recent['updated_at'] = date("Y-m-d h:i:s");
            $recent['price'] = $response_array['price'];
            $recent['carat'] = $response_array['carat'];
            $recent['refAttribute_group_id'] = 0;
            $recent['refAttribute_id'] = 0;

            $shape = '-';
            $cut = '-';
            $color = '-';
            $clarity = '-';
            if(!empty($response_array['attribute'])){
                foreach($response_array['attribute'] as $row){
                    if($row['ag_name'] == "SHAPE"){
                        $shape = $row['at_name'];
                    }
                    if($row['ag_name'] == "CUT GRADE"){
                        $cut = $row['at_name'];
                    }
                    if($row['ag_name'] == "COLOR"){
                        $color = $row['at_name'];
                    }
                    if($row['ag_name'] == "CLARITY"){
                        $clarity = $row['at_name'];
                    }
                }
            }
            $recent['shape'] = $shape;
            $recent['cut'] = $cut;
            $recent['color'] = $color;
            $recent['clarity'] = $clarity;

            $exists = DB::table('recently_view_diamonds')
                ->select('id')
                ->where('refCustomer_id', $recent['refCustomer_id'])
                ->where('refDiamond_id', $recent['refDiamond_id'])
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
                $raw_attr .= '"da"."refAttribute_id" = ' . $v . ' or ';
            }
            $similar = DB::table('diamonds as d')
                ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
                ->select('d.diamond_id', 'd.name', 'd.expected_polish_cts as carat', 'd.rapaport_price as mrp', 'd.total as price', 'd.discount', 'd.image', 'd.barcode')
                ->where('d.is_active', 1)
                ->where('d.is_deleted', 0)
                ->where('d.diamond_id', '<>', $diamonds[0]->diamond_id)
                ->whereRaw('("d"."expected_polish_cts" <= ('. $diamonds[0]->carat .'+0.10) and "d"."expected_polish_cts" >= (' . $diamonds[0]->carat . '-0.10))')
                ->whereRaw('(' . rtrim($raw_attr, ' or ') . ')')
                ->orderByRaw('("d"."expected_polish_cts" - '. $diamonds[0]->carat .') desc')
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
            return $this->successResponse('Cart is empty', []);
        }
        $discount = DB::table('discounts')
            ->select('discount')
            ->where('from_amount', '<=', intval($subtotal))
            ->where('to_amount', '>=', intval($subtotal))
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
            ->where('from_weight', '<=', (intval($weight) - 1))
            ->where('to_weight', '>=', (intval($weight) + 1))
            ->pluck('amount')
            ->first();

        $users_details = DB::table('customer')
            ->where('customer_id', $customer_id)
            ->first();
        /* $company_details = DB::table('customer_company_details')
            ->where('refCustomer_id', $customer_id)
            ->first(); */

        $all_company_details = DB::table('customer_company_details as ccd')
            ->select('ccd.*','country.name as country_name','state.name as state_name','city.name as city_name')
            ->join('country', 'ccd.refCountry_id', '=', 'country.country_id')
            ->join('state', 'ccd.refState_id', '=', 'state.state_id')
            ->join('city', 'ccd.refCity_id', '=', 'city.city_id')
            ->where('refCustomer_id', $customer_id)
            ->get();

        $country = DB::table('country')
            ->select('country_id', 'name')
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->get();

        /* $billing_state = DB::table('state')
            ->where('refCountry_id',$users_details->refCountry_id)
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->get();
        $billing_city = DB::table('city')
            ->where('refState_id',$users_details->refState_id)
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->get();

        $shipping_state = DB::table('state')
            ->where('refCountry_id',$company_details->refCountry_id)
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->get();
        $shipping_city = DB::table('city')
            ->where('refState_id',$company_details->refState_id)
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->get(); */

        $discount = !empty($discount) ? (($subtotal * $discount) / 100) : 0;
        $additional_discount = !empty($additional_discount) ? (($subtotal * $additional_discount) / 100) : 0;
        $tax = !empty($tax) ? (($subtotal * $tax) / 100) : 0;
        $shipping = !empty($shipping) ? $shipping : 0;
        $summary['subtotal'] = number_format(round($subtotal, 2), 2, '.', ',');
        $summary['discount'] = number_format(round($discount, 2), 2, '.', ',');
        $summary['additional_discount'] = number_format(round($additional_discount, 2), 2, '.', ',');
        $summary['tax'] = number_format(round($tax, 2), 2, '.', ',');
        $summary['shipping'] = number_format(round($shipping, 2), 2, '.', ',');
        $summary['weight'] = $weight;
        $total = $subtotal - $discount - $additional_discount + $tax + $shipping;
        $summary['total'] = number_format(round($total, 2), 2, '.', ',');
        $data['diamonds'] = $response_array;
        $data['summary'] = $summary;
        $data['users_details'] = $users_details;
        // $data['company_details'] = $company_details;
        $data['all_company_details'] = $all_company_details;
        $data['country'] = $country;
        /* $data['billing_state'] = $billing_state;
        $data['billing_city'] = $billing_city;
        $data['shipping_state'] = $shipping_state;
        $data['shipping_city'] = $shipping_city; */
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

    public function getOrders(Request $request)
    {
        $customer = Auth::user();
        $orders = DB::table('orders')
            ->select( 'order_id', 'refCustomer_id', 'name', 'mobile_no', 'email_id', 'refPayment_mode_id', 'payment_mode_name', 'refTransaction_id', 'refCustomer_company_id_billing', 'billing_company_name', 'billing_company_office_no', 'billing_company_office_email', 'billing_company_office_address', 'billing_company_office_pincode', 'refCity_id_billing', 'refState_id_billing', 'refCountry_id_billing', 'billing_company_pan_gst_no', 'refCustomer_company_id_shipping', 'shipping_company_name', 'shipping_company_office_no', 'shipping_company_office_email', 'shipping_company_office_address', 'shipping_company_office_pincode', 'refCity_id_shipping', 'refState_id_shipping', 'refCountry_id_shipping', 'shipping_company_pan_gst_no', 'sub_total', 'refDelivery_charge_id', 'delivery_charge_name', 'delivery_charge_amount', 'refDiscount_id', 'discount_name', 'discount_amount', 'refTax_id', 'tax_name', 'tax_amount', 'total_paid_amount', 'added_by', 'date_added', 'date_updated', DB::raw("select order_status_name from order_updates where refOrder_id = orders.order_id and "))
            ->where('refCustomer_id', $customer->customer_id)
            ->get();
    }
}
