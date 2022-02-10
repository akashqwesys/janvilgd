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

class DashboardController extends Controller
{
    use APIResponse;

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $sliders = DB::table('sliders')
            ->select('title', 'image', 'video_link')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();
        foreach ($sliders as $v) {
            $v->image = json_decode($v->image);
            $a = [];
            foreach ($v->image as $v1) {
                $a[] = '/storage/sliders/' . $v1;
            }
            $v->image = $a;
        }

        $latest = DB::table('diamonds as d')
            // ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            // ->join('attribute_groups as ag', 'da.refAttribute_id', '=', 'ag.attribute_group_id')
            ->select('diamond_id', 'name', 'expected_polish_cts as carat', 'rapaport_price as mrp', 'total as price', 'discount', 'image', 'barcode')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('diamond_id', 'desc')
            ->limit(5)
            ->get();
        foreach ($latest as $v) {
            $v->image = json_decode($v->image);
            /* $a = [];
            foreach ($v->image as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $v->image = $a; */
        }

        $recommended = DB::table('diamonds as d')
            // ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            // ->join('attribute_groups as ag', 'da.refAttribute_id', '=', 'ag.attribute_group_id')
            ->select('diamond_id', 'name', 'expected_polish_cts as carat', 'rapaport_price as mrp', 'total as price', 'discount', 'image', 'barcode')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->where('is_recommended', 1)
            ->orderBy('diamond_id', 'desc')
            ->limit(5)
            ->get();
        foreach ($recommended as $v) {
            $v->image = json_decode($v->image);
            /* $a = [];
            foreach ($v->image as $v1) {
                $a[] = '/storage/other_images/' . $v1;
            }
            $v->image = $a; */
        }

        $offer_sale = DB::table('settings')
            ->select('key', 'value', 'attachment')
            ->where('key', 'offer_sale')
            ->first();
        $offer_sale->attachment = url('/') . '/storage/user_files/' . $offer_sale->attachment;
        $data = [
            'sliders' => $sliders,
            'recommended' => $recommended,
            'offer_sale' => $offer_sale,
            'latest_collection' => $latest,
            'total_cart' => DB::table('customer_cart')->select('id')->where('refCustomer_id', $user->customer_id)->count()
        ];
        return $this->successResponse('Success', $data);
    }
}