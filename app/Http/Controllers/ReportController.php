<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Orders;
use DataTables;
use Elasticsearch\ClientBuilder;

class ReportController extends Controller
{
    public function reportOrders(Request $request)
    {
        $data['title'] = 'Orders Report';
        $filter = null;
        if ($request->order_type == 'total_orders') {
            $column_name = 'Total Orders';
            $orders = DB::table('orders')
            ->select(
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '1 month')) then 1 end) as cur_month1"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '2 month')) then 1 end) as cur_month2"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '3 month')) then 1 end) as cur_month3"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '4 month')) then 1 end) as cur_month4"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '5 month')) then 1 end) as cur_month5"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '6 month')) then 1 end) as cur_month6"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '7 month')) then 1 end) as cur_month7"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '8 month')) then 1 end) as cur_month8"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '9 month')) then 1 end) as cur_month9"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '10 month')) then 1 end) as cur_month10"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(Year FROM (CURRENT_DATE - INTERVAL '11 month')) then 1 end) as cur_month11"),
                DB::raw("count(case when EXTRACT(MONTH FROM date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) then 1 end) as cur_month12")
            )
            ->first();

        }
        else if ($request->order_type == 'cancelled_orders') {
            $column_name = 'Cancelled Orders';
            $orders = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->select(
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) then 1 end) as cur_month1"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) then 1 end) as cur_month2"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) then 1 end) as cur_month3"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) then 1 end) as cur_month4"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) then 1 end) as cur_month5"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) then 1 end) as cur_month6"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) then 1 end) as cur_month7"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) then 1 end) as cur_month8"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) then 1 end) as cur_month9"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) then 1 end) as cur_month10"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) then 1 end) as cur_month11"),
                DB::raw("count(case when EXTRACT(MONTH FROM ou.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM ou.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) then 1 end) as cur_month12")
            )
            ->where('order_status_name', 'CANCELLED')
            ->first();
            $filter = '&filter=CANCELLED';
        } else {
            $column_name = 'Total Carats Sold';
            $orders = DB::table('order_diamonds')
            ->select(
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) then expected_polish_cts else 0 end) as cur_month1"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) then expected_polish_cts else 0 end) as cur_month2"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) then expected_polish_cts else 0 end) as cur_month3"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) then expected_polish_cts else 0 end) as cur_month4"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) then expected_polish_cts else 0 end) as cur_month5"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) then expected_polish_cts else 0 end) as cur_month6"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) then expected_polish_cts else 0 end) as cur_month7"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) then expected_polish_cts else 0 end) as cur_month8"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) then expected_polish_cts else 0 end) as cur_month9"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) then expected_polish_cts else 0 end) as cur_month10"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) then expected_polish_cts else 0 end) as cur_month11"),
                DB::raw("sum(case when EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) then expected_polish_cts else 0 end) as cur_month12")
            )
            ->first();
        }
        return view('admin.reports.orders', compact('request', 'data', 'orders', 'column_name', 'filter'));
    }

    public function reportDiamonds(Request $request)
    {
        $data['title'] = 'Diamonds Report';
        $filter = null;
        if ($request->category == 'polish') {
            $import = DB::table('diamonds as d')
            ->join('categories as c', 'd.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month1"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month2"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month3"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month4"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month5"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month6"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month7"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month8"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month9"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month10"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month11"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month12"),
            )
            ->first();

            $export = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->join('order_diamonds as od', 'o.order_id', '=', 'od.refOrder_id')
            ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month1"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month2"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month3"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month4"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month5"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month6"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month7"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month8"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month9"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month10"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month11"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) and c.slug = 'polish-diamonds') then 1 end) as cur_month12")
            )
            ->where('order_status_name', 'COMPLETED')
            ->first();
        }
        else if ($request->category == '4p') {
            $import = DB::table('diamonds as d')
            ->join('categories as c', 'd.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month1"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month2"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month3"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month4"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month5"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month6"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month7"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month8"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month9"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month10"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month11"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month12")
            )
            ->first();

            $export = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->join('order_diamonds as od', 'o.order_id', '=', 'od.refOrder_id')
            ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month1"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month2"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month3"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month4"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month5"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month6"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month7"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month8"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month9"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month10"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month11"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) and c.slug = '4p-diamonds') then 1 end) as cur_month12")
            )
            ->where('order_status_name', 'COMPLETED')
            ->first();
        }
        else {
            $import = DB::table('diamonds as d')
            ->join('categories as c', 'd.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month1"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month2"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month3"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month4"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month5"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month6"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month7"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month8"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month9"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month10"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month11"),
                DB::raw("count(case when (EXTRACT(MONTH FROM d.date_added) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM d.date_added) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month12")
            )
            ->first();

            $export = DB::table('orders as o')
            ->join('order_updates as ou', 'o.order_id', '=', 'ou.refOrder_id')
            ->join('order_diamonds as od', 'o.order_id', '=', 'od.refOrder_id')
            ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
            ->select(
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '1 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '1 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month1"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '2 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '2 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month2"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '3 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '3 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month3"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '4 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '4 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month4"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '5 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '5 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month5"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '6 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '6 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month6"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '7 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '7 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month7"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '8 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '8 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month8"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '9 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '9 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month9"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '10 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '10 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month10"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '11 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '11 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month11"),
                DB::raw("count(case when (EXTRACT(MONTH FROM od.created_at) = EXTRACT(MONTH FROM (CURRENT_DATE - INTERVAL '12 month')) and EXTRACT(YEAR FROM od.created_at) = EXTRACT(YEAR FROM (CURRENT_DATE - INTERVAL '12 month')) and c.slug = 'rough-diamonds') then 1 end) as cur_month12")
            )
            ->where('order_status_name', 'COMPLETED')
            ->first();
        }
        return view('admin.reports.diamonds', compact('request', 'data', 'import', 'export', 'filter'));
    }
}