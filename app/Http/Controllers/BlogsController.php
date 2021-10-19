<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\Blogs;
use DataTables;

class BlogsController extends Controller
{
    public function index() {
        $data['title'] = 'List-Blogs';
        return view('admin.blogs.list', ["data" => $data]);
    }
    public function add() {
        $data['title'] = 'Add-Blogs';
        return view('admin.blogs.add', ["data" => $data]);
    }
    public function save(Request $request) {                
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);    
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);                        
        DB::table('blogs')->insert([
            'title' => $request->title,
            'image' => $imageName,
            'video_link' => $request->video_link,
            'description' => $request->description,
            'slug' => clean_string($request->slug),
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-d h:i:s")
        ]);
            
        activity($request,"inserted",'blogs');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('blogs');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Blogs::latest()->orderBy('blog_id','desc')->get();
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
                                $actionBtn = '<a href="/blogs/edit/' . $row->blog_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="blogs" data-id="' . $row->blog_id . '" data-table="blogs" data-wherefield="blog_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->blog_id . '" data-status="' . $row->is_active . '" data-table="blogs" data-wherefield="blog_id" data-module="blogs">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('blogs')->where('blog_id', $id)->first();
        $data['title'] = 'Edit-Blogs';
        $data['result'] = $result;
        return view('admin.blogs.edit', ["data" => $data]);
    }

    public function update(Request $request) {        
        if(isset($request->image)){            
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);    
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);

            DB::table('blogs')->where('blog_id', $request->id)->update([
                'title' => $request->title,
                'image' => $imageName,
                'video_link' => $request->video_link,
                'description' => $request->description,
                'slug' => clean_string($request->slug),                                           
                'date_updated' => date("yy-m-d h:i:s")
            ]);           
        }else{
            DB::table('blogs')->where('blog_id', $request->id)->update([
                'title' => $request->title,               
                'video_link' => $request->video_link,
                'description' => $request->description,
                'slug' => clean_string($request->slug),                                           
                'date_updated' => date("yy-m-d h:i:s")
            ]);
        }        
        activity($request,"updated",'blogs');               
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('blogs');
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
