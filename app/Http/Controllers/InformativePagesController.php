<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\InformativePages;
use DataTables;

class InformativePagesController extends Controller {

    public function index() {
        $data['title'] = 'List-Informative-Pages';
        return view('admin.informativePages.list', ["data" => $data]);
    }

    public function add() {
        $data['title'] = 'Add-Informative-Pages';
        return view('admin.informativePages.add', ["data" => $data]);
    }

    public function save(Request $request) {

        DB::table('informative_pages')->insert([
            'name' => $request->name,
            'content' => clean_html($request->content),
            'slug' => clean_string($request->slug),
            'updated_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request,"inserted",'informative-pages');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/informative-pages');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = InformativePages::select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->latest()->orderBy('informative_page_id','desc')->get();
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
                            ->addColumn('action', function ($row) {

                                 if($row->is_active==1){
                                    $str='<em class="icon ni ni-cross"></em>';
                                    $class="btn-danger";
                                }
                                if($row->is_active==0){
                                    $str='<em class="icon ni ni-check-thick"></em>';
                                    $class="btn-success";
                                }

                                $actionBtn = '<a href="/admin/informative-pages/edit/' . $row->informative_page_id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs '.$class.' active_inactive_button" data-id="' . $row->informative_page_id . '" data-status="' . $row->is_active . '" data-table="informative_pages" data-wherefield="informative_page_id" data-module="informative-pages">'.$str.'</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {
        $result = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('informative_page_id', $id)->first();
        if(!empty($result)){
            $str= str_replace('&lt;','<', $result->content);
            $str1= str_replace('&gt;','>', $str);
            $result->content= $str1;
        }
        $data['title'] = 'Edit-Informative-Pages';
        $data['result'] = $result;
        return view('admin.informativePages.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        DB::table('informative_pages')->where('informative_page_id', $request->id)->update([
            'name' => $request->name,
            'content' => clean_html($request->content),
            'slug' => clean_string($request->slug),
            'updated_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'date_updated' => date("yy-m-d h:i:s")
        ]);
        activity($request,"updated",'informative-pages');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/informative-pages');
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

    public function frontHome(Request $request)
    {
        $data = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('slug', 'index')->first();
        return view('front.common', ["data" => $data]);
    }

}
