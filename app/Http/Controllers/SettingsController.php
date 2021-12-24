<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Settings;
use DataTables;

class SettingsController extends Controller {

    public function index() {
        $data['title'] = 'List-Settings';
        return view('admin.settings.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Settings';
        return view('admin.settings.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $attachment=0;
        if($request->hasFile('attachment')){
            $attachment = time() . '_' . preg_replace('/\s+/', '_', $request->file('attachment')->getClientOriginalName());
            $request->file('attachment')->storeAs("public/user_files", $attachment);
        }
        DB::table('settings')->insert([
            'key' => $request->key,
            'value' => $request->value,
            'attachment' => $attachment,
            'updated_by' => $request->session()->get('loginId'),
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        $Id = DB::getPdo()->lastInsertId();
        activity($request,"inserted",'settings',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/settings');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Settings::select('setting_id', 'key', 'value', 'updated_by', 'date_updated')->latest()->orderBy('setting_id','desc')->get();
            return Datatables::of($data)
                ->addColumn('index', '')
                ->editColumn('date_updated', function ($row) {
                    return date_formate($row->date_updated);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="/admin/settings/edit/' . $row->setting_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('settings')->select('setting_id', 'key', 'value', 'updated_by', 'date_updated')->where('setting_id', $id)->first();
        $data['title'] = 'Edit-Settings';
        $data['result'] = $result;
        return view('admin.settings.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        if($request->hasFile('attachment')){
            $attachment = time() . '_' . preg_replace('/\s+/', '_', $request->file('attachment')->getClientOriginalName());
            $request->file('attachment')->storeAs("public/user_files", $attachment);
            $exist_file = DB::table('settings')->where('setting_id', $request->id)->first();
            if ($exist_file) {
                unlink(base_path('/storage/app/public/user_files/' . $exist_file->attachment));
            }
            DB::table('settings')->where('setting_id', $request->id)->update([
                'key' => $request->key,
                'value' => $request->value,
                'attachment' => $attachment,
                'updated_by' => $request->session()->get('loginId'),
                'date_updated' => date("Y-m-d h:i:s")
            ]);
        } else {
            DB::table('settings')->where('setting_id', $request->id)->update([
                'key' => $request->key,
                'value' => $request->value,
                'updated_by' => $request->session()->get('loginId'),
                'date_updated' => date("Y-m-d h:i:s")
            ]);
        }
        activity($request,"updated",'settings',$request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/settings');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module'],$request['table_id']);
            // $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            return response()->json($data);
        }
    }
    public function status(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_active' => $request['status'],
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            // $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$request['module'],$request['table_id']);
            return response()->json($data);
        }
    }
}


