<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller {

    public function dashboard(Request $request)
    {
        $title = 'Dashboard';
        $category = DB::table('categories')
            ->select('category_id', 'slug')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();
        $rough = $polish = $p4 = 0;
        foreach ($category as $v) {
            if ($v->slug == 'rough-diamonds') {
                $rough = $v->category_id;
            }
            else if ($v->slug == 'polish-diamonds') {
                $polish = $v->category_id;
            }
            else if ($v->slug == '4p-diamonds') {
                $p4 = $v->category_id;
            }
        }
        $diamond = DB::table('diamonds')
            ->select(
                DB::raw('count(case when "refCategory_id" = '. $rough .' then 1 end) as total_rough'),
                DB::raw('count(case when "refCategory_id" = '. $polish .' then 1 end) as total_polish'),
                DB::raw('count(case when "refCategory_id" = '. $p4 .' then 1 end) as total_4p')
            )
            ->first();

        $recently_viewed = DB::table('recently_view_diamonds as r')
            ->join('diamonds as d', 'r.refDiamond_id', '=', 'd.diamond_id')
            ->select('d.name', 'd.diamond_id', 'r.created_at', 'r.updated_at')
            ->orderBy('r.id', 'desc')
            ->limit(3)
            ->get();

        return view('front.dashboard', compact('title', 'diamond', 'recently_viewed'));
    }

    public function latest_diamonds(Request $request)
    {
        $title = 'Latest Diamonds';
        $diamonds = DB::table('diamonds as d')
            ->select('diamond_id', 'name', 'expected_polish_cts as carat', 'rapaport_price as mrp', 'total as price', 'discount', 'image')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('diamond_id', 'desc')
            ->limit(8)
            ->get();
        foreach ($diamonds as $v) {
            $v->image = json_decode($v->image);
        }

        return view('front.latest_diamond', compact('title', 'diamonds'));
    }

    public function recommended_diamonds(Request $request)
    {
        $title = 'Recommended Diamonds';
        $diamonds = DB::table('diamonds as d')
            ->select('diamond_id', 'name', 'expected_polish_cts as carat', 'rapaport_price as mrp', 'total as price', 'discount', 'image')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->where('is_recommended', 1)
            ->orderBy('diamond_id', 'desc')
            ->limit(8)
            ->get();
        foreach ($diamonds as $v) {
            $v->image = json_decode($v->image);
        }
        return view('front.latest_diamond', compact('title', 'diamonds'));
    }
}