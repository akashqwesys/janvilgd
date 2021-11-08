<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\APIResponse;
use App\Http\Controllers\API\DiamondController as DiamondApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use App\Mail\EmailVerification;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\API\DiamondController as APIDiamond;

class DiamondController extends Controller {

    public function home(Request $request) {
        $category = DB::table('categories')->select('category_id')->where('category_id', $request->category)->first();
        if (!$category) {
            abort(404, 'NO SUCH CATEGORY FOUND');
        }
        $data = DB::table('attribute_groups as ag')
                ->join('attributes as a', 'ag.attribute_group_id', '=', 'a.attribute_group_id')
                ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image', 'ag.is_fix', 'ag.refCategory_id')
                ->where('ag.refCategory_id', $request->category)
                ->where('ag.field_type', 1)
                ->where('ag.is_active', 1)
                ->where('ag.is_deleted', 0)
                ->orderBy('a.attribute_group_id')
                ->orderBy('ag.sort_order')
                ->get()
                ->toArray();

        $html = null;
        $temp_grp_id = 0;
        $temp_var = 0;
        $final_attribute_groups_with_att = array();

        $user = Auth::user();
        $file_arr = [];

        foreach ($data as $row_data) {
            if ($temp_grp_id != $row_data->attribute_group_id) {
                $temp_grp_id = $row_data->attribute_group_id;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['name'] = $row_data->ag_name;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['is_fix'] = $row_data->is_fix;

            } else {
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['attribute_id'] = $row_data->attribute_id;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['name'] = $row_data->name;
                $final_attribute_groups_with_att[$row_data->attribute_group_id]['attributes'][$temp_var]['image'] = $row_data->image;

                $temp_var++;
            }
            $file_arr[$row_data->attribute_group_id][] = $row_data->attribute_id;
        }
        file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id, json_encode($file_arr, JSON_PRETTY_PRINT));

