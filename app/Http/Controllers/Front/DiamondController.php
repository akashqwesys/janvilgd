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
use App\Exports\DiamondExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class DiamondController extends Controller {

    public function home(Request $request) {
        $category = DB::table('categories')->select('category_id', 'name', 'slug')->where('slug', $request->category)->first();
        if (!$category) {
            abort(404, 'NO SUCH CATEGORY FOUND');
        }
        $data = DB::table('attribute_groups as ag')
                ->join('attributes as a', 'ag.attribute_group_id', '=', 'a.attribute_group_id')
                ->select('a.attribute_id', 'a.attribute_group_id', 'a.name', 'ag.name as ag_name', 'a.image', 'ag.is_fix', 'ag.refCategory_id', 'a.sort_order')
                ->where('ag.refCategory_id', $category->category_id)
                ->where('ag.field_type', 1)
                ->where('ag.is_active', 1)
                ->where('ag.is_deleted', 0)
                ->orderBy('ag.sort_order')
                ->orderBy('a.attribute_group_id')
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
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if ($v['is_fix'] == 1 && $v['name'] != 'GRIDLE CONDITION') {
                if ($v['name'] == 'SHAPE') {
                    if (isset($v['attributes'])) {
                        foreach ($v['attributes'] as $v1) {
                            if (count($v['attributes']) > 1) {
                                if (in_array($v1['name'], ['Round Brilliant', 'ROUND', 'RO', 'BR'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Round_Brilliant.png';
                                } else if (in_array($v1['name'], ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Heart_Brilliant.png';
                                } else if (in_array($v1['name'], ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Pear_Brilliant.png';
                                } else if (in_array($v1['name'], ['Oval Brilliant', 'OV', 'Oval'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Oval_Brilliant.png';
                                } else if (in_array($v1['name'], ['Princess Cut', 'PR', 'Princess'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Princess_Cut.png';
                                } else if (in_array($v1['name'], ['Cushion', 'CU'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Cushion.png';
                                } else if (in_array($v1['name'], ['Emerald', 'EM'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Emerald.png';
                                } else if (in_array($v1['name'], ['Marquise', 'MQ'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Marquise.png';
                                }
                                $list .= '<li class="item"><a href="javascript:void(0);"><img src="'.$src_img.'" class="img-fluid d-block" alt="' . $v1['name'] . '" data-bs-toggle="tooltip" title="' . $v1['name'] . '" data-selected="0" data-attribute_id="' . $v1['attribute_id'] . '" data-name="' . $v1['name'] . '" data-group_id="' . $k . '"></a></li>';
                            }
                            $file_arr[$k][] = $v1['attribute_id'];
                        }
                        if (count($v['attributes']) > 1) {
                            $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                                <div class="diamond-shape filter-item align-items-center">
                                    <label>Shape<span class=""><i class="fas fa-question-circle"></i></span></label>
                                    <ul class="list-unstyled mb-0 diamond_shape">
                                        ' . $list . '
                                    </ul>
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
                            $file_arr[$k][] = $v1['attribute_id'];
                        }
                        if (count($v['attributes']) > 1) {
                            $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2">
                                    <div class="diamond-cut filter-item">
                                        <label>' . ucfirst(strtolower($v['name'])) . '<span class=""><i class="fas fa-question-circle"></i></span></label>
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
        }
        $max = DB::table('diamonds')
            ->selectRaw('max("total") as "max_price", min("total") as "min_price", max("expected_polish_cts") as "max_carat", min("expected_polish_cts") as "min_carat"')
            ->where('refCategory_id', $category->category_id)
            ->first();
        if ($max) {
            $min_price = (round($max->min_price - 1) < 0) ? 0 : round($max->min_price - 1);
            $max_price = round($max->max_price + 1);
            $min_carat = (round($max->min_carat - 1) < 0) ? 0 : round($max->min_carat - 1);
            $max_carat = round($max->max_carat + 1);
        } else {
            $max_price = $min_carat = $max_carat = $min_price = 0;
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
                        values: {min: ".$min_price.", max: ".$max_price."},
                        step: 20,
                        range: true,
                        tooltip: true,
                        scale: true,
                        labels: false,
                        set: ['".$min_price."', '".$max_price."'],
                        onChange: function (vals) {
                            getAttributeValues(vals, [], 'price');
                        }
                    });
                    var caratSlider = new rSlider({
                        target: '#caratSlider',
                        values: {min: ".$min_carat.", max: ".$max_carat."},
                        step: 0.01,
                        range: true,
                        tooltip: true,
                        scale: true,
                        labels: false,
                        set: ['".$min_carat."', '".$max_carat. "'],
                        onChange: function (vals) {
                            // roundLabel($(this));
                            getAttributeValues(vals, [], 'carat');
                        }
                    });
                </script>";

        $none_fix = null;
        foreach ($final_attribute_groups_with_att as $k => $v) {
            if ($v['is_fix'] === 0 && $v['name'] != 'GRIDLE CONDITION') {
                if ($v['name'] == 'SHAPE') {
                    if (isset($v['attributes'])) {
                        foreach ($v['attributes'] as $v1) {
                            if (count($v['attributes']) > 1) {
                                if (in_array($v1['name'], ['Round Brilliant', 'ROUND', 'RO', 'BR'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Round_Brilliant.png';
                                } else if (in_array($v1['name'], ['Heart Brilliant', 'HS', 'Heart', 'HEART'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Heart_Brilliant.png';
                                } else if (in_array($v1['name'], ['Pear Brilliant', 'PS', 'Pear', 'PEAR'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Pear_Brilliant.png';
                                } else if (in_array($v1['name'], ['Oval Brilliant', 'OV', 'Oval'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Oval_Brilliant.png';
                                } else if (in_array($v1['name'], ['Princess Cut', 'PR', 'Princess'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Princess_Cut.png';
                                } else if (in_array($v1['name'], ['Cushion', 'CU'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Cushion.png';
                                } else if (in_array($v1['name'], ['Emerald', 'EM'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Emerald.png';
                                } else if (in_array($v1['name'], ['Marquise', 'MQ'])) {
                                    $src_img = '/assets/images/Diamond_Shapes_Marquise.png';
                                }
                                $list .= '<li class="item"><a href="javascript:void(0);"><img src="' . $src_img . '" class="img-fluid d-block" alt="' . $v1['name'] . '" data-selected="0" data-attribute_id="' . $v1['attribute_id'] . '" data-name="' . $v1['name'] . '" data-group_id="' . $k . '"></a></li>';
                            }
                            $file_arr[$k][] = $v1['attribute_id'];
                        }
                        if (count($v['attributes']) > 1) {
                            $html .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2 filter-toggle">
                                <div class="diamond-shape filter-item align-items-center">
                                    <label>Shape<span class=""><i class="fas fa-question-circle"></i></span></label>
                                    <ul class="list-unstyled mb-0 diamond_shape">
                                        ' . $list . '
                                    </ul>
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
                            $file_arr[$k][] = $v1['attribute_id'];
                        }
                        if (count($v['attributes']) > 1) {
                            $none_fix .= '<div class="col col-12 col-sm-12 col-lg-6 mb-2 filter-toggle">
                                    <div class="diamond-cut filter-item">
                                        <label>' . ucfirst(strtolower($v['name'])) . '<span class=""><i class="fas fa-question-circle"></i></span></label>
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
            }
        }
        $file_name = $user->customer_id . '-' . $category->category_id;
        file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name, json_encode($file_arr, JSON_PRETTY_PRINT));
        $recently_viewed = DB::table('recently_view_diamonds as rvd')
            ->join('diamonds as d', 'rvd.refDiamond_id', '=', 'd.diamond_id')
            ->select('rvd.refCustomer_id', 'rvd.refDiamond_id', 'rvd.refAttribute_group_id', 'rvd.refAttribute_id', 'rvd.carat', 'rvd.price', 'rvd.shape', 'rvd.cut', 'rvd.color', 'rvd.clarity', 'd.name', 'd.image', 'd.barcode')
            ->where('d.refCategory_id', $category->category_id)
            ->where('rvd.refCustomer_id', $user->customer_id)
            ->orderBy('rvd.updated_at', 'desc')
            ->get();
        $title = 'Search Diamonds';
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

    public function exportForAdmin($category_id)
    {
        return Excel::download(new DiamondExport($data), 'users.xlsx');
    }

    public function searchDiamonds(Request $request)
    {
        $response = $request->all();

        $user = Auth::user();
        $file_name = $user->customer_id . '-' . $request->category;
        if (file_exists(base_path() . '/storage/framework/diamond-filters/' . $file_name)) {
            $arr = file_get_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name);
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
            file_put_contents(base_path() . '/storage/framework/diamond-filters/' . $file_name, json_encode($arr, JSON_PRETTY_PRINT));
        }
        $arr['category'] = $request->category;
        $arr['category_slug'] = $request->category_slug;
        $arr['gateway'] = 'web';
        $aa = new APIDiamond;
        $request->request->replace($arr);

        if (isset($response['export'])) {

            if($response['export']=='export-admin'){
                $category_name = DB::table('categories')
                    ->select('name')
                    ->where('category_id', $request->category)
                    ->pluck('name')
                    ->first();
                $final_d = $aa->searchDiamonds($request);
                $diamonds = $final_d->original['data'];
                $data = array(
                    array('data1', 'data2','data3'),
                    array('data3', 'data4','data3')
                );
                
                Excel::store(new InvoicesExport(2018), 'invoices.xlsx');

                Excel::create(time().'xlsx', function($excel) use($data) {                
                    $excel->sheet('Sheetname', function($sheet) use($data) {                
                        $sheet->fromArray($data);                
                    });                
                })->store('xls',storage_path('excel/exports'));
                $excel = storage_path('excel/exports/' . time().'xlsx');
                return response()->download($excel);
            }


            if($response['export']=='export'){
                $category_name = DB::table('categories')
                    ->select('name')
                    ->where('category_id', $request->category)
                    ->pluck('name')
                    ->first();
                $final_d = $aa->searchDiamonds($request);
                $diamonds = $final_d->original['data'];
                $pdf = PDF::loadView('front.export-pdf', compact('diamonds', 'category_name'));
                $path = public_path('pdf/');
                $fileName =  time() . '.' . 'pdf';
                $pdf->save($path . '/' . $fileName);
                $pdf = public_path('pdf/' . $fileName);
                return response()->download($pdf);
            }
        } else {
            $request->request->add(['web' => 'web']);
        }
        return $aa->searchDiamonds($request);
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
