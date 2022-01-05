<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\CustomerActivity;
use DataTables;

class CustomerActivityController extends Controller
{

    public function index()
    {
        $data['title'] = 'List-Customer-Activity';
        return view('admin.customerActivity.list', ["data" => $data]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('customer_activities as ca')
                ->join('customer as c', 'ca.refCustomer_id', '=', 'c.customer_id')
                ->select('ca.id', 'ca.activity', 'ca.subject', 'ca.url', 'ca.device', 'ca.ip_address', 'ca.created_at', 'c.email')
                ->orderBy('ca.id', 'desc')
                ->get();
            return Datatables::of($data)
                ->addColumn('index', '')
                ->editColumn('url', function ($row) {
                    if ($row->device == 'web') {
                        return '<a href="/admin/customer-login-by-admin/' . encrypt($row->email, false) . '?redirect='.$row->url.'" target="_blank">VISIT</a>';
                    } else {
                        return 'API';
                    }
                })
                ->editColumn('activity', function ($row) {
                    $activity = $row->activity;
                    if ($row->activity == 'inserted') {
                        $activity = '<span class="badge badge-success">Inserted</span>';
                    }
                    if ($row->activity == 'updated') {
                        $activity = '<span class="badge badge-warning">Updated</span>';
                    }
                    if ($row->activity == 'deleted') {
                        $activity = '<span class="badge badge-danger">Deleted</span>';
                    }
                    return $activity;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }
}
