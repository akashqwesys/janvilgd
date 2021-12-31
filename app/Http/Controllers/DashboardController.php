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
        $orders = DB::table('orders')
        ->select(
            // DB::raw("count(case when DATE(date_added) = (CURRENT_DATE - INTERVAL '1 day') then 1 end) as last_day"),
            DB::raw("count(case when DATE(date_added) = CURRENT_DATE then 1 end) as today"),
            DB::raw("count(case when (DATE(date_added) <= '" . $last_day . "' and DATE(date_added) >= '" . $last_7 . "') then 1 end) as last_7"),
            DB::raw("count(case when (DATE(date_added) <= '" . $last_day . "' and DATE(date_added) >= '" . $last_30 . "') then 1 end) as last_30"),
            DB::raw("sum(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE)) then total_paid_amount else 0 end) as monthly_revenue"),
            DB::raw("sum(case when EXTRACT(MONTH FROM date_added) <= EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(MONTH FROM date_added) >= EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) then total_paid_amount else 0 end) as quaterly_revenue"),
            DB::raw("sum(case when EXTRACT(MONTH FROM date_added) <= EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(MONTH FROM date_added) >= EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) then total_paid_amount else 0 end) as yearly_revenue"),
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
                    ->where('ou.order_status_name', 'COMPLETED');
            })
            ->orderBy('o.order_id', 'desc')
            ->limit(5)
            ->get();

        $completed_orders = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('ou.order_status_name', 'COMPLETED')
            ->orderBy('o.order_id', 'desc')
            ->limit(5)
            ->get();

        $offline_orders = DB::table('orders as o')
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('o.order_type', 0)
            ->orderBy('o.order_id', 'desc')
            ->limit(5)
            ->get();

        $recent_customers = DB::table('orders as o')
            ->joinSub('SELECT "refCustomer_id", MAX(order_id) FROM orders group by "refCustomer_id"', 'o1', function ($join) {
                $join->on('o.refCustomer_id', '=', 'o1.refCustomer_id');
            })
            ->select('o.name', 'o.email_id', 'o.refTransaction_id', 'o.order_id', 'o.total_paid_amount')
            ->where('o.order_type', 1)
            ->orderBy('o.order_id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('orders', 'data', 'pending_orders', 'completed_orders', 'offline_orders', 'recent_customers'));
    }

}