<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Attributes;
use DataTables;

class AttributeController extends Controller
{
    public function index() {
        $data['title'] = 'List-Attributes';
        return view('admin.attributes.list', ["data" => $data]);
    }

    public function add() {
        $categories = DB::table('categories')->select('category_id', 'name', 'image', 'description', 'slug', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'created_at', 'updated_at')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['category'] = $categories;      
        $data['title'] = 'Add-Attributes';
        return view('admin.attributes.add', ["data" => $data]);
    }

    public function save(Request $request) {        
        $imgData = array();
        if($request->hasfile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName); 
            array_push($imgData,$imageName); 
        }
        $image=json_encode($imgData);        
        DB::table('attributes')->insert([
            'name' => $request->name,
            'attribute_group_id' => $request->attribute_group_id,
            'image' => $image,
            'added_by' => $request->session()->get('loginId'),
            'sort_order' => $request->sort_order,
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        
        activity($request,"inserted",'attributes');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/attributes');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('attributes')->select('attributes.*', 'attribute_groups.name as attribute_groups_name')->leftJoin('attribute_groups', 'attributes.attribute_group_id', '=', 'attribute_groups.attribute_group_id')->orderBy('attribute_id', 'desc')->get();
            return Datatables::of($data)
                            // ->addIndexColumn()
                            ->addColumn('index','')
                            ->editColumn('date_added', function ($row) {                                
                                return date_formate($row->date_added);
                            })
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
                             ->editColumn('image', function ($row) {                               
                                if($row->image==0){
                                    return '';
                                }else{
                                    return '<img src="'.asset(check_host().'images').'/'.$row->image.'" style="border-radius:10px;height:50px;width:50px;">';
                                }                                                                
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
                                $actionBtn = '<a href="/admin/attributes/edit/' . $row->attribute_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="attributes" data-id="' . $row->attribute_id . '" data-table="blogs" data-wherefield="attribute_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->attribute_id . '" data-status="' . $row->is_active . '" data-table="attributes" data-wherefield="attribute_id" data-module="attributes">'.$str.'</button>';
                                return $actionBtn;
                            })                           
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {

        $categories = DB::table('categories')->select('category_id', 'name', 'image', 'description', 'slug', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'created_at', 'updated_at')->where('is_active', 1)->where('is_deleted', 0)->get();
                       
        $result = DB::table('attributes')->where('attribute_id', $id)->first();
        $attribute_cat = DB::table('attribute_groups')->where('attribute_group_id', $result->attribute_group_id)->where('is_active', 1)->where('is_deleted', 0)->first();  
        
//        print_r($attribute_cat);die;
//        echo $attribute_cat->refCategory_id;die;
        $attribute_groups = DB::table('attribute_groups')->where('refCategory_id', $attribute_cat->refCategory_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
        $data['is_image'] = "d-none";
        foreach ($attribute_groups as $row){
            if($row->attribute_group_id==$result->attribute_group_id){
                if($row->image_required==1){
                    $data['is_image'] = "";
                }
            }
        }                        
        $data['category'] = $categories;  
        $data['attribute_groups'] = $attribute_groups;        
        $data['title'] = 'Edit-Attributes';
        $data['result'] = $result;
        $data['refCategory_id']=$attribute_cat->refCategory_id;
        return view('admin.attributes.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $imgData = array();
        if($request->hasfile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            array_push($imgData,$imageName); 
        }
        $image=json_encode($imgData);
        DB::table('attributes')->where('attribute_id', $request->id)->update([
            'name' => $request->name,
            'attribute_group_id' => $request->attribute_group_id,
            'sort_order' => $request->sort_order,
            'image' => $image,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        
        activity($request,"updated",'attributes');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/attributes');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request,"deleted",$request['module']);
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
            activity($request,"updated",$request['module']);
            return response()->json($data);
        }
    }
}

