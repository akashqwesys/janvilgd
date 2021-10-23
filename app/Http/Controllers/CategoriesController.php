<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Categories;
use DataTables;

class CategoriesController extends Controller
{
    public function index() {
        $data['title'] = 'List-Categories';
        return view('admin.categories.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Categories';
        return view('admin.categories.add', ["data" => $data]);
    }

    public function save(Request $request) {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('image')->getClientOriginalName());
        $request->file('image')->storeAs("public/user_blogs", $imageName);
        DB::table('categories')->insert([
            'name' => $request->name,
            'image' => $imageName,
            'description' => $request->description,
            'slug' => clean_string($request->slug),
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"inserted",'categories');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/categories');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Categories::select('category_id', 'name', 'image', 'description', 'slug', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('category_id','desc')->get();
            return Datatables::of($data)
//                            ->addIndexColumn()
                            ->addColumn('index','')
                            ->editColumn('is_active', function ($row) {
                                $active_inactive_button='';
                                if($row->is_active==1){
                                    $active_inactive_button='<span class="badge badge-success">Active</span>';
                                }
                                if($row->is_active==0){
                                    $active_inactive_button='<span class="badge badge-danger">inActive</span>';
                                }
                                return $active_inactive_button;
                            })
                            ->editColumn('is_deleted', function ($row) {
                                $delete_button='';
                                if($row->is_deleted==1){
                                    $delete_button='<span class="badge badge-danger">Deleted</span>';
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
                                $actionBtn = '<a href="/admin/categories/edit/' . $row->category_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="categories" data-id="' . $row->category_id . '" data-table="categories" data-wherefield="category_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->category_id . '" data-status="' . $row->is_active . '" data-table="categories" data-wherefield="category_id" data-module="categories">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('categories')->select('category_id', 'name', 'image', 'description', 'slug', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('category_id', $id)->first();
        $data['title'] = 'Edit-Categories';
        $data['result'] = $result;
        return view('admin.categories.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        if(isset($request->image)){
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs("public/user_blogs", $imageName);
            DB::table('categories')->where('category_id', $request->id)->update([
                'name' => $request->name,
                'image' => $imageName,
                'description' => $request->description,
                'slug' => clean_string($request->slug),
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        }else{
            DB::table('categories')->where('category_id', $request->id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => clean_string($request->slug),
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        }
        activity($request,"updated",'categories');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/categories');
    }
    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("yy-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module']);
//            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
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
                'date_updated' => date("yy-m-d h:i:s")
            ]);
//            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            activity($request,"updated",$request['module']);
            return response()->json($data);
        }
    }

}
