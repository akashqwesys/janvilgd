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
        $sliders = DB::table('sliders')
            ->select('title', 'image', 'video_link')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $latest = DB::table('diamonds as d')
            // ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            // ->join('attribute_groups as ag', 'da.refAttribute_id', '=', 'ag.attribute_group_id')
            ->select('diamond_id', 'expected_polish_cts', 'total', 'discount', 'image')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('diamond_id', 'desc')
            ->limit(5)
            ->get();

        $recommended = DB::table('diamonds as d')
            // ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            // ->join('attribute_groups as ag', 'da.refAttribute_id', '=', 'ag.attribute_group_id')
            ->select('diamond_id', 'expected_polish_cts', 'total', 'discount', 'image')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            // ->where('is_recommended', 1)
            ->orderBy('diamond_id', 'desc')
            ->limit(5)
            ->get();

        $offer_sale = DB::table('settings')
            ->where('key', 'offer_sale')
            ->get();

        $data = [
            'sliders' => $sliders,
            'recommended' => $recommended,
            'offer_sale' => $offer_sale,
            'latest_collection' => $latest,
        ];
        return $this->successResponse('Congrats, you are now successfully registered', $data);
    }
}