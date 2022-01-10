<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class DashboardController extends Controller {

    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $last_day = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 day'));
        $last_7 = date('Y-m-d', strtotime(date('Y-m-d') . ' - 7 days'));
        $last_30 = date('Y-m-d', strtotime(date('Y-m-d') . ' - 30 days'));
        /* $start = new DateTime();
        $start->setTime(0, 0, 0);
        $end = new DateTime();
        $end->setTime(23, 59, 59);
        $year = date('Y');
        $start->setDate($year, 4, 1);
        if ($start <= 12) {
            $end->setDate($year + 1, 3, 31);
        } else {
            $start->setDate($year - 1, 4, 1);
            $end->setDate($year, 3, 31);
        } */
        if (date('m') <= 3) {
            $start_year = date('Y-m-d', strtotime((date('Y')-1) . '-04-01'));
            $end_year = date('Y-m-d', strtotime(date('Y') . '-03-31'));
        } else {
            $start_year = date('Y-m-d', strtotime(date('Y') . '-04-01'));
            $end_year = date('Y-m-d', strtotime((date('Y')+1) . '-03-31'));
        }

        $orders = DB::table('orders')
        ->select(
            // DB::raw("count(case when DATE(date_added) = (CURRENT_DATE - INTERVAL '1 day') then 1 end) as last_day"),
            DB::raw("count(case when DATE(date_added) = CURRENT_DATE then 1 end) as today"),
            DB::raw("count(case when (DATE(date_added) <= '" . $last_day . "' and DATE(date_added) >= '" . $last_7 . "') then 1 end) as last_7"),
            DB::raw("count(case when (DATE(date_added) <= '" . $last_day . "' and DATE(date_added) >= '" . $last_30 . "') then 1 end) as last_30"),
            DB::raw("sum(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM CURRENT_DATE) then total_paid_amount else 0 end) as monthly_revenue"),
            DB::raw("sum(
                case
                    when EXTRACT(Year FROM date_added) = EXTRACT(Year FROM CURRENT_DATE) and EXTRACT(QUARTER FROM date_added) = 1 and (EXTRACT(MONTH FROM date_added) = 1 or EXTRACT(MONTH FROM date_added) = 2 or EXTRACT(MONTH FROM date_added) = 3) then total_paid_amount
                    when EXTRACT(Year FROM date_added) = EXTRACT(Year FROM CURRENT_DATE) and EXTRACT(QUARTER FROM date_added) = 2 and (EXTRACT(MONTH FROM date_added) = 4 or EXTRACT(MONTH FROM date_added) = 5 or EXTRACT(MONTH FROM date_added) = 6) then total_paid_amount
                    when EXTRACT(Year FROM date_added) = EXTRACT(Year FROM CURRENT_DATE) and EXTRACT(QUARTER FROM date_added) = 3 and (EXTRACT(MONTH FROM date_added) = 7 or EXTRACT(MONTH FROM date_added) = 8 or EXTRACT(MONTH FROM date_added) = 9) then total_paid_amount
                    when EXTRACT(Year FROM date_added) = EXTRACT(Year FROM CURRENT_DATE) and EXTRACT(QUARTER FROM date_added) = 4 and (EXTRACT(MONTH FROM date_added) = 10 or EXTRACT(MONTH FROM date_added) = 11 or EXTRACT(MONTH FROM date_added) = 12) then total_paid_amount
                    else 0 end
                ) as quaterly_revenue"),
            DB::raw("sum(
                case
                    when DATE(date_added) >= '" . $start_year . "' and DATE(date_added) <= '" . $end_year . "' then total_paid_amount else 0 end
                ) as yearly_revenue"),
            // DB::raw('count(case when exists (select order_update_id from order_updates where order_status_name = \'PENDING\' and "refOrder_id" = orders.order_id) then 1 end) as pending_orders'),
            // DB::raw('count(case when exists (select order_update_id from order_updates where order_status_name = \'COMPLETED\' and "refOrder_id" = orders.order_id) then 1 end) as completed_orders'),
            // DB::raw("count(case when order_type = 0 then 1 end) as offline_orders"),
        )
        ->first();

        $pending_orders = DB::table('orders as o')
            // ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('order_updates as ou')
                    ->whereColumn('ou.refOrder_id', 'o.order_id')
                    ->where('ou.order_status_name', 'COMPLETED');
            })
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get();

        $completed_orders = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('ou.order_status_name', 'COMPLETED')
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get();

        $offline_orders = DB::table('orders as o')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('o.order_type', 0)
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get();

        $recent_customers = DB::table('customer as c')
            ->join('orders as o', 'o.refCustomer_id', '=', 'c.customer_id')
            ->select('c.name', 'c.customer_id', 'c.email', 'o.order_id')
            ->where('o.order_type', 1)
            ->orderBy('o.order_id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
        $recent_customers = collect($recent_customers)->groupBy('customer_id')->values()->toArray();
        /* for ($i = 0; $i < count($recent_customers); $i++) {
            if (isset($recent_customers[$i + 1]) && $recent_customers[$i]->customer_id == $recent_customers[$i + 1]->customer_id) {
                unset($recent_customers[$i]);
            }
        } */

        $top_customers = DB::table('orders')
            ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
            ->groupByRaw('"refCustomer_id", email_id, name')
            ->orderBy('repeative', 'desc')
            ->limit(5)
            ->get();

        $bottom_customers = DB::table('orders')
            ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
            ->groupByRaw('"refCustomer_id", email_id, name')
            ->orderBy('repeative', 'asc')
            ->limit(5)
            ->get();

        $chart_orders = DB::table('orders')
        ->select(
            // DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM CURRENT_DATE) then 1 end) as cur_month"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '1 month')) then 1 end) as cur_month1"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '2 month')) then 1 end) as cur_month2"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '3 month')) then 1 end) as cur_month3"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '4 month')) then 1 end) as cur_month4"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '5 month')) then 1 end) as cur_month5"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '6 month')) then 1 end) as cur_month6")
        )
        ->first();

        $chart_carats = DB::table('order_diamonds')
        ->select(
            // DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) then expected_polish_cts else 0 end) as cur_month"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) then expected_polish_cts else 0 end) as cur_month1"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) then expected_polish_cts else 0 end) as cur_month2"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) then expected_polish_cts else 0 end) as cur_month3"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) then expected_polish_cts else 0 end) as cur_month4"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) then expected_polish_cts else 0 end) as cur_month5"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) then expected_polish_cts else 0 end) as cur_month6")
        )
        ->first();

        $cancel_orders = DB::table('orders as o')
        ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
        ->select(
            // DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM CURRENT_DATE) then 1 end) as cur_month"),
            DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) then 1 end) as cur_month1"),
            DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) then 1 end) as cur_month2"),
            DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) then 1 end) as cur_month3"),
            DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) then 1 end) as cur_month4"),
            DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) then 1 end) as cur_month5"),
            DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) then 1 end) as cur_month6")
        )
        ->where('order_status_name', 'CANCELLED')
        ->first();

        $import = DB::table('diamonds as d')
        ->join('categories as c', 'd.refCategory_id', '=', 'c.category_id')
        ->select(
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month1_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month2_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month3_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month1_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month2_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month3_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month1_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month2_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month3_rg")
        )
        ->first();

        $export = DB::table('orders as o')
        ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
        ->join('order_diamonds as od', 'o.order_id', '=', 'od.refOrder_id')
        ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
        ->select(
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month1_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month2_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month3_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month1_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month2_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month3_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month1_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month2_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month3_rg"),
        )
        ->where('order_status_name', 'COMPLETED')
        ->first();

        $weight_loss = DB::table('diamonds as d')
            ->join('categories as c', 'd.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("sum(case when d.weight_loss IS NOT NULL then CAST(d.weight_loss AS DECIMAL) else 0 end) as av_weight_loss"),
                DB::raw("count(case when d.weight_loss IS NOT NULL then 1 end) as cn_weight_loss")
                )
            ->where('c.slug', '4p-diamonds')
            ->first();

        $customer_activity = DB::table('customer_activities')
            ->select('id', 'activity', 'subject', 'created_at', 'device')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $employee_activity = DB::table('user_activity as ua')
            ->join('users as u', 'ua.refUser_id', '=', 'u.id')
            ->select('ua.user_activity_id', 'ua.activity', 'ua.subject', 'ua.date_added', 'u.name', 'ua.device')
            ->orderBy('ua.user_activity_id', 'desc')
            ->limit(5)
            ->get();

        $trending_rough = DB::table('most_ordered_diamonds')
            ->select('shape', 'carat', 'color', 'clarity', 'id')
            ->where('refCategory_id', 1)
            ->orderByRaw('shape_cnt desc, carat_cnt desc, color_cnt desc, clarity_cnt desc')
            ->limit(5)
            ->get();
        $trending_4p = DB::table('most_ordered_diamonds')
            ->select('shape', 'carat', 'color', 'clarity', 'cut', 'id')
            ->where('refCategory_id', 2)
            ->orderByRaw('shape_cnt desc, carat_cnt desc, color_cnt desc, clarity_cnt desc, cut_cnt desc')
            ->limit(5)
            ->get();
        $trending_polish = DB::table('most_ordered_diamonds')
            ->select('shape', 'carat', 'color', 'clarity', 'cut', 'id')
            ->where('refCategory_id', 3)
            ->orderByRaw('shape_cnt desc, carat_cnt desc, color_cnt desc, clarity_cnt desc, cut_cnt desc')
            ->limit(5)
            ->get();

        $vs_views = DB::table('most_viewed_diamonds')
            ->select('refCategory_id', 'views_cnt')
            ->orderBy('refCategory_id', 'asc')
            ->get();

        $vs_orders = DB::table('order_diamonds')
        ->select(
            DB::raw("count(case when \"refCategory_id\" = 1 then 1 end) as total_rough"),
            DB::raw("count(case when \"refCategory_id\" = 2 then 1 end) as total_4p"),
            DB::raw("count(case when \"refCategory_id\" = 3 then 1 end) as total_polish")
        )
        ->first();

        return view('admin.dashboard', compact('orders', 'data', 'pending_orders', 'completed_orders', 'offline_orders', 'recent_customers', 'top_customers', 'bottom_customers', 'chart_orders', 'chart_carats', 'cancel_orders', 'import', 'export', 'weight_loss', 'customer_activity', 'employee_activity', 'trending_rough', 'trending_4p', 'trending_polish', 'vs_views', 'vs_orders', 'start_year', 'end_year'));
    }

}