        $list = null;
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if ($v['is_fix'] == 1 && $v['name'] != 'GRIDLE CONDITION') {
                if ($v['name'] == 'SHAPE') {
                    if (isset($v['attributes']) && count($v['attributes']) > 1) {
                        foreach ($v['attributes'] as $v1) {
                            $list .= '<li class="item"><a href="javascript:void(0);"><img src="' . $v1['image'] . '" class="img-fluid d-block" alt="diamond-shape" data-selected="0" data-attribute_id="' . $v1['attribute_id'] . '" data-name="' . $v1['name'] . '" data-group_id="' . $k . '"></a></li>';
                        }
                        $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                            <div class="diamond-shape filter-item align-items-center">
                                <label>Shape<span class=""><i class="fas fa-question-circle"></i></span></label>
                                <ul class="list-unstyled mb-0 diamond_shape">
                                    ' . $list . '
                                </ul>
                            </div>
                        </div>';
                    }
                } else {
                    if (isset($v['attributes']) && count($v['attributes']) > 1) {
                        $values = [];
                        $default_values = [];
                        $i = 0;
                        foreach ($v['attributes'] as $v1) {
                            $values[] = $v1['name'];
                            $default_values[$i]['attribute_id'] = $v1['attribute_id'];
                            $default_values[$i]['name'] = $v1['name'];
                            $i++;
                        }
                        $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                                <div class="diamond-cut filter-item">
                                    <label>' . $v['name'] . '<span class=""><i class="fas fa-question-circle"></i></span></label>
                                    <div class="range-sliders">
                                        <input type="text" id="Slider' . $k . '"/>
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
                                    getAttributeValues(vals, array, " . $k . ");
                                }
                        });
                        </script>";
                    }
                }
            }
        }

        $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                    <div class="diamond-cart filter-item">
                        <label>Carat<span class=""><i class="fas fa-question-circle"></i></span></label>
                        <div class="range-sliders">
                            <input type="text" id="caratSlider" />
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-lg-6 mb-2">
                    <div class="diamond-price filter-item">
                        <label>Price<span class=""><i class="fas fa-question-circle"></i></span></label>
                        <div class="range-sliders">
                            <input type="text" id="priceSlider" />
                        </div>
                    </div>
                </div>';
        $html .= "<script type='text/javascript'>
                    var priceSlider = new rSlider({
                        target: '#priceSlider',
                        values: {min: 0, max: 3000},
                        step: 10,
                        range: true,
                        tooltip: true,
                        scale: true,
                        labels: false,
                        set: ['0', '3000'],
                        onChange: function (vals) {
                            getAttributeValues(vals, [], 'price');
                        }
                    });
                    var caratSlider = new rSlider({
                        target: '#caratSlider',
                        values: {min: 0, max: 24},
                        step: 1,
                        range: true,
                        tooltip: true,
                        scale: true,
                        labels: false,
                        set: ['0', '24'],
                        onChange: function (vals) {
                            getAttributeValues(vals, [], 'carat');
                        }
                    });
                </script>";

        $none_fix = null;
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if ($v['is_fix'] === 0 && $v['name'] != 'GRIDLE CONDITION') {
                if (isset($v['attributes']) && count($v['attributes']) > 1) {
                    $values = [];
                    $default_values = [];
                    $i = 0;
                    foreach ($v['attributes'] as $v1) {
                        $values[] = $v1['name'];
                        $default_values[$i]['attribute_id'] = $v1['attribute_id'];
                        $default_values[$i]['name'] = $v1['name'];
                        $i++;
                    }
                    $none_fix .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                            <div class="diamond-cut filter-item">
                                <label>' . $v['name'] . '<span class=""><i class="fas fa-question-circle"></i></span></label>
                                <div class="range-sliders">
                                    <input type="text" id="Slider' . $k . '"/>
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
                                getAttributeValues(vals, array, " . $k . ");
                            }
                    });
                    </script>";
                }
            }
        }
        $user = Auth::user();
        if (file_exists(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id)) {
            $arr = file_get_contents(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id);
            $arr = json_decode($arr, true);
        }
        if (isset($response['attribute_values'])) {
            if (is_array($response['attribute_values'])) {
                $response = collect($response['attribute_values'])->pluck('attribute_id')->values()->all();
                $arr[$request->group_id] = $response;
            }
            file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id, json_encode($arr, JSON_PRETTY_PRINT));
        }
        $recently_viewed = DB::table('recently_view_diamonds')
                ->select('refCustomer_id', 'refDiamond_id', 'refAttribute_group_id', 'refAttribute_id', 'carat', 'price', 'shape', 'cut', 'color', 'clarity')
                ->orderBy('id', 'desc')
                ->get();
        $title = 'Search Diamonds';
        return view('front.search_diamonds', compact('title', 'html', 'none_fix', 'recently_viewed'));
    }

    public function addToCart(Request $request) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->addToCart($request);
        if (!empty($result->original['data'])) {
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

    public function searchDiamonds(Request $request)
    {
        $response = $request->all();
        $user = Auth::user();
        if (file_exists(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id)) {
            $arr = file_get_contents(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id);
            $arr = json_decode($arr, true);
        }
        if (isset($response['attribute_values'])) {
            if (is_array($response['attribute_values'])) {
                $response = collect($response['attribute_values'])->pluck('attribute_id')->values()->all();
                $arr[$request->group_id] = $response;
            } else {
                if ($response['group_id'] == 'price') {
                    $arr['price_min'] = explode(',', $response['attribute_values'])[0];
                    $arr['price_max'] = explode(',', $response['attribute_values'])[1];
                } else {
                    $arr['carat_min'] = explode(',', $response['attribute_values'])[0];
                    $arr['carat_max'] = explode(',', $response['attribute_values'])[1];
                }
            }
            file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $user->customer_id, json_encode($arr, JSON_PRETTY_PRINT));
        }
        $aa = new APIDiamond;
        $request->request->replace($arr);
        $request->request->add(['web' => 'web']);
        return $aa->searchDiamonds($request);
        // return response()->json(['success' => 2, 'session' => $arr]);
    }
    public function getCart()
    {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->getCart();
        if (!empty($result->original['data'])) {
            $response = $result->original['data'];
        }
        $title = 'Diamond Details';
        return view('front.cart', compact('title', 'response'));
    }

    public function diamondDetails($diamond_id) {
        $diamond_api_controller = new DiamondApi;
        $result = $diamond_api_controller->detailshDiamonds($diamond_id);
        if (!empty($result->original['data'])) {
            $response = $result->original['data']['data'];
            $attributes = $result->original['data']['attribute'];
        }
        $title = 'Diamond Details';
        return view('front.diamond-details', compact('title', 'response', 'attributes'));
    }

    public function clearDiamondsFromDB(Request $request) {
        DB::table($request->table)->truncate();
        // DB::table('diamonds')->truncate();
        // DB::table('diamonds_attributes')->truncate();
    }

}
