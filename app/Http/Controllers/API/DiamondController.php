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
        $data = DB::table('attribute_groups as ag')
            ->join('attributes as a', 'ag.attribute_group_id', '=', 'a.attribute_group_id')
            ->joinSub('SELECT "refAttribute_id", MAX(diamond_attribute_id) FROM diamonds_attributes group by "refAttribute_id"', 'da', function ($join) {
                $join->on('da.refAttribute_id', '=', 'a.attribute_id');
            })
            ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image', 'ag.is_fix', 'ag.refCategory_id', 'a.sort_order')
            ->where('ag.refCategory_id', $request->category)
            ->where('ag.field_type', 1)
            ->where('a.is_active', 1)
            ->where('a.is_deleted', 0)
            ->orderBy('ag.sort_order')
            ->orderBy('a.attribute_group_id')
            ->get()
            ->toArray();

        // $attr_groups = collect($data)->pluck('attribute_group_id')->unique()->values()->all();

        $temp_grp_id = 0;
        $temp_var = 0;
        $final_attribute_groups_with_att = array();
        foreach ($data as $row_data) {
            if ($temp_grp_id != $row_data->attribute_group_id) {
                if ($temp_grp_id !== 0) {
                    usort($final_attribute_groups_with_att[$temp_grp_id]['attributes'], function ($a, $b) {
                        return $a['sort_order'] - $b['sort_order'];
                    });
                }
                $temp_grp_id = $row_data->attribute_group_id;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['name'] = $row_data->ag_name;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['attribute_group_id'] = $row_data->attribute_group_id;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['is_fix'] = $row_data->is_fix;
                $temp_var = 0;
            }
            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['attribute_id'] = $row_data->attribute_id;
            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['name'] = $row_data->name;

            if ($row_data->ag_name == 'SHAPE') {
                if (in_array($row_data->name, ['Round Brilliant', 'ROUND', 'RO', 'BR', 'Round'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                } else if (in_array($row_data->name, ['Oval Brilliant', 'OV', 'Oval'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Oval_Brilliant_b.svg';
                } else if (in_array($row_data->name, ['Cushion', 'CU'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Cushion_b.svg';
                } else if (in_array($row_data->name, ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Pear_Brilliant_b.svg';
                } else if (in_array($row_data->name, ['Princess Cut', 'PR', 'Princess'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Princess_Cut_b.svg';
                } else if (in_array($row_data->name, ['Emerald', 'EM'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Emerald_b.svg';
                } else if (in_array($row_data->name, ['Marquise', 'MQ'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Marquise_b.svg';
                } else if (in_array($row_data->name, ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                    $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = '/assets/images/d_images/Diamond_Shapes_Heart_Brilliant_b.svg';
                }
            } else {
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = $row_data->image == 0 ? null : $row_data->image;
            }

            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['sort_order'] = $row_data->sort_order;
            $temp_var++;
        }
        if ($temp_grp_id !== 0) {
            usort($final_attribute_groups_with_att[$temp_grp_id]['attributes'], function ($a, $b) {
                return $a['sort_order'] - $b['sort_order'];
            });
        }

        /* foreach ($data as $v) {
            if ($v->ag_name == 'GRIDLE CONDITION') {
                continue;
            }
            if ($attr_groups[$j] != $v->attribute_group_id) {
                $j++;
            }
            $attr[$attr_groups[$j]]['name'] = $v->ag_name;
            $attr[$attr_groups[$j]]['attribute_group_id'] = $v->attribute_group_id;
            $attr[$attr_groups[$j]]['is_fix'] = $v->is_fix;
            $v->image_g = null;
            if ($v->ag_name == 'SHAPE') {
                if (in_array($v->name, ['Round Brilliant', 'ROUND', 'RO', 'BR', 'Round'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant.svg';
                } else if (in_array($v->name, ['Oval Brilliant', 'OV', 'Oval'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Oval_Brilliant_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Oval_Brilliant.svg';
                } else if (in_array($v->name, ['Cushion', 'CU'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Cushion_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Cushion.svg';
                } else if (in_array($v->name, ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Pear_Brilliant_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Pear_Brilliant.svg';
                } else if (in_array($v->name, ['Princess Cut', 'PR', 'Princess'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Princess_Cut_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Princess_Cut.svg';
                } else if (in_array($v->name, ['Emerald', 'EM'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Emerald_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Emerald.svg';
                } else if (in_array($v->name, ['Marquise', 'MQ'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Marquise_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Marquise.svg';
                } else if (in_array($v->name, ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                    $v->image = '/assets/images/d_images/Diamond_Shapes_Heart_Brilliant_b.svg';
                    $v->image_g = '/assets/images/d_images/Diamond_Shapes_Heart_Brilliant.svg';
                }
            } else {
                $v->image = $v->image == 0 ? null : $v->image;
            }
            $attr[$attr_groups[$j]]['attributes'][] = [
                'attribute_id' => $v->attribute_id,
                'name' => $v->name,
                'image_b' => $v->image,
                'image_g' => $v->image_g
            ];
        } */
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if (count($v['attributes']) > 1) {
                $final_attribute_groups_with_att[$k]['skip'] = 0;
            } else {
                $final_attribute_groups_with_att[$k]['skip'] = 1;
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
        $main_data['attribute_groups'] = array_values($final_attribute_groups_with_att);
        $main_data['price'] = ['min' => $min_price, 'max' => $max_price];
        $main_data['carat'] = ['min' => $min_carat, 'max' => $max_carat];

        return $this->successResponse('Success', $main_data);
    }

    // Method is working with elastic search (DON'T DELETE IT)
    public function searchDiamonds(Request $request)
    {
        $user = Auth::user();
        if (isset($request->all()['gateway']) && $request->all()['gateway'] == 'api') {
            $response['attr_array'] = $request->all();
            $response['params']['category'] = $response['attr_array']['category'];
            customer_activity('search', $user->name . ' has searched diamonds');
        } else {
            $response = $request->all();
        }

        $attr_to_send = [];
        foreach ($response['attr_array'] as $k => $v) {
            if (in_array($k, ['price_min', 'price_max', 'carat_min', 'carat_max', 'web', 'category', 'category_slug', 'gateway', 'offset', 'column', 'asc_desc', 'search_barcode', 'export'])) {
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
        $all_conditions = [
            [
                'bool' => [
                    'must' =>  $attr_to_send
                ]
            ], [
                'bool' => [
                    'must' => [
                        ['term' => ['refCategory_id' => ['value' => intval($response['params']['category'])]]],
                        [
                            'range' => [
                                'expected_polish_cts' => [
                                    'from' => floatval($response['attr_array']['carat_min'] - 0.001 ?? 0),
                                    'to' => floatval($response['attr_array']['carat_max'] + 0.001 ?? 5),
                                    // 'include_lower' => true,
                                    // 'include_upper' => true
                                ],
                            ]
                        ], [
                            'range' => [
                                'total' => [
                                    'from' => floatval($response['attr_array']['price_min'] - 0.001 ?? 0),
                                    'to' => floatval($response['attr_array']['price_max'] + 0.001 ?? 3000),
                                    // 'include_lower' => true,
                                    // 'include_upper' => true,
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty(trim($response['attr_array']['search_barcode']))) {
            $filter = [
                'bool' => [
                    'must' => [
                        ['term' => ['barcode_search' => $response['attr_array']['search_barcode']]]
                    ]
                ]
            ];
            array_push($all_conditions, $filter);
        }
        if (in_array($response['attr_array']['column'], ['SHAPE', 'COLOR', 'CLARITY', 'CUT'])) {
            $response['attr_array']['column'] = 'attributes.' . $response['attr_array']['column'];
        }
        if (isset($response['attr_array']['export']) && $response['attr_array']['export'] == 'export') {
            $data_size = 9500;
        } else {
            $data_size = 50;
        }
        $elastic_params = [
            'index' => 'diamonds',
            'from' => $response['attr_array']['offset'] ?? 0,
            'body'  => [
                'size'  =>  $data_size,
                'query' => [
                    'bool' => [
                        'must' => $all_conditions
                    ]
                ],
                'sort' => [
                    [
                        $response['attr_array']['column'] => [ 'order' => $response['attr_array']['asc_desc'] ],
                    ],
                ],
            ]
        ];

        $elastic_count = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => $all_conditions
                    ]
                ]
            ]
        ];

        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $diamond_ids = $client->search($elastic_params);

        $final_d = [];
        if (isset($diamond_ids['hits']['hits']) && count($diamond_ids['hits']['hits']) < 1) {
            return $this->successResponse('No diamond found', [
                'total_diamonds' => 0,
                'diamonds' => []
            ]);
        }
        $final_d = $diamond_ids['hits']['hits'];
        if (isset($request->all()['gateway']) && $request->all()['gateway'] == 'api') {
            $final_api = [];
            $url = url('/');
            $i = 0;
            foreach ($final_d as $v) {
                $final_api[$i]['_index'] = $v['_index'];
                $final_api[$i]['_type'] = $v['_type'];
                $final_api[$i]['_id'] = $v['_id'];
                $final_api[$i]['_score'] = $v['_score'];
                $final_api[$i]['_source']['diamond_id'] = $v['_source']['diamond_id'];
                $final_api[$i]['_source']['actual_pcs'] = $v['_source']['actual_pcs'];
                $final_api[$i]['_source']['remarks'] = $v['_source']['remarks'];
                $final_api[$i]['_source']['weight_loss'] = $v['_source']['weight_loss'];
                $final_api[$i]['_source']['is_recommended'] = $v['_source']['is_recommended'];
                $final_api[$i]['_source']['name'] = $v['_source']['name'];
                $final_api[$i]['_source']['barcode'] = $v['_source']['barcode'];
                $final_api[$i]['_source']['barcode_search'] = $v['_source']['barcode_search'];
                $final_api[$i]['_source']['packate_no'] = $v['_source']['packate_no'];
                $final_api[$i]['_source']['makable_cts'] = $v['_source']['makable_cts'];
                $final_api[$i]['_source']['expected_polish_cts'] = $v['_source']['expected_polish_cts'];
                $final_api[$i]['_source']['available_pcs'] = $v['_source']['available_pcs'];
                $final_api[$i]['_source']['rapaport_price'] = $v['_source']['rapaport_price'];
                $final_api[$i]['_source']['refCategory_id'] = $v['_source']['refCategory_id'];
                $final_api[$i]['_source']['price_ct'] = $v['_source']['price_ct'];
                $final_api[$i]['_source']['total'] = $v['_source']['total'];

                if (in_array($v['_source']['attributes']['SHAPE'], ['Round Brilliant', 'ROUND', 'RO', 'BR', 'Round'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Oval Brilliant', 'OV', 'Oval'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Oval_Brilliant_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Cushion', 'CU'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Cushion_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Pear_Brilliant_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Princess Cut', 'PR', 'Princess'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Princess_Cut_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Emerald', 'EM'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Emerald_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Marquise', 'MQ'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Marquise_b.svg';
                } else if (in_array($v['_source']['attributes']['SHAPE'], ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                    $final_api[$i]['_source']['image'][] = $url.'/assets/images/d_images/Diamond_Shapes_Heart_Brilliant_b.svg';
                }

                $final_api[$i]['_source']['discount'] = $v['_source']['discount'];
                $final_api[$i]['_source']['video_link'] = $v['_source']['video_link'];
                $final_api[$i]['_source']['added_by'] = $v['_source']['added_by'];
                $final_api[$i]['_source']['is_active'] = $v['_source']['is_active'];
                $final_api[$i]['_source']['is_deleted'] = $v['_source']['is_deleted'];
                $final_api[$i]['_source']['date_added'] = $v['_source']['date_added'];
                $final_api[$i]['_source']['date_updated'] = $v['_source']['date_updated'];
                $final_api[$i]['_source']['attributes'] = $v['_source']['attributes'];
                $final_api[$i]['_source']['attributes_id'] = $v['_source']['attributes_id'];
                $final_api[$i]['sort'] = $v['sort'];

                $i++;
            }
            $final_d = $final_api;
        }
        $diamonds_count = $client->count($elastic_count);

        return $this->successResponse('Success', [
            'total_diamonds' => $diamonds_count['count'],
            'diamonds' => $final_d
        ]);
    }

    // Method is working with PostgreSQL (DON'T DELETE IT)
    /* public function searchDiamonds(Request $request)
    {
        $user = Auth::user();
        if (isset($request->all()['gateway']) && $request->all()['gateway'] == 'api') {
            $response['attr_array'] = $request->all();
            $response['params']['category'] = $response['attr_array']['category'];
            customer_activity('search', $user->name . ' has searched diamonds');
        } else {
            $response = $request->all();
        }

        $attr_filters = null;
        foreach ($response['attr_array'] as $k => $v) {
            if (in_array($k, ['price_min', 'price_max', 'carat_min', 'carat_max', 'web', 'category', 'category_slug', 'gateway', 'offset', 'column', 'asc_desc', 'search_barcode', 'export'])) {
                continue;
            }
            $attr_filters .= '(';
            for ($i = 0; $i < count($v); $i++) {
                $v[$i] = intval($v[$i]);
                $attr_filters .= "\"attributes_id\"->'$k'->>'attribute_id' = '$v[$i]' ";
                if ($i < count($v) - 1) {
                    $attr_filters .= "or ";
                }
            }
            $attr_filters .= ') and ';
        }
        if (isset($response['attr_array']['export']) && $response['attr_array']['export'] == 'export') {
            $data_size = 9500;
        } else {
            $data_size = 50;
        }

        // 2 Syntax for json containing values (not keys) from given array
        // 1 - "attributes" ->> 'SHAPE' = 'Round' or "attributes" ->> 'SHAPE' = 'Oval'
        // 2 - "attributes" @? '$.SHAPE ? (@ == "Round" || @ == "Oval")'

        $diamonds = DB::table('diamonds')
            ->select('diamond_id', 'barcode', 'refCategory_id', 'is_active', 'is_deleted', 'date_added', 'created_at', 'makable_cts', 'expected_polish_cts', 'rapaport_price', 'discount', 'packate_no', 'actual_pcs', 'available_pcs', 'remarks', 'video_link', 'image', 'total', 'is_recommended', 'name', 'weight_loss', 'attributes', 'attributes_id')
            ->whereRaw(rtrim($attr_filters, ' and '))
            ->where('refCategory_id', intval($response['params']['category']))
            ->where('expected_polish_cts', '>=', floatval($response['attr_array']['carat_min'] - 0.001 ?? 0))
            ->where('expected_polish_cts', '<=', floatval($response['attr_array']['carat_max'] + 0.001 ?? 5))
            ->where('total', '>=', floatval($response['attr_array']['price_min'] - 0.001 ?? 0))
            ->where('total', '<=', floatval($response['attr_array']['price_max'] + 0.001 ?? 20000));
        if (!empty(trim($response['attr_array']['search_barcode']))) {
            $diamonds = $diamonds->where('barcode', trim($response['attr_array']['search_barcode']));
        }
        if (in_array($response['attr_array']['column'], ['SHAPE', 'COLOR', 'CLARITY', 'CUT'])) {
            $response['attr_array']['column'] = "\"attributes\"->>'" . $response['attr_array']['column'] . "'";
        }
        $diamonds = $diamonds->orderByRaw($response['attr_array']['column'] . ' ' . $response['attr_array']['asc_desc']);
        $diamonds_count = $diamonds->count();
        $diamonds = $diamonds->offset($response['attr_array']['offset'] ?? 0)
            ->limit($data_size)
            ->get();

        if (count($diamonds) < 1) {
            return $this->successResponse('No diamond found', [
                'total_diamonds' => 0,
                'diamonds' => []
            ]);
        }
        if (isset($request->all()['gateway']) && $request->all()['gateway'] == 'api') {
            $api_call = true;
        } else {
            $api_call = false;
        }
        $final_d = [];
        $url = url('/');
        $i = 0;
        foreach ($diamonds as $v) {
            $final_d[$i]['diamond_id'] = $v->diamond_id;
            $final_d[$i]['actual_pcs'] = $v->actual_pcs;
            $final_d[$i]['remarks'] = $v->remarks;
            $final_d[$i]['weight_loss'] = $v->weight_loss;
            $final_d[$i]['is_recommended'] = $v->is_recommended;
            $final_d[$i]['name'] = $v->name;
            $final_d[$i]['barcode'] = $v->barcode;
            $final_d[$i]['packate_no'] = $v->packate_no;
            $final_d[$i]['makable_cts'] = $v->makable_cts;
            $final_d[$i]['expected_polish_cts'] = $v->expected_polish_cts;
            $final_d[$i]['available_pcs'] = $v->available_pcs;
            $final_d[$i]['rapaport_price'] = $v->rapaport_price;
            $final_d[$i]['refCategory_id'] = $v->refCategory_id;
            // $final_d[$i]['price_ct'] = $v->price_ct;
            $final_d[$i]['total'] = $v->total;
            $final_d[$i]['attributes'] = $v->attributes = json_decode($v->attributes, true);
            $final_d[$i]['attributes_id'] = json_decode($v->attributes_id, true);
            if ($api_call === true) {
                if (in_array($v->attributes['SHAPE'], ['Round Brilliant', 'ROUND', 'RO', 'BR', 'Round'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Oval Brilliant', 'OV', 'Oval'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Oval_Brilliant_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Cushion', 'CU'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Cushion_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Pear_Brilliant_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Princess Cut', 'PR', 'Princess'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Princess_Cut_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Emerald', 'EM'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Emerald_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Marquise', 'MQ'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Marquise_b.svg';
                } else if (in_array($v->attributes['SHAPE'], ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                    $final_d[$i]['image'][] = $url . '/assets/images/d_images/Diamond_Shapes_Heart_Brilliant_b.svg';
                }
            } else {
                $final_d[$i]['image'] = json_decode($v->image);
            }

            $final_d[$i]['discount'] = $v->discount;
            $final_d[$i]['video_link'] = $v->video_link;
            $final_d[$i]['is_active'] = $v->is_active;
            $final_d[$i]['is_deleted'] = $v->is_deleted;
            $final_d[$i]['date_added'] = $v->date_added;
            $final_d[$i]['created_at'] = $v->created_at;
            // $final_d[$i]['sort'] = $v->sort;

            $i++;
        }

        return $this->successResponse('Success', [
            'total_diamonds' => $diamonds_count,
            'diamonds' => $final_d
        ]);
    } */

    public function detailshDiamondsOld($barcode)
    {
        $response_array=array();
        $diamonds = DB::table('diamonds as d')
            ->leftJoin('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
            ->leftJoin('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->leftJoin('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('d.diamond_id','d.total','d.name as diamond_name','d.barcode','d.rapaport_price','d.expected_polish_cts as carat','d.image', 'd.video_link', 'd.total as price','a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'd.refCategory_id', 'd.available_pcs', 'da.value', 'a.sort_order', 'ag.is_fix')
            ->where('d.barcode', $barcode)
            // ->orderBy('a.attribute_group_id')
            ->orderBy('ag.is_fix', 'desc')
            ->orderBy('a.sort_order')
            ->get();

        if(!empty($diamonds) && isset($diamonds[0])){

            $diamonds[0]->image = json_decode($diamonds[0]->image);
            /* $a = [];
            foreach ($diamonds[0]->image as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $diamonds[0]->image = $a; */

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
            $response_array['available_pcs'] = $diamonds[0]->available_pcs;
            // $response_array['data']=$diamonds[0];

            $response_array['attribute'] = [];
            foreach ($diamonds as $value){
                $newArray = array();
                $newArray['ag_name'] = $value->ag_name;
                $newArray['at_name'] = empty(trim($value->name)) ? $value->value : $value->name ;
                $newArray['attribute_id'] = $value->attribute_id;
                $newArray['sort_order'] = $value->sort_order;
                $newArray['is_fix'] = $value->is_fix;
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
                    if($row['ag_name'] == "CUT"){
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
            // $a = [];
            // foreach ($v->image as $v1) {
            //     $a[] = '/storage/other_images/' . $v1;
            // }
            // $v->image = $a;
        }

        $similar_ids = collect($response_array['attribute'])
            ->whereIn('ag_name', ['COLOR', 'CUT', 'CLARITY', 'SHAPE'])
            ->pluck('attribute_id')
            ->all();
        $raw_attr = null;
        if (count($similar_ids)) {
            $attr_to_send = [];
            foreach ($similar_ids as $v) {
                $raw_attr .= '"da"."refAttribute_id" = ' . $v . ' or ';
                $attr_to_send['must'][] = [
                    'nested' => [
                        'query' => [
                            'term' => [
                                'attributes_id.attribute_id' => $v
                            ]
                        ],
                        'path' => 'attributes_id'
                    ]
                ];
            }
            $all_conditions = [
                [
                    'bool' => $attr_to_send
                ], [
                    'bool' => [
                        'must' => [
                            ['term' => ['refCategory_id' => ['value' => $diamonds[0]->refCategory_id]]],
                            [
                                'range' => [
                                    'expected_polish_cts' => [
                                        'from' => floatval($diamonds[0]->carat - 0.001),
                                        'to' => floatval($diamonds[0]->carat + 0.001)
                                    ],
                                ]
                            ]
                        ],
                        'must_not' => [
                            ['term' => ['diamond_id' => ['value' => $diamonds[0]->diamond_id]]],
                        ]
                    ]
                ]
            ];

            $elastic_params = [
                'index' => 'diamonds',
                'body'  => [
                    'size'  =>  5,
                    'query' => [
                        'bool' => [
                            'must' => $all_conditions
                        ]
                    ]
                ]
            ];
            $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();

            $similar = $client->search($elastic_params);
            $final_similar = [];
            $not_ids = [];
            $not_ids[] = $diamonds[0]->diamond_id;
            foreach ($similar['hits']['hits'] as $v) {
                $final_similar[] = $v;
                $not_ids[] = $v['_source']['diamond_id'];
            }
            $limit = 5 - count($similar['hits']['hits']);
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds[0]->refCategory_id]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds[0]->carat - 0.001),
                                            'to' => floatval($diamonds[0]->carat + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i % 1 == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds[0]->refCategory_id]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds[0]->carat - 0.001),
                                            'to' => floatval($diamonds[0]->carat + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i % 2 == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds[0]->refCategory_id]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds[0]->carat - 0.001),
                                            'to' => floatval($diamonds[0]->carat + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i % 3 == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds[0]->refCategory_id]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds[0]->carat - 0.001),
                                            'to' => floatval($diamonds[0]->carat + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
        } else {
            $final_similar = [];
        }
        $response_array['recommended'] = $recommended;
        $response_array['similar'] = $final_similar;

        return $this->successResponse('Success', $response_array);
    }

    public function detailshDiamonds($barcode)
    {
        $user = Auth::user();
        $response_array = array();
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $all_conditions = [
            [
                'bool' => [
                    'must' => [
                        ['term' => ['barcode' => ['value' => $barcode]]]
                    ]
                ]
            ]
        ];
        $elastic_params = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => $all_conditions
                    ]
                ]
            ]
        ];
        $diamonds = $client->search($elastic_params);

        if (isset($diamonds['hits']['hits']) && count($diamonds['hits']['hits'])) {
            $diamonds = $diamonds['hits']['hits'][0]['_source'];
            $recent = array();
            $recent['refCustomer_id'] = Auth::id();
            $recent['refDiamond_id'] =  $diamonds['diamond_id'];
            $recent['barcode'] =  $diamonds['barcode'];
            $recent['updated_at'] = date("Y-m-d h:i:s");
            $recent['price'] = $diamonds['total'];
            $recent['carat'] = $diamonds['expected_polish_cts'];
            $recent['refAttribute_group_id'] = 0;
            $recent['refAttribute_id'] = 0;

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
        } else {
            return $this->errorResponse('No such diamond found');
        }
        customer_activity('viewed', $user->name . ' has seen a diamond (' . $barcode . ')', '/customer/single-diamonds/' . $barcode);

        /* DB::table('most_viewed_diamonds')
            ->where('shape', $diamonds['attributes']['SHAPE'])
            ->where('refCategory_id', $diamonds['refCategory_id'])
            ->increment('shape_cnt', 1);

        DB::table('most_viewed_diamonds')
            ->where('color', $diamonds['attributes']['COLOR'])
            ->where('refCategory_id', $diamonds['refCategory_id'])
            ->increment('color_cnt', 1);

        DB::table('most_viewed_diamonds')
            ->where('clarity', $diamonds['attributes']['CLARITY'])
            ->where('refCategory_id', $diamonds['refCategory_id'])
            ->increment('clarity_cnt', 1);

        DB::table('most_viewed_diamonds')
            ->where('cut', $diamonds['attributes']['CUT'])
            ->where('refCategory_id', $diamonds['refCategory_id'])
            ->increment('cut_cnt', 1);

        $mvd_exists = DB::table('most_viewed_diamonds')
            ->where('carat', $diamonds['expected_polish_cts'])
            ->where('refCategory_id', $diamonds['refCategory_id'])
            ->first();
        if ($mvd_exists) {
            DB::table('most_viewed_diamonds')
                ->where('carat', $diamonds['expected_polish_cts'])
                ->where('refCategory_id', $diamonds['refCategory_id'])
                ->increment('carat_cnt', 1);
        } else {
            DB::table('most_viewed_diamonds')
            ->insert([
                'refCategory_id' => $diamonds['refCategory_id'],
                'carat' => $diamonds['expected_polish_cts'],
                'shape_cnt' => 0,
                'color_cnt' => 0,
                'carat_cnt' => 1,
                'clarity_cnt' => 0,
                'cut_cnt' => 0,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]);
        } */

        DB::table('most_viewed_diamonds')
            ->where('refCategory_id', $diamonds['refCategory_id'])
            ->increment('views_cnt', 1);

        $elastic_params = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['is_recommended' => ['value' => 1]]],
                            ['term' => ['refCategory_id' => ['value' => $diamonds['refCategory_id']]]],
                        ]
                    ]
                ]
            ]
        ];
        $recommended = $client->search($elastic_params);
        if ($recommended['hits']['hits'] && count($recommended['hits']['hits'])) {
            $recommended = $recommended['hits']['hits'];
        } else {
            $recommended = [];
        }

        if ($diamonds['refCategory_id'] == 1) {
            $similar_ids = collect($diamonds['attributes_id'])
                ->whereIn('attribute_group_id', [2, 3, 1])
                ->pluck('attribute_id')
                ->all();
        } else if ($diamonds['refCategory_id'] == 2) {
            $similar_ids = collect($diamonds['attributes_id'])
                ->whereIn('attribute_group_id', [10, 8, 7, 6])
                ->pluck('attribute_id')
                ->all();
        } else {
            $similar_ids = collect($diamonds['attributes_id'])
                ->whereIn('attribute_group_id', [18, 17, 16, 24])
                ->pluck('attribute_id')
                ->all();
        }

        $raw_attr = null;
        if (count($similar_ids)) {
            $attr_to_send = [];
            foreach ($similar_ids as $v) {
                $raw_attr .= '"da"."refAttribute_id" = ' . $v . ' or ';
                $attr_to_send['must'][] = [
                    'nested' => [
                        'query' => [
                            'term' => [
                                'attributes_id.attribute_id' => $v
                            ]
                        ],
                        'path' => 'attributes_id'
                    ]
                ];
            }
            $all_conditions = [
                [
                    'bool' => $attr_to_send
                ], [
                    'bool' => [
                        'must' => [
                            ['term' => ['refCategory_id' => ['value' => $diamonds['refCategory_id']]]],
                            [
                                'range' => [
                                    'expected_polish_cts' => [
                                        'from' => floatval($diamonds['expected_polish_cts'] - 0.001),
                                        'to' => floatval($diamonds['expected_polish_cts'] + 0.001)
                                    ],
                                ]
                            ]
                        ],
                        'must_not' => [
                            ['term' => ['diamond_id' => ['value' => $diamonds['diamond_id']]]],
                        ]
                    ]
                ]
            ];

            $elastic_params = [
                'index' => 'diamonds',
                'body'  => [
                    'size'  =>  10,
                    'query' => [
                        'bool' => [
                            'must' => $all_conditions
                        ]
                    ]
                ]
            ];
            $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();

            $similar = $client->search($elastic_params);
            $final_similar = [];
            $not_ids = [];
            $not_ids[] = $diamonds['diamond_id'];
            foreach ($similar['hits']['hits'] as $v) {
                $final_similar[] = $v;
                $not_ids[] = $v['_source']['diamond_id'];
            }
            $limit = 10 - count($similar['hits']['hits']);
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds['refCategory_id']]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds['expected_polish_cts'] - 0.001),
                                            'to' => floatval($diamonds['expected_polish_cts'] + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i % 1 == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds['refCategory_id']]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds['expected_polish_cts'] - 0.001),
                                            'to' => floatval($diamonds['expected_polish_cts'] + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i % 2 == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds['refCategory_id']]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds['expected_polish_cts'] - 0.001),
                                            'to' => floatval($diamonds['expected_polish_cts'] + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
            if ($limit > 0) {
                $attr_to_send = [];
                $i = 0;
                foreach ($similar_ids as $v) {
                    if ($i % 3 == 0) {
                        $attr_to_send['should'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    } else {
                        $attr_to_send['must'][] = [
                            'nested' => [
                                'query' => [
                                    'term' => [
                                        'attributes_id.attribute_id' => $v
                                    ]
                                ],
                                'path' => 'attributes_id'
                            ]
                        ];
                    }
                    $i++;
                }
                $all_conditions = [
                    [
                        'bool' => $attr_to_send
                    ], [
                        'bool' => [
                            'must' => [
                                ['term' => ['refCategory_id' => ['value' => $diamonds['refCategory_id']]]],
                                [
                                    'range' => [
                                        'expected_polish_cts' => [
                                            'from' => floatval($diamonds['expected_polish_cts'] - 0.001),
                                            'to' => floatval($diamonds['expected_polish_cts'] + 0.001)
                                        ],
                                    ]
                                ]
                            ],
                            'must_not' => [
                                ['terms' => ['diamond_id' => $not_ids]],
                            ]
                        ]
                    ]
                ];
                $elastic_params = [
                    'index' => 'diamonds',
                    'body'  => [
                        'size'  =>  $limit,
                        'query' => [
                            'bool' => [
                                'must' => $all_conditions
                            ]
                        ]
                    ]
                ];
                $similar = $client->search($elastic_params);
                foreach ($similar['hits']['hits'] as $v) {
                    $final_similar[] = $v;
                }
                $limit = $limit - count($similar['hits']['hits']);
            }
        } else {
            $final_similar = [];
        }
        $response_array['diamond'] = $diamonds;
        $response_array['recommended'] = $recommended;
        $response_array['similar'] = $final_similar;

        return $this->successResponse('Success', $response_array);
    }

    public function getCart()
    {
        $customer_id=Auth::id();
        $response_array=array();
        $diamonds = DB::table('customer_cart as c')
            ->join('diamonds as d', 'c.refDiamond_id', '=', 'd.diamond_id')
            ->join('categories as ct', 'd.refCategory_id', '=', 'ct.category_id')
            ->select('d.diamond_id', 'd.total','d.name as diamond_name', 'd.barcode', 'd.rapaport_price', 'd.expected_polish_cts as carat', 'd.image', 'd.video_link', 'd.total as price', 'd.rapaport_price as mrp', 'd.available_pcs', 'c.customer_cart_id', 'ct.name as ct_name')
            ->where('c.refCustomer_id', $customer_id)
            ->get();
            // ->toArray();

        if(!empty($diamonds[0]) && isset($diamonds[0])){
            $subtotal = 0;
            $weight = 0;
            $rm_ids = [];
            foreach ($diamonds as $value){
                $value->image = json_decode($value->image);
                /* $a = [];
                foreach ($value->image as $v1) {
                    $a[] = '/storage/other_images/' . $v1;
                }
                $value->image = $a; */
                if ($value->available_pcs > 0) {
                    $subtotal += $value->price;
                    $weight += $value->carat;
                } else {
                    $rm_ids[] = $value->customer_cart_id;
                }
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
            ->where('from_weight', '<=', intval($weight))
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

        $discount = !empty($discount) ? (($subtotal * $discount) / 100) : 0;
        $additional_discount = !empty($additional_discount) ? (($subtotal * $additional_discount) / 100) : 0;
        $tax = !empty($tax) ? ((($subtotal - $discount - $additional_discount) * $tax) / 100) : 0;
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
        $diamond_id = DB::table('share_cart')->where('share_cart_id', $share_cart_id)->first();
        if(!empty($diamond_id)){
            $dimond_id_1= json_decode($diamond_id->refDiamond_id);
            $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();
            $elastic_params = [
                'index' => 'diamonds',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                ['terms' => ['diamond_id' => $dimond_id_1]]
                            ]
                        ]
                    ]
                ]
            ];
            $diamonds = $client->search($elastic_params);

            if(isset($diamonds['hits']['hits']) && count($diamonds['hits']['hits'])){
                return $this->successResponse('Success', $diamonds);
            } else {
                return $this->errorResponse('This link is not valid');
            }
        } else {
            return $this->errorResponse('No Product in your cart to share');
        }
    }

    public function getSharableWishlist($share_wishlist_id)
    {
        $diamond_id=DB::table('share_wishlist')->where('share_wishlist_id', $share_wishlist_id)->first();
        if (!empty($diamond_id)) {
            $dimond_id_1 = json_decode($diamond_id->refDiamond_id);
            $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();
            $elastic_params = [
                'index' => 'diamonds',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                ['terms' => ['diamond_id' => $dimond_id_1]]
                            ]
                        ]
                    ]
                ]
            ];
            $diamonds = $client->search($elastic_params);

            if (isset($diamonds['hits']['hits']) && count($diamonds['hits']['hits'])) {
                return $this->successResponse('Success', $diamonds);
            } else {
                return $this->errorResponse('This link is not valid');
            }
        } else {
            return $this->errorResponse('No Product in your wishlist to share');
        }
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
        $user = Auth::user();
        $customer_id = $user->customer_id;
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
                        'date_added' => date("Y-m-d h:i:s"),
                        'created_at' => date("Y-m-d h:i:s"),
                        'updated_at' => date("Y-m-d h:i:s")
                    ];
                    $res=DB::table('customer_cart')->insert($data_array);
                    $Id = DB::getPdo()->lastInsertId();
                    if (!empty($Id)) {
                        $i=1;
                    }
                }
            }
            if($i==0){
                return $this->errorResponse('All diamonds are already in your cart');
            }
            if($i==1){
                customer_activity('inserted', $user->name . ' has added multiple diamonds to cart', '/customer/cart');
                return $this->successResponse('Success', [], 3);
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
        $user = Auth::user();
        $customer_id = $user->customer_id;
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
                customer_activity('inserted', $user->name . ' has added multiple diamonds to wishlist', '/customer/wishlist');
                return $this->successResponse('Success', [], 3);
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
        $user = Auth::user();
        $customer_id = $user->customer_id;
        $d_exist = DB::table('diamonds')
            ->where('diamond_id', $request->diamond_id)
            ->where('available_pcs', '>', 0)
            ->first();
        if (empty($d_exist)) {
            return $this->errorResponse('Selected diamond is out of stock');
        }
        $exist_cart = DB::table('customer_cart')
                ->where('refDiamond_id',$request->diamond_id)
                ->where('refCustomer_id',$customer_id)
                ->first();
        if(empty($exist_cart)){
            $data_array = [
                'refCustomer_id' => $customer_id,
                'refDiamond_id' => $request->diamond_id,
                'date_added' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
                'is_active' => 1
            ];
            $res=DB::table('customer_cart')->insert($data_array);
            // $Id = DB::getPdo()->lastInsertId();
            if (empty($res)) {
                return $this->errorResponse('Sorry, we are not able to add this diamond to your cart');
            }
            customer_activity('inserted', $user->name . ' has added diamond to cart (' . $d_exist->barcode . ')', '/customer/cart');
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
        $user = Auth::user();
        $customer_id = $user->customer_id;
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
            $d_exist = DB::table('diamonds')
                ->select('barcode')
                ->where('diamond_id', $request->diamond_id)
                ->first();
            customer_activity('deleted', $user->name . ' has removed diamond from cart (' . $d_exist->barcode . ')', '/customer/cart');
            return $this->successResponse('Success', [], 3);
        }
    }

    public function createShareCartLink(Request $request)
    {
        $user = Auth::user();
        $customer_id = $user->customer_id;
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
            DB::table('share_cart')->insert($data_array);
            $Id = DB::getPdo()->lastInsertId();
            if (empty($Id)) {
                return $this->errorResponse('Sorry, we are not able to generate link');
            }
            customer_activity('shared', $user->name . ' has created a link to share cart', '/customer/sharable-cart/' . $Id);
            return $this->successResponse('Success', $Id);
        } else {
            return $this->errorResponse('Your Cart is empty');
        }
    }

    public function createShareWishlistLink(Request $request)
    {
        $user = Auth::user();
        $customer_id = $user->customer_id;
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
            customer_activity('shared', $user->name . ' has created a link to share wishlist', '/customer/sharable-wishlist/' . $Id);
            return $this->successResponse('Success', $Id);
        } else {
            return $this->errorResponse('Your Wishlist is empty');
        }
    }

    public function getWishlist()
    {
        $customer_id = Auth::id();
        $diamond_ids = DB::table('customer_whishlist as cw')
            ->join('diamonds as d', 'cw.refdiamond_id', '=', 'd.diamond_id')
            ->select('cw.refdiamond_id')
            ->where('cw.refCustomer_id', $customer_id)
            ->pluck('refdiamond_id')
            ->toArray();
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $elastic_params = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['terms' => ['diamond_id' => $diamond_ids]]
                        ]
                    ]
                ]
            ]
        ];
        $diamonds = $client->search($elastic_params);

        if (isset($diamonds['hits']['hits']) && count($diamonds['hits']['hits'])) {
            return $this->successResponse('Success', $diamonds);
        } else {
            return $this->errorResponse('Your wishlist is empty');
        }
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

        $user = Auth::user();
        $customer_id = $user->customer_id;
        $d_exist = DB::table('diamonds')
            ->select('barcode')
            ->where('diamond_id', $request->diamond_id)
            ->where('available_pcs', '>', 0)
            ->first();
        if (empty($d_exist)) {
            return $this->errorResponse('Selected diamond is out of stock');
        }
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
            // $Id = DB::getPdo()->lastInsertId();
            if (empty($res)) {
                return $this->errorResponse('Sorry, we are not able to add this diamond to your wishlist');
            }
            customer_activity('inserted', $user->name . ' has added diamond to wishlist (' . $d_exist->barcode . ')', '/customer/wishlist');
            return $this->successResponse('Success', [], 3);
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
        $user = Auth::user();
        $customer_id = $user->customer_id;
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
            $d_exist = DB::table('diamonds')
                ->select('barcode')
                ->where('diamond_id', $request->diamond_id)
                ->first();
            customer_activity('deleted', $user->name . ' has removed diamond from wishlist (' . $d_exist->barcode . ')', '/customer/cart');
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
