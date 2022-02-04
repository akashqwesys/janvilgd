<?php

namespace App\Http\Controllers;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class DashboardController extends Controller {

    public function dashboard(Request $request)
    {
        $data['title'] = 'Dashboard';
        $last_day = date('Y-m-d', strtotime(date('Y-m-d')));
        $last_7 = date('Y-m-d', strtotime(date('Y-m-d') . ' - 6 days'));
        $last_30 = date('Y-m-d', strtotime(date('Y-m-d') . ' - 29 days'));
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
            DB::raw("count(case when (DATE(date_added) <= '" . $last_day . "' and DATE(date_added) >= '" . $last_30 . "') then 1 end) as last_30")
        )
        ->where('order_status', '<>','CANCELLED')
        ->first();

        $revenues = DB::table('orders')
        ->select(
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
                ) as yearly_revenue")
        )
        ->whereIn('order_status', ['PAID', 'UNPAID'])
        ->first();

        $pending_orders = DB::table('orders as o')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('order_status', 'PENDING')
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get();

        $paid_orders = DB::table('orders as o')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('order_status', 'PAID')
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get();

        $unpaid_orders = DB::table('orders as o')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('order_status', 'UNPAID')
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get();

        /* $offline_orders = DB::table('orders as o')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('o.order_type', 0)
            ->orderBy('o.order_id', 'desc')
            // ->limit(5)
            ->get(); */

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
            ->whereIn('order_status', ['PAID', 'UNPAID'])
            ->groupByRaw('"refCustomer_id", email_id, name')
            ->orderBy('repeative', 'desc')
            ->limit(5)
            ->get();

        $bottom_customers = DB::table('orders')
            ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
            ->whereIn('order_status', ['PAID', 'UNPAID'])
            ->groupByRaw('"refCustomer_id", email_id, name')
            ->orderBy('repeative', 'asc')
            ->limit(5)
            ->get();

        $chart_orders = DB::table('orders')
        ->select(
            // DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM CURRENT_DATE) then 1 end) as cur_month"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM CURRENT_DATE) then 1 end) as cur_month"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '1 month')) then 1 end) as cur_month1"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '2 month')) then 1 end) as cur_month2"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '3 month')) then 1 end) as cur_month3"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '4 month')) then 1 end) as cur_month4"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '5 month')) then 1 end) as cur_month5")
            // DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '6 month')) then 1 end) as cur_month6")
        )
        ->where('order_status', '<>', 'CANCELLED')
        ->first();

        $chart_carats = DB::table('order_diamonds')
        ->select(
            // DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) then expected_polish_cts else 0 end) as cur_month"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE) then expected_polish_cts else 0 end) as cur_month"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) then expected_polish_cts else 0 end) as cur_month1"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) then expected_polish_cts else 0 end) as cur_month2"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) then expected_polish_cts else 0 end) as cur_month3"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) then expected_polish_cts else 0 end) as cur_month4"),
            DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) then expected_polish_cts else 0 end) as cur_month5")
            // DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) then expected_polish_cts else 0 end) as cur_month6")
        )
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders as o')
                ->whereColumn('o.order_id', 'order_diamonds.refOrder_id')
                ->where('o.order_status', 'CANCELLED');
        })
        ->first();

        $cancel_orders = DB::table('orders as o')
        ->select(
            // DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM CURRENT_DATE) then 1 end) as cur_month"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM CURRENT_DATE) then 1 end) as cur_month"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) then 1 end) as cur_month1"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) then 1 end) as cur_month2"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) then 1 end) as cur_month3"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) then 1 end) as cur_month4"),
            DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) then 1 end) as cur_month5")
            // DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) then 1 end) as cur_month6")
        )
        ->where('order_status', 'CANCELLED')
        ->first();

        $import = DB::table('diamonds as d')
        ->join('categories as c', 'd.refCategory_id', '=', 'c.category_id')
        ->select(
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM CURRENT_DATE) and c.slug = 'polish-diamonds') then 1 end) as cur_month_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month1_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month2_pl"),
            // DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month3_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM CURRENT_DATE) and c.slug = '4p-diamonds') then 1 end) as cur_month_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month1_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month2_4p"),
            // DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month3_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM CURRENT_DATE) and c.slug = 'rough-diamonds') then 1 end) as cur_month_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month1_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month2_rg"),
            // DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month3_rg")
        )
        ->first();

        $export = DB::table('order_diamonds as od')
        ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
        ->select(
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM CURRENT_DATE) and c.slug = 'polish-diamonds') then 1 end) as cur_month_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month1_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month2_pl"),
            // DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month3_pl"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM CURRENT_DATE) and c.slug = '4p-diamonds') then 1 end) as cur_month_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month1_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month2_4p"),
            // DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month3_4p"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM CURRENT_DATE) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM CURRENT_DATE) and c.slug = 'rough-diamonds') then 1 end) as cur_month_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month1_rg"),
            DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month2_rg"),
            // DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month3_rg"),
        )
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders as o')
                ->whereColumn('o.order_id', 'od.refOrder_id')
                ->whereNotIn('o.order_status', ['PENDING', 'CANCELLED']);
        })
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
            ->select('shape', 'carat', 'color', 'clarity')
            ->where('refCategory_id', 1)
            ->groupByRaw('"shape", "carat", "color", "clarity"')
            ->orderByRaw('MAX("shape_cnt") DESC, MAX("carat_cnt") DESC, MAX("color_cnt") DESC, MAX("clarity_cnt") DESC')
            ->limit(1)
            ->first();
        $trending_4p = DB::table('most_ordered_diamonds')
            ->select('shape', 'carat', 'color', 'clarity', 'cut')
            ->where('refCategory_id', 2)
            ->groupByRaw('"shape", "carat", "color", "clarity", "cut"')
            ->orderByRaw('MAX("shape_cnt") DESC, MAX("carat_cnt") DESC, MAX("color_cnt") DESC, MAX("clarity_cnt") DESC, MAX("cut_cnt") DESC')
            ->limit(1)
            ->first();
        $trending_polish = DB::table('most_ordered_diamonds')
            ->select('shape', 'carat', 'color', 'clarity', 'cut')
            ->where('refCategory_id', 3)
            ->groupByRaw('"shape", "carat", "color", "clarity", "cut"')
            ->orderByRaw('MAX("shape_cnt") DESC, MAX("carat_cnt") DESC, MAX("color_cnt") DESC, MAX("clarity_cnt") DESC, MAX("cut_cnt") DESC')
            ->limit(1)
            ->first();

        $vs_views = DB::table('most_viewed_diamonds')
            ->select('refCategory_id', 'views_cnt')
            ->orderBy('refCategory_id', 'asc')
            ->get();

        $vs_orders = DB::table('order_diamonds as od')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders as o')
                ->whereColumn('o.order_id', 'od.refOrder_id')
                ->whereNotIn('o.order_status', ['PENDING', 'CANCELLED']);
        })
        ->select(
            DB::raw("count(case when \"refCategory_id\" = 1 then 1 end) as total_rough"),
            DB::raw("count(case when \"refCategory_id\" = 2 then 1 end) as total_4p"),
            DB::raw("count(case when \"refCategory_id\" = 3 then 1 end) as total_polish")
        )
        ->first();

        return view('admin.dashboard.dashboard', compact('request', 'orders', 'revenues', 'data', 'pending_orders', 'paid_orders', 'unpaid_orders', 'recent_customers', 'top_customers', 'bottom_customers', 'chart_orders', 'chart_carats', 'cancel_orders', 'import', 'export', 'weight_loss', 'customer_activity', 'employee_activity', 'trending_rough', 'trending_4p', 'trending_polish', 'vs_views', 'vs_orders', 'start_year', 'end_year'));
    }

    public function inventory(Request $request)
    {
        $data['title'] = 'Inventory Dashboard';

        $total_stock = DB::table('diamonds')
        ->select(
            DB::raw("count(case when \"refCategory_id\" = 1 then 1 end) as total_rough"),
            DB::raw("count(case when \"refCategory_id\" = 2 then 1 end) as total_4p"),
            DB::raw("count(case when \"refCategory_id\" = 3 then 1 end) as total_polish")
        )
        ->where('available_pcs', 1)
        ->first();

        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $elastic_polish = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['refCategory_id' => 3]],
                            ['term' => ['attributes.SHAPE' => 'Round']]
                        ]
                    ]
                ]
            ]
        ];
        $round_polish = $client->count($elastic_polish);

        $elastic_4p = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['refCategory_id' => 2]],
                            ['term' => ['attributes.SHAPE' => 'Round']]
                        ]
                    ]
                ]
            ]
        ];
        $round_4p = $client->count($elastic_4p);

        $elastic_rough = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['refCategory_id' => 1]],
                            ['term' => ['attributes.SHAPE' => 'Round']]
                        ]
                    ]
                ]
            ]
        ];
        $round_rough = $client->count($elastic_rough);

        return view('admin.dashboard.inventory', compact('data', 'request', 'total_stock', 'round_polish', 'round_4p', 'round_rough'));
    }

    public function sales(Request $request)
    {
        $data['title'] = 'Sales Dashboard';

        $total_paid = DB::table('orders as o')
        ->join('customer as c', 'o.refCustomer_id', '=', 'c.customer_id')
        // ->leftJoin('customer_type as ct', 'c.refCustomerType_id', '=', 'ct.customer_type_id')
        ->select(
            DB::raw("sum(sub_total) as sub_total"),
            DB::raw("sum(total_paid_amount) as total_amount"),
            DB::raw("sum(delivery_charge_amount) as shipping_charge"),
            DB::raw("sum(discount_amount) as total_discount"),
            DB::raw("sum(tax_amount * (sub_total - discount_amount - o.additional_discount) / 100) as total_tax"),
            DB::raw("sum( o.additional_discount * sub_total / 100) as total_add_discount")
        )
        ->where('o.order_status', 'PAID')
        ->first();

        $total_unpaid = DB::table('orders as o')
        ->join('customer as c', 'o.refCustomer_id', '=', 'c.customer_id')
        // ->leftJoin('customer_type as ct', 'c.refCustomerType_id', '=', 'ct.customer_type_id')
        ->select(
            DB::raw("sum(sub_total) as sub_total"),
            DB::raw("sum(total_paid_amount) as total_amount"),
            DB::raw("sum(delivery_charge_amount) as shipping_charge"),
            DB::raw("sum(discount_amount) as total_discount"),
            DB::raw("sum(tax_amount * (sub_total - discount_amount - o.additional_discount) / 100) as total_tax"),
            DB::raw("sum( o.additional_discount * sub_total / 100) as total_add_discount")
        )
        ->where('o.order_status', 'UNPAID')
        ->first();

        $analysis = DB::table('diamonds as d')
        ->join('diamonds_attributes as da', 'd.diamond_id', '=', 'da.refDiamond_id')
        ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
        ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
        ->select(
            // SHAPE ANALYSIS
            DB::raw("count(case when a.attribute_id in (1,13,25) then 1 end) as total_round"),
            DB::raw("sum(case when a.attribute_id in (1,13,25) then d.total else 0 end) as total_round_amount"),
            DB::raw("count(case when a.attribute_id in (2,14,26) then 1 end) as total_oval"),
            DB::raw("sum(case when a.attribute_id in (2,14,26) then d.total else 0 end) as total_oval_amount"),
            DB::raw("count(case when a.attribute_id in (3,15,27) then 1 end) as total_heart"),
            DB::raw("sum(case when a.attribute_id in (3,15,27) then d.total else 0 end) as total_heart_amount"),
            DB::raw("count(case when a.attribute_id in (4,16,28) then 1 end) as total_pear"),
            DB::raw("sum(case when a.attribute_id in (4,16,28) then d.total else 0 end) as total_pear_amount"),
            DB::raw("count(case when a.attribute_id in (5,17,29) then 1 end) as total_princess"),
            DB::raw("sum(case when a.attribute_id in (5,17,29) then d.total else 0 end) as total_princess_amount"),
            DB::raw("count(case when a.attribute_id in (6,18,30) then 1 end) as total_radiant"),
            DB::raw("sum(case when a.attribute_id in (6,18,30) then d.total else 0 end) as total_radiant_amount"),
            DB::raw("count(case when a.attribute_id in (7,19,31) then 1 end) as total_asscher"),
            DB::raw("sum(case when a.attribute_id in (7,19,31) then d.total else 0 end) as total_asscher_amount"),
            DB::raw("count(case when a.attribute_id in (8,20,32) then 1 end) as total_emerald"),
            DB::raw("sum(case when a.attribute_id in (8,20,32) then d.total else 0 end) as total_emerald_amount"),
            DB::raw("count(case when a.attribute_id in (9,21,33) then 1 end) as total_cushion"),
            DB::raw("sum(case when a.attribute_id in (9,21,33) then d.total else 0 end) as total_cushion_amount"),
            DB::raw("count(case when a.attribute_id in (10,22,34) then 1 end) as total_marquise"),
            DB::raw("sum(case when a.attribute_id in (10,22,34) then d.total else 0 end) as total_marquise_amount"),
            DB::raw("count(case when a.attribute_id in (11,23,35) then 1 end) as total_baguette"),
            DB::raw("sum(case when a.attribute_id in (11,23,35) then d.total else 0 end) as total_baguette_amount"),
            DB::raw("count(case when a.attribute_id in (12,23,36) then 1 end) as total_triangle"),
            DB::raw("sum(case when a.attribute_id in (12,23,36) then d.total else 0 end) as total_triangle_amount"),

            // COLOR ANALYSIS
            DB::raw("count(case when a.attribute_id in (68,76) then 1 end) as total_d"),
            DB::raw("count(case when a.attribute_id in (69,77) then 1 end) as total_e"),
            DB::raw("count(case when a.attribute_id in (70,78) then 1 end) as total_f"),
            DB::raw("count(case when a.attribute_id in (71,79) then 1 end) as total_g"),
            DB::raw("count(case when a.attribute_id in (72,80) then 1 end) as total_h"),
            DB::raw("count(case when a.attribute_id in (73,81) then 1 end) as total_i"),
            DB::raw("count(case when a.attribute_id in (74,82) then 1 end) as total_j"),
            DB::raw("count(case when a.attribute_id in (75,83) then 1 end) as total_k"),

            // CLARITY ANALYSIS
            DB::raw("count(case when a.attribute_id in (37,48) then 1 end) as total_if"),
            DB::raw("count(case when a.attribute_id in (38,49) then 1 end) as total_vvs1"),
            DB::raw("count(case when a.attribute_id in (39,50) then 1 end) as total_vvs2"),
            DB::raw("count(case when a.attribute_id in (40,51) then 1 end) as total_vs1"),
            DB::raw("count(case when a.attribute_id in (41,52) then 1 end) as total_vs2"),
            DB::raw("count(case when a.attribute_id in (42,53) then 1 end) as total_si1"),
            DB::raw("count(case when a.attribute_id in (43,54) then 1 end) as total_si2"),
            DB::raw("count(case when a.attribute_id in (44,55) then 1 end) as total_si3"),
            DB::raw("count(case when a.attribute_id in (45,56) then 1 end) as total_i1"),
            DB::raw("count(case when a.attribute_id in (46,57) then 1 end) as total_i2"),
            DB::raw("count(case when a.attribute_id in (47,58) then 1 end) as total_i3"),
            DB::raw("count(case when a.attribute_id = 59 then 1 end) as total_vs"),
            DB::raw("count(case when a.attribute_id = 60 then 1 end) as total_si"),

            // CUT ANALYSIS
            DB::raw("count(case when a.attribute_id in (84,90,96) then 1 end) as total_ideal"),
            DB::raw("count(case when a.attribute_id in (85,91,97) then 1 end) as total_excellent"),
            DB::raw("count(case when a.attribute_id in (86,92,98) then 1 end) as total_very_good"),
            DB::raw("count(case when a.attribute_id in (87,93,99) then 1 end) as total_good"),
            DB::raw("count(case when a.attribute_id in (88,94,100) then 1 end) as total_fair"),
            DB::raw("count(case when a.attribute_id in (89,95,101) then 1 end) as total_poor")
        )
        // ->where('available_pcs', 1)
        ->first();

        $analysis_p = DB::table('order_diamonds as od')
        ->join('diamonds_attributes as da', 'od.refDiamond_id', '=', 'da.refDiamond_id')
        ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
        ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
        ->select(
            // SHAPE ANALYSIS
            DB::raw("count(case when a.attribute_id in (1,13,25) then 1 end) as total_round"),
            DB::raw("count(case when a.attribute_id in (2,14,26) then 1 end) as total_oval"),
            DB::raw("count(case when a.attribute_id in (3,15,27) then 1 end) as total_heart"),
            DB::raw("count(case when a.attribute_id in (4,16,28) then 1 end) as total_pear"),
            DB::raw("count(case when a.attribute_id in (5,17,29) then 1 end) as total_princess"),
            DB::raw("count(case when a.attribute_id in (6,18,30) then 1 end) as total_radiant"),
            DB::raw("count(case when a.attribute_id in (7,19,31) then 1 end) as total_asscher"),
            DB::raw("count(case when a.attribute_id in (8,20,32) then 1 end) as total_emerald"),
            DB::raw("count(case when a.attribute_id in (9,21,33) then 1 end) as total_cushion"),
            DB::raw("count(case when a.attribute_id in (10,22,34) then 1 end) as total_marquise"),
            DB::raw("count(case when a.attribute_id in (11,23,35) then 1 end) as total_baguette"),
            DB::raw("count(case when a.attribute_id in (12,23,36) then 1 end) as total_triangle"),

            // COLOR ANALYSIS
            DB::raw("count(case when a.attribute_id in (68,76) then 1 end) as total_d"),
            DB::raw("count(case when a.attribute_id in (69,77) then 1 end) as total_e"),
            DB::raw("count(case when a.attribute_id in (70,78) then 1 end) as total_f"),
            DB::raw("count(case when a.attribute_id in (71,79) then 1 end) as total_g"),
            DB::raw("count(case when a.attribute_id in (72,80) then 1 end) as total_h"),
            DB::raw("count(case when a.attribute_id in (73,81) then 1 end) as total_i"),
            DB::raw("count(case when a.attribute_id in (74,82) then 1 end) as total_j"),
            DB::raw("count(case when a.attribute_id in (75,83) then 1 end) as total_k"),

            // CLARITY ANALYSIS
            DB::raw("count(case when a.attribute_id in (37,48) then 1 end) as total_if"),
            DB::raw("count(case when a.attribute_id in (38,49) then 1 end) as total_vvs1"),
            DB::raw("count(case when a.attribute_id in (39,50) then 1 end) as total_vvs2"),
            DB::raw("count(case when a.attribute_id in (40,51) then 1 end) as total_vs1"),
            DB::raw("count(case when a.attribute_id in (41,52) then 1 end) as total_vs2"),
            DB::raw("count(case when a.attribute_id in (42,53) then 1 end) as total_si1"),
            DB::raw("count(case when a.attribute_id in (43,54) then 1 end) as total_si2"),
            DB::raw("count(case when a.attribute_id in (44,55) then 1 end) as total_si3"),
            DB::raw("count(case when a.attribute_id in (45,56) then 1 end) as total_i1"),
            DB::raw("count(case when a.attribute_id in (46,57) then 1 end) as total_i2"),
            DB::raw("count(case when a.attribute_id in (47,58) then 1 end) as total_i3"),
            DB::raw("count(case when a.attribute_id = 59 then 1 end) as total_vs"),
            DB::raw("count(case when a.attribute_id = 60 then 1 end) as total_si"),

            // CUT ANALYSIS
            DB::raw("count(case when a.attribute_id in (84,90,96) then 1 end) as total_ideal"),
            DB::raw("count(case when a.attribute_id in (85,91,97) then 1 end) as total_excellent"),
            DB::raw("count(case when a.attribute_id in (86,92,98) then 1 end) as total_very_good"),
            DB::raw("count(case when a.attribute_id in (87,93,99) then 1 end) as total_good"),
            DB::raw("count(case when a.attribute_id in (88,94,100) then 1 end) as total_fair"),
            DB::raw("count(case when a.attribute_id in (89,95,101) then 1 end) as total_poor")
        )
        // ->where('available_pcs', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders as o')
                ->whereColumn('o.order_id', 'od.refOrder_id')
                ->whereIn('o.order_status', ['PAID', 'UNPAID']);
        })
        ->first();

        $top_customers = DB::table('orders as o')
            ->joinSub('SELECT "refOrder_id", COUNT(order_diamond_id) as total_diamonds FROM order_diamonds GROUP BY "refOrder_id"', 'od', function ($join) {
                $join->on('od.refOrder_id', '=', 'o.order_id');
            })
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orders as o')
                    ->whereColumn('o.order_id', 'o.order_id')
                    ->whereIn('o.order_status', ['CANCELLED', 'PENDING']);
            })
            ->select('o.refCustomer_id', 'o.name', 'od.total_diamonds', 'o.total_paid_amount')
            // ->groupByRaw('"refCustomer_id", o.name, od.total_diamonds, o.total_paid_amount')
            ->orderBy('total_paid_amount', 'desc')
            // ->orderBy('refCustomer_id', 'desc')
            ->limit(50)
            ->get();

        $final_customers = [];
        $temp = 0;
        for ($i = 0; $i < count($top_customers); $i++) {
            if ($temp != $top_customers[$i]->refCustomer_id) {
                $temp = $top_customers[$i]->refCustomer_id;
                $final_customers[$temp]['refCustomer_id'] = $top_customers[$i]->refCustomer_id;
                $final_customers[$temp]['name'] = $top_customers[$i]->name;
                if (isset($final_customers[$temp]['total_diamonds'])) {
                    $final_customers[$temp]['total_diamonds'] += $top_customers[$i]->total_diamonds;
                    $final_customers[$temp]['total_paid_amount'] += $top_customers[$i]->total_paid_amount;
                } else {
                    $final_customers[$temp]['total_diamonds'] = $top_customers[$i]->total_diamonds;
                    $final_customers[$temp]['total_paid_amount'] = $top_customers[$i]->total_paid_amount;
                }
            } else {
                $final_customers[$temp]['total_diamonds'] += $top_customers[$i]->total_diamonds;
                $final_customers[$temp]['total_paid_amount'] += $top_customers[$i]->total_paid_amount;
            }
        }
        $final_customers = collect($final_customers)->sortByDesc('total_paid_amount')->values()->all();

        return view('admin.dashboard.sales', compact('data', 'request', 'total_paid', 'total_unpaid', 'analysis', 'analysis_p', 'final_customers'));
    }

}