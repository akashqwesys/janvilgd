<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Events;
use DataTables;

class EventsController extends Controller {

    public function index() {
        $data['title'] = 'List-Events';
        return view('admin.events.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Events';
        return view('admin.events.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $imgData = array();
        if($request->hasfile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs("public/other_images", $imageName);
            // array_push($imgData,$imageName);
        }
        // $image=json_encode($imgData);
        DB::table('events')->insert([
            'title' => $request->title,
            'image' => $imageName,
            'video_link' => $request->video_link,
            'description' => $request->description,
            'slug' => clean_string($request->slug),
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        ]);
         $Id = DB::getPdo()->lastInsertId();
        activity($request,"updated",'events',$Id);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/events');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Events::select('event_id', 'title', 'image', 'video_link', 'description', 'slug', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('event_id','desc')->get();
            return Datatables::of($data)
            //    ->addIndexColumn()
                ->addColumn('index', '')
                ->editColumn('date_added', function ($row) {
                    return date_formate($row->date_added);
                })
                ->editColumn('is_active', function ($row) {
                    $active_inactive_button = '';
                    if ($row->is_active == 1) {
                        $active_inactive_button = '<span class="badge badge-success">Active</span>';
                    }
                    if ($row->is_active == 0) {
                        $active_inactive_button = '<span class="badge badge-danger">inActive</span>';
                    }
                    return $active_inactive_button;
                })
                ->editColumn('is_deleted', function ($row) {
                    $delete_button = '';
                    if ($row->is_deleted == 1) {
                        $delete_button = '<span class="badge badge-danger">Deleted</span>';
                    }
                    return $delete_button;
                })
                ->addColumn('action', function ($row) {

                    if($row->is_active==1){
                        $str='<em class="icon ni ni-cross"></em>';
                        $class="btn-danger";
                    }
                    if($row->is_active==0){
                        $str='<em class="icon ni ni-check-thick"></em>';
                        $class="btn-success";
                    }

                    $actionBtn = '<a href="/admin/events/edit/' . $row->event_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="events" data-id="' . $row->event_id . '" data-table="events" data-wherefield="event_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->event_id . '" data-status="' . $row->is_active . '" data-table="events" data-wherefield="event_id" data-module="events">'.$str.'</button>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('events')->select('event_id', 'title', 'image', 'video_link', 'description', 'slug', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('event_id', $id)->first();
        $data['title'] = 'Edit-Events';
        $data['result'] = $result;
        return view('admin.events.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $data = [
            'title' => $request->title,
            'video_link' => $request->video_link,
            'description' => clean_html($request->description),
            'slug' => clean_string($request->slug),
            'date_updated' => date("Y-m-d H:i:s")
        ];
        $imgData = array();
        if($request->hasfile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs("public/other_images", $imageName);
            $exist_file = DB::table('events')->where('event_id', $request->id)->first();
            if ($exist_file) {
                // $arr_imgs = json_decode($exist_file->image);
                // if (count($arr_imgs)) {
                    // foreach ($arr_imgs as $v) {
                        unlink(base_path('/storage/app/public/other_images/' . $exist_file->image));
                    // }
                // }
            }
            $data['image'] = $imageName;
            // array_push($imgData,$imageName);
        }
        // $image=json_encode($imgData);
        DB::table('events')->where('event_id', $request->id)->update($data);
        activity($request,"updated",'events',$request->id);

        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/events');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            activity($request,"deleted",$request['module'],$request['table_id']);
        //    $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
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
                'date_updated' => date("Y-m-d H:i:s")
            ]);
        //    $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
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
