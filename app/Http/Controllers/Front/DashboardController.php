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

        return view('front.dashboard', compact('title', 'diamond'));
    }
}