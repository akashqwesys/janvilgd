<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\UserActivity;
use DataTables;

class UserActivityController extends Controller {

    public function index() {
        $data['title'] = 'List-User-Activity';
        return view('admin.userActivity.list', ["data" => $data]);
    }
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('user_activity')->select('user_activity.*','users.name as user_name','modules.name as module_name')->leftJoin('users', 'user_activity.refUser_id', '=', 'users.id')->leftJoin('modules', 'user_activity.refModule_id', '=', 'modules.module_id')->orderBy('user_activity_id','desc')->get();
            return Datatables::of($data)
                            ->addColumn('index', '')
                            ->editColumn('activity', function ($row) {
                                $activity=$row->activity;
                               
                                if($row->activity=='inserted'){
                                    $activity='<span class="badge badge-success">Inserted</span>';
                                } 
                                if($row->activity=='updated'){
                                    $activity='<span class="badge badge-warning">Updated</span>';
                                }
                                if($row->activity=='deleted'){
                                    $activity='<span class="badge badge-danger">Deleted</span>';
                                }
                                return $activity;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

}
