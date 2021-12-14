<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Traits\APIResponse;
use App\Http\Controllers\API\DiamondController as DiamondApi;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rule;
// use App\Models\Customers;
// use App\Models\CustomerCompanyDetail;
// use App\Mail\EmailVerification;
use DB;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\API\DiamondController as APIDiamond;
use App\Exports\DiamondExport;
use App\Exports\DiamondExport4p;
use App\Exports\DiamondExportPolish;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use DataTables;
use Illuminate\Support\Facades\Session;
use Elasticsearch\ClientBuilder;

class DiamondController extends Controller {

    public function home(Request $request) {
        $title = 'Search Diamonds';
        $category = DB::table('categories')->select('category_id', 'name', 'slug')->where('slug', $request->category)->first();
        if (!$category) {
            abort(404, 'NO SUCH CATEGORY FOUND');
        }
        $data = DB::table('attribute_groups as ag')
                ->join('attributes as a', 'ag.attribute_group_id', '=', 'a.attribute_group_id')
                ->joinSub('SELECT "refAttribute_id", MAX(diamond_attribute_id) FROM diamonds_attributes group by "refAttribute_id"', 'da', function ($join) {
                    $join->on('da.refAttribute_id', '=' ,'a.attribute_id');
                })
                ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image', 'ag.is_fix', 'ag.refCategory_id', 'a.sort_order')
                ->where('ag.refCategory_id', $category->category_id)
                ->where('ag.field_type', 1)
                ->where('a.is_active', 1)
                ->where('a.is_deleted', 0)
                // ->groupBy('a.attribute_id')
                ->orderBy('ag.sort_order')
                ->orderBy('a.attribute_group_id')
                ->get()
                ->toArray();
        if (!count($data)) {
            return view('front.search_diamonds_empty', compact('title', 'category'));
        }
        $html = null;
        $temp_grp_id = 0;
        $temp_var = 0;
        $final_attribute_groups_with_att = array();

        $user = Auth::user();
        $file_arr = [];

        foreach ($data as $row_data) {
            if ($temp_grp_id != $row_data->attribute_group_id) {
                if ($temp_grp_id !== 0) {
                    usort($final_attribute_groups_with_att[$temp_grp_id]['attributes'], function ($a, $b) {
                        return $a['sort_order'] - $b['sort_order'];
                    });
                }
                $temp_grp_id = $row_data->attribute_group_id;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['name'] = $row_data->ag_name;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['is_fix'] = $row_data->is_fix;
                $temp_var = 0;
            }
            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['attribute_id'] = $row_data->attribute_id;
            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['name'] = $row_data->name;
            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = $row_data->image;
            $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['sort_order'] = $row_data->sort_order;
            $temp_var++;
        }
        if ($temp_grp_id !== 0) {
            usort($final_attribute_groups_with_att[$temp_grp_id]['attributes'], function ($a, $b) {
                return $a['sort_order'] - $b['sort_order'];
            });
        }
        $list = null;
        $max = DB::table('diamonds')
            ->selectRaw('max("total") as "max_price", min("total") as "min_price", max("expected_polish_cts") as "max_carat", min("expected_polish_cts") as "min_carat"')
            ->where('refCategory_id', $category->category_id)
            ->first();
        if ($max) {
            $min_price = $max->min_price;
            $max_price = $max->max_price;
            $min_carat = $max->min_carat;
            $max_carat = $max->max_carat;
        } else {
            $max_price = $min_carat = $max_carat = $min_price = 0;
        }
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if ($v['is_fix'] == 1 && $v['name'] != 'GRIDLE CONDITION') {
                if ($v['name'] == 'SHAPE') {
                    if (isset($v['attributes'])) {
                        foreach ($v['attributes'] as $v1) {
                            if (count($v['attributes']) > 1) {
                                if (in_array($v1['name'], ['Round Brilliant', 'ROUND', 'RO', 'BR'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                                } else if (in_array($v1['name'], ['Oval Brilliant', 'OV', 'Oval'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Oval_Brilliant_b.svg';
                                } else if (in_array($v1['name'], ['Cushion', 'CU'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Cushion_b.svg';
                                } else if (in_array($v1['name'], ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Pear_Brilliant_b.svg';
                                } else if (in_array($v1['name'], ['Princess Cut', 'PR', 'Princess'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Princess_Cut_b.svg';
                                } else if (in_array($v1['name'], ['Emerald', 'EM'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Emerald_b.svg';
                                } else if (in_array($v1['name'], ['Marquise', 'MQ'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Marquise_b.svg';
                                } else if (in_array($v1['name'], ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Heart_Brilliant_b.svg';
                                } else {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                                }
                                $list .= '<li class="item"><a href="javascript:void(0);"><img src="'.$src_img.'" class="image-shapes" alt="' . $v1['name'] . '" data-bs-toggle="tooltip" title="' . $v1['name'] . '" data-selected="0" data-attribute_id="' . $v1['attribute_id'] . '" data-name="' . $v1['name'] . '" data-group_id="' . $k . '"></a></li>';
                            }
                            $file_arr[$k][] = intval($v1['attribute_id']);
                        }
                        if (count($v['attributes']) > 1) {
                            $html .= '<div class="col col-12 col-sm-12 col-lg-6">
                            <div class="row">
                            <div class="col-md-2 col-sm-2 filter-text diamond-shape ">
                                <b>SHAPE</b>&nbsp;<span class=""><i class="fas fa-question-circle"></i></span>
                            </div>
                                <div class="diamond-shape filter-item align-items-center col-md-10 col-sm-10">
                                    <ul class="list-unstyled mb-0 diamond_shape">
                                        ' . $list . '
                                    </ul>
                                </div>
                                </div>
                            </div>';
                        }
                    }
                    $html .= '<div class="col col-12 col-sm-12 col-lg-6">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 filter-text diamond-cart">
                               <b>PRICE</b>&nbsp;<span class=""><i class="fas fa-question-circle"></i></span>
                            </div>
                            <div class="diamond-cart filter-item col-md-10 col-sm-10">
                                <div class="range-sliders">
                                    <div class="slider-styled" id="priceSlider"></div>
                                    $<input type="text" id="minPrice" class="w-5r">
                                    <div class="float-right">$<input type="text" id="maxPrice" class="w-5r text-right"></div>
                                </div>
                            </div>
                        </div>
                        <script>
                            var priceSlider = document.getElementById("priceSlider");
                            var minPriceJs = document.getElementById("minPrice");
                            var maxPriceJs = document.getElementById("maxPrice");
                            var priceJs = [minPriceJs, maxPriceJs];
                            noUiSlider.create(priceSlider, {
                                start: [' . $min_price . ', ' . $max_price . '],
                                // step: 10,
                                connect: true,
                                // tooltips: [true, wNumb({ decimals: 2 })],
                                range: { "min": ' . $min_price . ', "max": ' . $max_price . ' }
                            });
                            priceSlider.noUiSlider.on("update", function (values, handle) {
                                priceJs[handle].value = values[handle];
                                new_call = true;
                                if(onchange_call == true){
                                    global_data_offset = 0;
                                    $("#result-table tbody").html("");
                                }
                            });
                            priceSlider.noUiSlider.on("set", function (values, handle) {
                                priceJs[handle].value = values[handle];
                                new_call = true;
                                if(onchange_call == true){
                                    global_data_offset = 0;
                                    $("#result-table tbody").html("");
                                    getDiamonds(this.get(), [], "price");
                                }
                            });
                            // Listen to keydown events on the input field.

                            priceJs.forEach(function (input, handle) {
                                input.addEventListener("change", function () {
                                    priceSlider.noUiSlider.setHandle(handle, this.value);
                                });
                                input.addEventListener("keydown", function (e) {
                                    var values = priceSlider.noUiSlider.get();
                                    var value = Number(values[handle]);
                                    var steps = priceSlider.noUiSlider.steps();
                                    var step = steps[handle];
                                    var position;
                                    // 13 is enter, 38 is key up, 40 is key down.
                                    switch (e.which) {
                                        case 13:
                                            priceSlider.noUiSlider.setHandle(handle, this.value);
                                            getDiamonds(priceSlider.noUiSlider.get(), [], "price");
                                            break;
                                        case 38:
                                            // Get step to go increase slider value (up)
                                            position = step[1];
                                            // false = no step is set
                                            if (position === false) {
                                                position = 1;
                                            }
                                            // null = edge of slider
                                            if (position !== null) {
                                                priceSlider.noUiSlider.setHandle(handle, value + position);
                                            }
                                            break;
                                        case 40:
                                            position = step[0];
                                            if (position === false) {
                                                position = 1;
                                            }
                                            if (position !== null) {
                                                priceSlider.noUiSlider.setHandle(handle, value - position);
                                            }
                                            break;
                                    }
                                });
                            });
                        </script>
                    </div>';
                } else {
                    if (isset($v['attributes'])) {
                        $values = [];
                        $default_values = [];
                        $i = 0;
                        foreach ($v['attributes'] as $v1) {
                            if (count($v['attributes']) > 1) {
                                $values[] = $v1['name'];
                                $default_values[$i]['attribute_id'] = $v1['attribute_id'];
                                $default_values[$i]['name'] = $v1['name'];
                                $i++;
                            }
                            $file_arr[$k][] = intval($v1['attribute_id']);
                        }
                        if (count($v['attributes']) > 1) {
                            $html .= '<div class="col col-12 col-sm-12 col-lg-6">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 filter-text diamond-cut ">
                                    <b>' . strtoupper($v['name']) . '</b>&nbsp;<span class=""><i class="fas fa-question-circle"></i></span>
                                </div>
                                    <div class="diamond-cut filter-item  col-md-10 col-sm-10">

                                        <div class="range-sliders">
                                            <input type="text" id="Slider' . $k . '"/>
                                        </div>
                                    </div>
                                </div>
                                </div>';
                            $html .= "<script type='text/javascript'>
                                var Slider" . $k . " = new rSlider({
                                    target: '#Slider" . $k . "',
                                    values: ['" . implode("','", $values) . "'],
                                    range: true,
                                    tooltip: false,
                                    scale: true,
                                    labels: true,
                                    set: ['" . $values[0] . "', '" . $values[(count($values) - 1)] . "'],
                                    onChange: function (vals) {
                                        var array = " . json_encode($default_values) . ";
                                        new_call = true;
                                        if(onchange_call == true){
                                            global_data_offset = 0;
                                            $('#result-table tbody').html('');
                                            getDiamonds(vals, array, " . $k . ");
                                        }
                                    }
                            });
                            </script>";
                        }
                    }
                }
            }
        }
        $html .= '<div class="col col-12 col-sm-12 col-lg-6">
                <div class="row">
                <div class="col-md-2 col-sm-2 filter-text diamond-cart">
                <b>CARAT</b>&nbsp;<span class=""><i class="fas fa-question-circle"></i></span>
                </div>
                    <div class="diamond-cart  col-md-10 col-sm-10">
                        <div class="range-sliders">
                            <div class="slider-styled" id="caratSlider"></div>
                            <input type="text" id="minCarat" class="w-5r">
                            <input type="text" id="maxCarat" class="float-right w-5r text-right">
                        </div>
                    </div>
                    </div>
                    <script>
                        var caratSlider = document.getElementById("caratSlider");
                        var minCaratJs = document.getElementById("minCarat");
                        var maxCaratJs = document.getElementById("maxCarat");
                        var caratJs = [minCaratJs, maxCaratJs];
                        noUiSlider.create(caratSlider, {
                            start: [' . $min_carat . ', ' . $max_carat . '],
                            step: 0.01,
                            connect: true,
                            // tooltips: [true, wNumb({ decimals: 2 })],
                            range: { "min": ' . $min_carat . ', "max": ' . $max_carat . ' }
                        });
                        caratSlider.noUiSlider.on("update", function (values, handle) {
                            caratJs[handle].value = values[handle];
                            new_call = true;
                            if(onchange_call == true){
                                global_data_offset = 0;
                                $("#result-table tbody").html("");
                            }
                        });
                        caratSlider.noUiSlider.on("set", function (values, handle) {
                            new_call = true;
                            if(onchange_call == true){
                                global_data_offset = 0;
                                $("#result-table tbody").html("");
                                getDiamonds(this.get(), [], "carat");
                            }
                        });
                        // Listen to keydown events on the input field.
                        caratJs.forEach(function (input, handle) {
                            input.addEventListener("change", function () {
                                caratSlider.noUiSlider.setHandle(handle, this.value);
                            });
                            input.addEventListener("keydown", function (e) {
                                var values = caratSlider.noUiSlider.get();
                                var value = Number(values[handle]);
                                var steps = caratSlider.noUiSlider.steps();
                                var step = steps[handle];
                                var position;
                                // 13 is enter, 38 is key up, 40 is key down.
                                switch (e.which) {
                                    case 13:
                                        caratSlider.noUiSlider.setHandle(handle, this.value);
                                        getDiamonds(caratSlider.noUiSlider.get(), [], "carat");
                                        break;
                                    case 38:
                                        // Get step to go increase slider value (up)
                                        position = step[1];
                                        // false = no step is set
                                        if (position === false) {
                                            position = 1;
                                        }
                                        // null = edge of slider
                                        if (position !== null) {
                                            caratSlider.noUiSlider.setHandle(handle, value + position);
                                        }
                                        break;
                                    case 40:
                                        position = step[0];
                                        if (position === false) {
                                            position = 1;
                                        }
                                        if (position !== null) {
                                            caratSlider.noUiSlider.setHandle(handle, value - position);
                                        }
                                        break;
                                }
                            });
                        });
                    </script>
                </div>';

        $none_fix = null;
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if ($v['is_fix'] === 0 && $v['name'] != 'GRIDLE CONDITION') {
                if ($v['name'] == 'SHAPE') {
                    if (isset($v['attributes'])) {
                        foreach ($v['attributes'] as $v1) {
                            if (count($v['attributes']) > 1) {
                                if (in_array($v1['name'], ['Round Brilliant', 'ROUND', 'RO', 'BR'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                                } else if (in_array($v1['name'], ['Oval Brilliant', 'OV', 'Oval'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Oval_Brilliant_b.svg';
                                } else if (in_array($v1['name'], ['Cushion', 'CU'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Cushion_b.svg';
                                } else if (in_array($v1['name'], ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Pear_Brilliant_b.svg';
                                } else if (in_array($v1['name'], ['Princess Cut', 'PR', 'Princess'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Princess_Cut_b.svg';
                                } else if (in_array($v1['name'], ['Emerald', 'EM'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Emerald_b.svg';
                                } else if (in_array($v1['name'], ['Marquise', 'MQ'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Marquise_b.svg';
                                } else if (in_array($v1['name'], ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Heart_Brilliant_b.svg';
                                } else {
                                    $src_img = '/assets/images/d_images/Diamond_Shapes_Round_Brilliant_b.svg';
                                }
                                $list .= '<li class="item"><a href="javascript:void(0);"><img src="' . $src_img . '" class="img-fluid d-block" alt="' . $v1['name'] . '" data-selected="0" data-attribute_id="' . $v1['attribute_id'] . '" data-name="' . $v1['name'] . '" data-group_id="' . $k . '"></a></li>';
                            }
                            $file_arr[$k][] = intval($v1['attribute_id']);
                        }
                        if (count($v['attributes']) > 1) {
                            $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2 filter-toggle">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 filter-text diamond-shape">
                                    <b>SHAPE</b>&nbsp;<span class=""><i class="fas fa-question-circle"></i></span>
                                    </div>
                                    <div class="diamond-shape filter-item col-md-10 col-sm-10">
                                        <ul class="list-unstyled mb-0 diamond_shape">
                                            ' . $list . '
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                } else {
                    if (isset($v['attributes'])) {
                        $values = [];
                        $default_values = [];
                        $i = 0;
                        foreach ($v['attributes'] as $v1) {
                            if (count($v['attributes']) > 1) {
                                $values[] = $v1['name'];
                                $default_values[$i]['attribute_id'] = $v1['attribute_id'];
                                $default_values[$i]['name'] = $v1['name'];
                                $i++;
                            }
                            $file_arr[$k][] = intval($v1['attribute_id']);
                        }
                        if (count($v['attributes']) > 1) {
                            $none_fix .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2 filter-toggle">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 filter-text diamond-cut ">
                                            <b>' . strtoupper($v['name']) . '</b>
                                        </div>
                                        <div class="diamond-cut filter-item col-md-10 col-sm-10">
                                            <div class="range-sliders">
                                                <input type="text" id="Slider' . $k . '"/>
                                            </div>
                                        </div>
                                </div>
                                </div>';
                            $none_fix .= "<script type='text/javascript'>
                                var Slider" . $k . " = new rSlider({
                                    target: '#Slider" . $k . "',
                                    values: ['" . implode("','", $values) . "'],
                                    range: true,
                                    tooltip: false,
                                    scale: true,
                                    labels: true,
                                    set: ['" . $values[0] . "', '" . $values[(count($values) - 1)] . "'],
                                    onChange: function (vals) {
                                        var array = " . json_encode($default_values) . ";
                                        new_call = true;
                                        if(onchange_call == true){
                                            global_data_offset = 0;
                                            $('#result-table tbody').html('');
                                            getDiamonds(vals, array, " . $k . ");
                                        }
                                    }
                            });
                            </script>";
                        }
                    }
                }
            }
        }
        $file_arr['price_min'] = $min_price;
        $file_arr['price_max'] = $max_price;
        $file_arr['carat_min'] = $min_carat;
        $file_arr['carat_max'] = $max_carat;
        $file_name = $user->customer_id . '-' . $category->category_id;
        file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name, json_encode($file_arr, JSON_PRETTY_PRINT));
        $recently_viewed = DB::table('recently_view_diamonds as rvd')
            ->join('diamonds as d', 'rvd.refDiamond_id', '=', 'd.diamond_id')
            ->select('rvd.refCustomer_id', 'rvd.refDiamond_id', 'rvd.refAttribute_group_id', 'rvd.refAttribute_id', 'rvd.carat', 'rvd.price', 'rvd.shape', 'rvd.cut', 'rvd.color', 'rvd.clarity', 'd.name', 'd.image', 'd.barcode', 'd.makable_cts', 'd.available_pcs')
            ->where('d.refCategory_id', $category->category_id)
            ->where('rvd.refCustomer_id', $user->customer_id)
            ->orderBy('rvd.updated_at', 'desc')
            ->get();
        return view('front.search_diamonds', compact('title', 'html', 'none_fix', 'recently_viewed', 'category'));
    }

    public function addToCart(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->addToCart($request);
        if (!empty($result->original['code']) && $result->original['code']==3) {
            $data = array(
                'suceess' => true
            );
        } else {
            // $res = json_decode();
            $data = array(
                'suceess' => false,
                'message' => $result->original['message']
            );
        }
        return response()->json($data);
    }

    public function addAllToCart(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->addAllToCart($request);
        if (!empty($result->original['code']) && $result->original['code']==3) {
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

    public function addAllToWishlist(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->addAllToWishlist($request);
        if (!empty($result->original['code']) && $result->original['code']==3) {
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

    public function removeFromCart(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->removeFromCart($request);
        if (!empty($result->original['code']) && $result->original['code']==3) {
            $total=0;
            $result_cart = $diamond_api_controller->getCart();
            if (!empty($result_cart->original['data'])) {
                /* foreach($result_cart->original['data'] as $row) {
                    $total=$total+$row->total;
                } */
                $data = $result_cart->original['data']['summary'];
            }
            $res = array(
                'suceess' => true,
                'data' => $data ?? []
            );
        } else {
            $res = array(
                'suceess' => false
            );
        }
        return response()->json($res);
    }

    public function searchListDiamondsPolish(Request $request) {

        $response = $request->all();
        $user = Auth::user();
        $file_name = $user->customer_id . '-' . $response['params']['category'];
        if (file_exists(base_path() . '/storage/framework/diamond-filters/' . $file_name)) {
            $arr = file_get_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name);
            $arr = json_decode($arr, true);
        }
        if (isset($response['params']['attribute_values'])) {
            if (is_array($response['params']['attribute_values']) && $response['params']['group_id'] != 'price' && $response['params']['group_id'] != 'carat') {
                $response = collect($response['params']['attribute_values'])->pluck('attribute_id')->values()->all();
                $arr[$request->params['group_id']] = $response;
            } else {
                if ($response['params']['group_id'] == 'price') {
                    $arr['price_min'] = $response['params']['attribute_values'][0];
                    $arr['price_max'] = $response['params']['attribute_values'][1];
                } else {
                    $arr['carat_min'] = $response['params']['attribute_values'][0];
                    $arr['carat_max'] = $response['params']['attribute_values'][1];
                }
            }
            file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name, json_encode($arr, JSON_PRETTY_PRINT));
        }
        $arr['category'] = $request->params['category'];
        $arr['category_slug'] = $request->params['category_slug'];
        $arr['gateway'] = 'web';
        $arr['column'] = $request->params['column'] ?? 'barcode';
        $arr['asc_desc'] = $request->params['asc_desc'] ?? 'asc';
        $arr['search_barcode'] = $request->params['search_barcode'] ?? null;
        $arr['offset'] = $request->params['offset'];

        if ($request->ajax()) {
            $final_data=[];
            $aa = new APIDiamond;
            $request->request->add(['attr_array' => $arr]);
            $result = $aa->searchDiamonds($request);
            $data = $result->original['data']['diamonds'];
            if (count($data) < 1) {
                return response()->json(['success' => 1, 'message' => 'No records found', 'data' => [], 'count' => 0]);
            }
            foreach ($data as $v) {
                $final_data[] = $v['_source'];
            }

            if (Session::has('loginId') && Session::has('user-type') && session('user-type') == "MASTER_ADMIN") {
                $cart_or_box = '<label class="custom-check-box">
                                    <input type="checkbox" class="diamond-checkbox" data-id="v_diamond_id" >
                                    <span class="checkmark"></span>
                                </label>';
            } else {
                $cart_or_box = '<button class="btn btn-primary add-to-cart btn-sm" data-id="v_diamond_id">Add To Cart</button>';
            }
            $html = [];
            $i = 0;
            foreach ($final_data as $v) {
                if (count($v['image'])) {
                    $img_src = $v['image'][0];
                } else {
                    $img_src = '/assets/images/No-Preview-Available.jpg';
                }
                $html[$i] = '<tr class="" data-diamond="' . $v['diamond_id'] . '" data-price="$' . number_format($v['total'], 2, '.', ',') . '" data-name="' . $v['name'] . '" data-image="' . $img_src . '" data-barcode="' . $v['barcode'] . '">';

                if (isset($v['attributes']['CERTIFICATE URL'])) {
                    $a_tag = '<a class="show-certi" href="' . $v['attributes']['CERTIFICATE URL'] . '" target="_blank"> ' . $v['barcode'] . '</a>';
                } else {
                    $a_tag = '<a href="javascript:void(0);"> ' . $v['barcode'] . '</a>';
                }
                $html[$i] .= '<td scope="col" class="text-center">' . $a_tag . ' <a href="/customer/single-diamonds/' . $v['barcode'] . '" target="_blank"> </a> </td>';

                if (isset($v['attributes']['SHAPE'])) {
                    $html[$i] .= '<td scope="col" class="text-center">' . $v['attributes']['SHAPE'] . '</td>';
                } else {
                    $html[$i] .= '<td scope="col" class="text-center"> - </td>';
                }

                if ($request->params['category_slug'] != 'polish-diamonds') {
                    $html[$i] .= '<td scope="col" class="text-center">' . $v['makable_cts'] . '</td>';
                }

                $html[$i] .= '<td scope="col" class="text-center">' . $v['expected_polish_cts'] . '</td>';

                if (isset($v['attributes']['COLOR'])) {
                    $html[$i] .= '<td scope="col" class="text-center">' . $v['attributes']['COLOR'] . '</td>';
                } else {
                    $html[$i] .= '<td scope="col" class="text-center"> - </td>';
                }

                if (isset($v['attributes']['CLARITY'])) {
                    $html[$i] .= '<td scope="col" class="text-center">' . $v['attributes']['CLARITY'] . '</td>';
                } else {
                    $html[$i] .= '<td scope="col" class="text-center"> - </td>';
                }

                if ($request->params['category_slug'] != 'rough-diamonds') {
                    if (isset($v['attributes']['CUT'])) {
                        $html[$i] .= '<td scope="col" class="text-center">' . $v['attributes']['CUT'] . '</td>';
                    } else {
                        $html[$i] .= '<td scope="col" class="text-center"> - </td>';
                    }
                }

                /* if ($v['refCategory_id'] == 1) {
                    $html[$i] .= '<td scope="col" class="text-right">$' . number_format(($v['total'] / $v['makable_cts']), 2, '.', ',') . '</td>';
                } else {
                    $html[$i] .= '<td scope="col" class="text-right">$' . number_format(($v['rapaport_price']) * ((1 - $v['discount'])), 2, '.', ',') . '</td>';
                } */

                $html[$i] .= '<td scope="col" class="text-right">$' . number_format($v['price_ct'], 2, '.', ',') . '</td>
                    <td scope="col" class="text-right">$' . number_format($v['total'], 2, '.', ',') . '</td>
                    <td scope="col" class="text-center">
                            <div class="compare-checkbox">
                                ' . str_replace('v_diamond_id', $v['diamond_id'], $cart_or_box) . '
                            </div>
                        </td>
                    </tr>';
                $i++;
            }
            return response()->json([
                'success' => 1,
                'message' => 'Success',
                'data' => $html,
                'count' => $result->original['data']['total_diamonds']
            ]);
        }
    }

    public function exportDiamonds(Request $request)
    {
        $response = $request->all();
        $user = Auth::user();
        if ($response['params']['selected_d'] == 'selected') {
            $ids = json_decode($response['params']['ids']);
            $client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();
            $elastic_params = [
                'index' => 'diamonds',
                'body'  => [
                    'size'  => 10000,
                    'query' => [
                        'bool' => [
                            'must' => [
                                [ 'terms' => [ 'diamond_id' => $ids ] ],
                                [ 'term' => ['refCategory_id' => ['value' => intval($response['params']['category'])]]]
                            ]
                        ]
                    ]
                ]
            ];
            $data = $client->search($elastic_params);
            $data = $data['hits']['hits'];
        } else  {
            $file_name = $user->customer_id . '-' . $response['params']['category'];
            $arr = file_get_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name);
            $arr = json_decode($arr, true);
            $arr['category'] = $request->params['category'];
            $arr['category_slug'] = $request->params['category_slug'];
            $arr['gateway'] = 'web';
            $arr['column'] = $request->params['column'] ?? 'barcode';
            $arr['asc_desc'] = $request->params['asc_desc'] ?? 'asc';
            $arr['search_barcode'] = null;
            $arr['export'] = 'export';

            $aa = new APIDiamond;
            $request->request->add(['attr_array' => $arr]);
            $result = $aa->searchDiamonds($request);
            $data = $result->original['data']['diamonds'];
        }

        if (isset($response['params']['export'])) {

            if($response['params']['export']=='export-admin'){
                if($response['params']['discount']=='' || $response['params']['discount']==0){
                    $response['params']['discount']=0;
                }
                // $rapaport = DB::table('rapaport')->orderBy('rapaport_price','desc')->get();
                $cat_type = DB::table('categories')->where('is_active', 1)->where('category_id', $response['params']['category'])->where('is_deleted', 0)->first();

                $diamonds = $data;

                if (!empty($diamonds) && count($diamonds)) {
                    $data = [];
                    $discount = doubleval((100 - $response['params']['discount']) / 100);
                    if ($cat_type->category_type == config('constant.CATEGORY_TYPE_4P')) {
                        $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
                        foreach ($diamonds as $row) {
                            $row = $row['_source'];
                            $total = abs($row['rapaport_price'] * $row['expected_polish_cts'] * $discount) - ($labour_charge_4p->amount*$row['expected_polish_cts']);

                            $dummeyArray=array();
                            $dummeyArray['BARCODE']=$row['barcode'];
                            $dummeyArray['MAIN PKTNO']=$row['packate_no'];
                            $dummeyArray['SHAPE']=$row['attributes']['SHAPE'];
                            $dummeyArray['EXP POL SIZE']=$row['attributes']['EXP POL SIZE'];
                            $dummeyArray['COLOR']=$row['attributes']['COLOR'];
                            $dummeyArray['CLARITY']=$row['attributes']['CLARITY'];
                            $dummeyArray['MKBL CTS']=$row['makable_cts'];
                            $dummeyArray['EXP POL CTS']=$row['expected_polish_cts'];
                            $dummeyArray['Labour Charges/CT'] = $labour_charge_4p->amount;
                            $dummeyArray['Rapaport Price/CT'] = $row['rapaport_price'];
                            $dummeyArray['DISCOUNT'] = $response['params']['discount'].'%';
                            $dummeyArray['Price/CT'] = round($total / $row['expected_polish_cts'], 2);
                            $dummeyArray['Price'] = $total;
                            $dummeyArray['REMARKS']=$row['remarks'];
                            $dummeyArray['HALF-CUT DIA']=$row['attributes']['HALF-CUT DIA'];
                            $dummeyArray['HALF-CUT HGT']=$row['attributes']['HALF-CUT HGT'];
                            $dummeyArray['PO. DIAMETER']=$row['attributes']['PO. DIAMETER'];
                            $dummeyArray['Location']=$row['attributes']['Location'] ?? null;
                            $dummeyArray['Comment']=$row['attributes']['Comment'] ?? null;
                            $dummeyArray['VIDEO LINK']=$row['video_link'];

                            $dummeyArray['image-1'] = $row['image'][0] ?? null;
                            $dummeyArray['image-2'] = $row['image'][1] ?? null;
                            $dummeyArray['image-3'] = $row['image'][2] ?? null;
                            $dummeyArray['image-4'] = $row['image'][3] ?? null;
                            array_push($data,$dummeyArray);
                        }
                    }
                    if ($cat_type->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                        $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
                        foreach ($diamonds as $row) {
                            $row = $row['_source'];

                            $price=abs($row['rapaport_price']*$discount);
                            $amount=abs($price*doubleval($row['expected_polish_cts']));
                            $ro_amount=abs($amount/doubleval($row['makable_cts']));
                            $final_price=$ro_amount-$labour_charge_rough->amount;
                            $total=abs($final_price*(doubleval($row['makable_cts'])));

                            $dummeyArray=array();
                            $dummeyArray['Barcode']=$row['barcode'];
                            $dummeyArray['Pktno']=$row['packate_no'];

                            $dummeyArray['Org Cts']=$row['makable_cts'];
                            $dummeyArray['Exp Pol']=$row['expected_polish_cts'];
                            $dummeyArray['SHAPE']=$row['attributes']['SHAPE'];
                            $dummeyArray['COLOR']=$row['attributes']['COLOR'];
                            $dummeyArray['CLARITY']=$row['attributes']['CLARITY'];
                            $dummeyArray['Discount']=$response['params']['discount'].'%';
                            $dummeyArray['Labour Charges/CT'] = $labour_charge_rough->amount;
                            $dummeyArray['Rapaport Price/CT'] = $row['rapaport_price'];
                            $dummeyArray['Price/CT'] = round($total / $row['makable_cts'], 2);
                            $dummeyArray['Price'] = $total;
                            $dummeyArray['Location']=$row['attributes']['Location'] ?? null;
                            $dummeyArray['Comment']=$row['attributes']['Comment'] ?? null;

                            $dummeyArray['image-1'] = $row['image'][0] ?? null;
                            $dummeyArray['image-2'] = $row['image'][1] ?? null;
                            $dummeyArray['image-3'] = $row['image'][2] ?? null;
                            $dummeyArray['image-4'] = $row['image'][3] ?? null;

                            $dummeyArray['Video'] = $row['video_link'];
                            array_push($data,$dummeyArray);
                        }
                    }
                    if ($cat_type->category_type == config('constant.CATEGORY_TYPE_POLISH')) {
                        foreach ($diamonds as $row) {
                            $row = $row['_source'];
                            $total=abs($row['rapaport_price']*$row['expected_polish_cts']*$discount);

                            $dummeyArray = array();
                            $dummeyArray['Stock'] = $row['barcode'];
                            $dummeyArray['Availability'] = $row['available_pcs'];
                            $dummeyArray['SHAPE'] = $row['attributes']['SHAPE'];
                            $dummeyArray['Weight'] = $row['expected_polish_cts'];
                            $dummeyArray['Clarity'] = $row['attributes']['CLARITY'];
                            $dummeyArray['Color'] = $row['attributes']['COLOR'];
                            $dummeyArray['Cut Grade'] = $row['attributes']['CUT'];
                            $dummeyArray['Rapaport Price/CT'] = $row['rapaport_price'];
                            $dummeyArray['Discount Percent'] = $response['params']['discount'] . '%';
                            $dummeyArray['Price/CT'] = round($total / $row['expected_polish_cts'], 2);
                            $dummeyArray['Price'] = $total;
                            $dummeyArray['Polish'] = $row['attributes']['POLISH'];
                            $dummeyArray['Symmetry'] = $row['attributes']['SYMMETRY'];
                            $dummeyArray['Depth Percent'] = $row['attributes']['DEPTH PERCENT'];
                            $dummeyArray['Table Percent'] = $row['attributes']['TABLE PERCENT'];
                            $dummeyArray['Lab'] = $row['attributes']['LAB'];
                            $dummeyArray['Certificate'] = $row['attributes']['CERTIFICATE'];
                            $dummeyArray['Certificate Url'] = $row['attributes']['CERTIFICATE URL'];
                            $dummeyArray['Culet Size'] = $row['attributes']['CULET SIZE'];
                            $dummeyArray['Girdle Percent'] = $row['attributes']['GIRDLE PERCENT'];
                            $dummeyArray['Girdle Condition'] = $row['attributes']['GRIDLE CONDITION'];
                            $dummeyArray['Measurements'] = $row['attributes']['MEASUREMENTS'];
                            $dummeyArray['Pavilion Depth'] = $row['attributes']['PAVILION DEPTH'];
                            $dummeyArray['Crown Height'] = $row['attributes']['CROWN HEIGHT'];
                            $dummeyArray['Crown Angle'] = $row['attributes']['CROWN ANGLE'];
                            $dummeyArray['Pavilion Angle'] = $row['attributes']['PAVILION ANGLE'];
                            $dummeyArray['Growth Type'] = $row['attributes']['GROWTH TYPE'];
                            $dummeyArray['Comment'] = $row['attributes']['Comment'] ?? null;
                            $dummeyArray['Location'] = $row['attributes']['Location'] ?? null;

                            $dummeyArray['Video Link'] = $row['video_link'];
                            $dummeyArray['image-1'] = $row['image'][0] ?? null;
                            $dummeyArray['image-2'] = $row['image'][1] ?? null;
                            $dummeyArray['image-3'] = $row['image'][2] ?? null;
                            $dummeyArray['image-4'] = $row['image'][3] ?? null;
                            array_push($data, $dummeyArray);
                        }
                    }
                }

                $filename=time().".xlsx";
                if ($cat_type->category_type == config('constant.CATEGORY_TYPE_4P')) {
                    Excel::store(new DiamondExport4p($data), "public/excel_export/".$filename);
                }
                if ($cat_type->category_type == config('constant.CATEGORY_TYPE_ROUGH')) {
                    Excel::store(new DiamondExport($data), "public/excel_export/".$filename);
                }
                if ($cat_type->category_type == config('constant.CATEGORY_TYPE_POLISH')) {
                    Excel::store(new DiamondExportPolish($data), "public/excel_export/".$filename);
                }

                $excel = public_path('storage/excel_export/'.$filename);
                return response()->download($excel);
            }

            if($response['params']['export']=='export'){
                $category = DB::table('categories')
                    ->select('name', 'slug')
                    ->where('category_id', $request->params['category'])
                    // ->pluck('name')
                    ->first();
                $diamonds = $data;
                $pdf = PDF::loadView('front.export-pdf', compact('diamonds', 'category'));
                $path = public_path('pdf/');
                $fileName =  time() . '.' . 'pdf';
                $pdf->save($path . '/' . $fileName);
                $pdf = public_path('pdf/' . $fileName);
                return response()->download($pdf);
            }
        } else {

        }
    }

    public function pdfpreview()
    {
        return view('front.export-pdf');
    }

    public function checkout() {
        $response=array();
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->getCart();
        $response = $result->original['data'];
        if (!count($response)) {
            return redirect('/customer/dashboard');
        }
        $title = 'Checkout';
        return view('front.checkout', compact('title', 'response'));
    }

    public function getCart() {
        $response=array();
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->getCart();
        $response = $result->original['data'];
        /* if (!count($response)) {
            return redirect('/customer/dashboard');
        } */
        $title = 'Cart';
        return view('front.cart', compact('title', 'response'));
    }

    public function createShareCartLink(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->createShareCartLink($request);
        if (!empty($result->original['data'])) {
            $data = array(
                'suceess' => true,
                'link_id'=> $result->original['data']
            );
        } else {
            $data = array(
                'suceess' => false
            );
        }
        return response()->json($data);
    }

    public function createShareWishlistLink(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->createShareWishlistLink($request);
        if (!empty($result->original['data'])) {
            $data = array(
                'suceess' => true,
                'link_id'=> $result->original['data']
            );
        } else {
            $data = array(
                'suceess' => false
            );
        }
        return response()->json($data);
    }

    public function getSharableCart($share_cart_id) {
        $response=array();
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->getSharableCart($share_cart_id);
        if (!empty($result->original['data'])) {
            $response = $result->original['data'];
        }
        $title = 'Sharable-Cart';
        return view('front.sharable-cart', compact('title', 'response','share_cart_id'));
    }

    public function getSharableWishlist($share_wishlist_id) {
        $response=array();
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->getSharableWishlist($share_wishlist_id);
        if (!empty($result->original['data'])) {
            $response = $result->original['data'];
        }
        $title = 'Sharable-Wishlist';
        return view('front.sharable-wishlist', compact('title', 'response','share_wishlist_id'));
    }

    public function diamondDetails($barcode) {
        $response=array();
        $attributes=array();
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->detailshDiamonds($barcode);
        if (!empty($result->original['data'])) {
            $response = $result->original['data'];
            $attributes = $result->original['data']['attribute'];
            $recommended = collect($result->original['data']['recommended'])->slice(-0, 4);
            $similar = collect($result->original['data']['similar'])->slice(-0, 4);
            $category = DB::table('categories')
                ->select('slug')
                ->where('category_id', $result->original['data']['refCategory_id'])
                ->first();
            $response['category'] = $category->slug;
        } else {
            $response = [];
            $attributes = [];
            $recommended = [];
            $similar = [];
        }
        $title = 'Diamond Details';
        return view('front.diamond-details', compact('title', 'response', 'attributes', 'similar', 'recommended'));
    }

    public function addToWishlist(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->addToWishlist($request);
        if (!empty($result->original['code']) && $result->original['code']==3) {
            $data = array(
                'suceess' => true
            );
        } else {
            $data = array(
                'suceess' => false,
                'message' => $result->original['message']
            );
        }
        return response()->json($data);
    }

    public function removeFromWishlist(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->removeFromWishlist($request);
        if (!empty($result->original['code']) && $result->original['code']==3) {
            $data = array(
                'suceess' => true,
            );
        } else {
            $data = array(
                'suceess' => false
            );
        }
        return response()->json($data);
    }

    public function getWishlist() {
        $response=array();
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->getWishlist();
        if (!empty($result->original['data'])) {
            $response = $result->original['data'];
        }
        $title = 'Wishlist';
        return view('front.wishlist', compact('title', 'response'));
    }

    public function clearDiamondsFromDB(Request $request) {
        DB::table($request->table)->truncate();
        // DB::table('diamonds')->truncate();
        // DB::table('diamonds_attributes')->truncate();
    }

}
