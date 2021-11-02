<?php

namespace App\Http\Controllers\Front;

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
    public function home(Request $request)
    {
        $category = DB::table('categories')->select('category_id')->where('category_id', $request->category)->first();
        if (!$category) {
            abort(404, 'NO SUCH CATEGORY FOUND');
        }
        $data = DB::table('attribute_groups as ag')
            ->Join('attributes as a', 'ag.attribute_group_id', '=', 'a.attribute_group_id')
            ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image', 'ag.is_fix', 'ag.refCategory_id')
            ->where('ag.refCategory_id', $request->category)
            ->where('ag.field_type', 1)
            ->where('ag.is_active', 1)
            ->where('ag.is_deleted', 0)
            ->orderBy('a.attribute_group_id')
            ->orderBy('ag.sort_order')
            ->get()
            ->toArray();
        dd($data);
        $attr_groups = collect($data)->pluck('attribute_group_id')->unique()->values()->all();

        $attr_groups_fix = collect($data)->where('is_fix', 1)->all();

        $attr_groups_none_fix = collect($data)->where('is_fix', 0)->all();

        $j = 0;
        $final_attr_fix = [];
        $final_attr_none_fix = [];
        $html = null;

        foreach ($attr_groups_fix as $v) {
            if (isset($attr_groups[$j])) {
                if ($attr_groups[$j] == $v->attribute_group_id) {
                    $final_attr_fix[$attr_groups[$j]]['name'] = $v->ag_name;
                    $final_attr_fix[$attr_groups[$j]]['is_fix'] = $v->is_fix;
                    $final_attr_fix[$attr_groups[$j]]['attributes'][] = [
                        'attribute_id' => $v->attribute_id,
                        'name' => $v->name,
                        'image' => $v->image
                    ];
                } else {
                    $j++;
                    $final_attr_fix[$attr_groups[$j]]['name'] = $v->ag_name;
                    $final_attr_fix[$attr_groups[$j]]['is_fix'] = $v->is_fix;
                    $final_attr_fix[$attr_groups[$j]]['attributes'][] = [
                        'attribute_id' => $v->attribute_id,
                        'name' => $v->name,
                        'image' => $v->image
                    ];
                }
            }
        }

        $list = null;
        foreach ($final_attr_fix as $k => $v) {
            if ($v['name'] == 'SHAPE') {
                foreach ($v['attributes'] as $v1)  {
                    $list .= '<li class="item"><a href="javascript:void(0);"><img src="'. $v1['image']. '" class="img-fluid d-block" alt="diamond-shape" data-selected="0" data-attribute_id="' . $v1['attribute_id'] . '" data-name="'. $v1['name'] . '" data-group_id="' . $k . '"></a></li>';
                }
                $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                    <div class="diamond-shape filter-item align-items-center">
                        <label>Shape<span class=""><i class="fas fa-question-circle"></i></span></label>
                        <ul class="list-unstyled mb-0 diamond_shape">
                            '.$list.'
                        </ul>
                    </div>
                </div>';
            } else {
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
                            <label>'.$v['name']. '<span class=""><i class="fas fa-question-circle"></i></span></label>
                            <div class="range-sliders">
                                <input type="text" id="Slider' . $k . '"/>
                            </div>
                        </div>
                    </div>';
                $html .= "<script type='text/javascript'>
                    var Slider" .$k. " = new rSlider({
                        target: '#Slider" . $k . "',
                        values: ['". implode("','", $values) ."'],
                        range: true,
                        tooltip: false,
                        scale: true,
                        labels: true,
                        set: ['".$values[0]."', '".$values[(count($values)-1)]. "'],
                        onChange: function (vals) {
                            var array = ".json_encode($default_values).";
                            getAttributeValues(vals, array, ".$k.");
                        }
                });
                </script>";
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


        $j = 0;
        foreach ($attr_groups_none_fix as $v) {
            if (isset($attr_groups[$j])) {
                if ($attr_groups[$j] == $v->attribute_group_id) {
                    $final_attr_none_fix[$attr_groups[$j]]['name'] = $v->ag_name;
                    $final_attr_none_fix[$attr_groups[$j]]['is_fix'] = $v->is_fix;
                    $final_attr_none_fix[$attr_groups[$j]]['attributes'][] = [
                        'attribute_id' => $v->attribute_id,
                        'name' => $v->name,
                        'image' => $v->image
                    ];
                } else {
                    $j++;
                    $final_attr_none_fix[$attr_groups[$j]]['name'] = $v->ag_name;
                    $final_attr_none_fix[$attr_groups[$j]]['is_fix'] = $v->is_fix;
                    $final_attr_none_fix[$attr_groups[$j]]['attributes'][] = [
                        'attribute_id' => $v->attribute_id,
                        'name' => $v->name,
                        'image' => $v->image
                    ];
                }
            }
        }

        $none_fix = null;
        foreach ($final_attr_none_fix as $k => $v) {
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
        $recently_viewed = DB::table('recently_view_diamonds')
            ->select('refCustomer_id', 'refDiamond_id', 'refAttribute_group_id', 'refAttribute_id', 'carat', 'price', 'shape', 'cut', 'color', 'clarity')
            ->orderBy('id', 'desc')
            ->get();
        $title = 'Search Diamonds';
        return view('front.search_diamonds', compact('title', 'html', 'none_fix', 'recently_viewed'));
    }

    public function clearDiamondsFromDB()
    {
        DB::table('attributes')->truncate();
        DB::table('diamonds')->truncate();
        DB::table('diamonds_attributes')->truncate();
    }
}
