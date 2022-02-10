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
            $heading = 'Total Orders';
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
            $heading = 'Cancelled Orders';
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
            $heading = 'Total Carats Sold';
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
        return view('admin.reports.orders', compact('request', 'data', 'orders', 'column_name', 'filter', 'heading'));
    }

    public function reportDiamonds(Request $request)
    {
        $data['title'] = 'Diamonds Report';
        $filter = null;
        if ($request->category == 'polish') {
            $heading = 'Polish Diamonds';
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
            $filter = '&filter=polish';
        }
        else if ($request->category == '4p') {
            $heading = '4P Diamonds';
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
            $filter = '&filter=4p';
        }
        else {
            $heading = 'Rough Diamonds';
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
            $filter = '&filter=rough';
        }
        return view('admin.reports.diamonds', compact('request', 'data', 'import', 'export', 'filter', 'heading'));
    }

    public function reportCustomers(Request $request)
    {
        $data['title'] = 'Customers Report';
        $filter = null;
        if ($request->customer_type == 'recent') {
            $heading = 'Recent Customers';
            $customers = DB::table('customer as c')
                ->join('orders as o', 'c.customer_id', '=', 'o.refCustomer_id')
                ->select('c.name', 'c.email', 'o.date_added', 'c.customer_id')
                ->where('o.order_type', 1)
                ->orderBy('o.order_id', 'desc')
                ->limit(20)
                ->get()
                ->toArray();
            $customers = collect($customers)->groupBy('customer_id')->values()->toArray();

        } else if ($request->customer_type == 'top') {
            $heading = 'Top Customers';
            $customers = DB::table('orders')
                ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
                ->groupByRaw('"refCustomer_id", email_id, name')
                ->orderBy('repeative', 'desc')
                ->limit(10)
                ->get();
        } else {
            $heading = 'Bottom Customers';
            $customers = DB::table('orders')
                ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
                ->groupByRaw('"refCustomer_id", email_id, name')
                ->orderBy('repeative', 'asc')
                ->limit(10)
                ->get();
        }
        return view('admin.reports.customers', compact('request', 'data', 'customers', 'filter', 'heading'));
    }

    public function reportAttributes(Request $request)
    {
        $data['title'] = 'Diamond Attributes Report';
        $filter = null;
        if ($request->customer_type == 'recent') {
            $heading = 'Recent Customers';
            $customers = DB::table('customer as c')
            ->join('orders as o', 'c.customer_id', '=', 'o.refCustomer_id')
            ->select('c.name', 'c.email', 'o.date_added', 'c.customer_id')
            ->where('o.order_type', 1)
            ->orderBy('o.order_id', 'desc')
                ->limit(20)
                ->get()
                ->toArray();
            $customers = collect($customers)->groupBy('customer_id')->values()->toArray();
        } else if ($request->customer_type == 'top') {
            $heading = 'Top Customers';
            $customers = DB::table('orders')
            ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
                ->groupByRaw('"refCustomer_id", email_id, name')
                ->orderBy('repeative', 'desc')
                ->limit(10)
                ->get();
        } else {
            $heading = 'Bottom Customers';
            $customers = DB::table('orders')
            ->select('refCustomer_id', DB::raw("count(order_id) as repeative"), 'email_id', 'name')
                ->groupByRaw('"refCustomer_id", email_id, name')
                ->orderBy('repeative', 'asc')
                ->limit(10)
                ->get();
        }
        return view('admin.reports.customers', compact('request', 'data', 'customers', 'filter', 'heading'));
    }
}