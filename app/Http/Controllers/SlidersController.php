<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Sliders;
use DataTables;

class SlidersController extends Controller {

    public function index() {
        $data['title'] = 'List-Sliders';
        return view('admin.sliders.list', ["data" => $data]);
    }

    public function add() {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['category'] = $categories;
        $data['title'] = 'Add-Sliders';
        return view('admin.sliders.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        DB::table('sliders')->insert([
            'title' => $request->title,
            'image' => $imageName,
            'video_link' => $request->video_link,
            'refCategory_id' => $request->refCategory_id,            
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        
        activity($request,"updated",'sliders');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('sliders');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('sliders')->select('sliders.*','categories.name as category_name')->leftJoin('categories', 'sliders.refCategory_id', '=', 'categories.category_id')->orderBy('slider_id','desc')->get();
//            $data = Sliders::latest()->orderBy('slider_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index', '')
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
                                
                                $actionBtn = '<a href="/sliders/edit/' . $row->slider_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="sliders" data-id="' . $row->slider_id . '" data-table="sliders" data-wherefield="slider_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->slider_id . '" data-status="' . $row->is_active . '" data-table="sliders" data-wherefield="slider_id" data-module="sliders">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $categories = DB::table('categories')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['category'] = $categories;
        $result = DB::table('sliders')->where('slider_id', $id)->first();
        $data['title'] = 'Edit-Sliders';
        $data['result'] = $result;
        return view('admin.sliders.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        if (isset($request->image)) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            DB::table('sliders')->where('slider_id', $request->id)->update([
                'title' => $request->title,
                'image' => $imageName,
                'video_link' => $request->video_link,
                'refCategory_id' => $request->refCategory_id,                      
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        } else {
            DB::table('sliders')->where('slider_id', $request->id)->update([
                'title' => $request->title,
                'video_link' => $request->video_link,     
                'refCategory_id' => $request->refCategory_id,            
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        }
        activity($request,"updated",'sliders');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('sliders');
    }
    public function delete(Request $request) {
        if (isset($_REQUEST['table_id'])) {
            
            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
                'is_deleted' => 1,                                
                'date_updated' => date("yy-m-d h:i:s")
            ]); 
            activity($request,"deleted",$_REQUEST['module']);
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
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
        if (isset($_REQUEST['table_id'])) {
            
            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
                'is_active' => $_REQUEST['status'],                                
                'date_updated' => date("yy-m-d h:i:s")
            ]);                        
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$_REQUEST['module']);
            return response()->json($data);
        }
    }

}

