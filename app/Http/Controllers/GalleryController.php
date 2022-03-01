<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Gallery;
use DataTables;

class GalleryController extends Controller
{
    public function index()
    {
        $data['title'] = 'List-Gallery';
        return view('admin.gallery.list', ["data" => $data]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'image' => 'array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = [];
        foreach ($request->file('image') as $v) {
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $v->getClientOriginalName());
            $v->storeAs("public/other_images", $imageName);
            $data[] = [
                'image' => $imageName,
                'added_by' => $request->session()->get('loginId'),
                'is_active' => 1,
                'is_deleted' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }

        DB::table('galleries')->insert($data);
        activity($request, "inserted", 'galleries', 0);
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/gallery');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::orderBy('gallery_id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('index', '')
                ->editColumn('image', function ($row) {
                    return '<div> <img class="gallery-image" src="/storage/other_images/'.$row->image.'" height="70"></div>';
                })
                ->editColumn('created_at', function ($row) {
                    return date_formate($row->created_at);
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
                    if ($row->is_active == 1) {
                        $str = '<em class="icon ni ni-cross"></em>';
                        $class = "btn-danger";
                    }
                    if ($row->is_active == 0) {
                        $str = '<em class="icon ni ni-check-thick"></em>';
                        $class = "btn-success";
                    }
                    $actionBtn = '<button data-id="' . $row->gallery_id . '" class="btn btn-xs btn-warning edit-gallery">&nbsp;<em class="icon ni ni-edit-fill"></em></button> <button class="btn btn-xs btn-danger delete_button" data-module="galleries" data-id="' . $row->gallery_id . '" data-table="galleries" data-wherefield="gallery_id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->gallery_id . '" data-status="' . $row->is_active . '" data-table="galleries" data-wherefield="gallery_id" data-module="galleries">' . $str . '</button>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id' => 'integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $exist_file = DB::table('galleries')->where('gallery_id', $request->id)->first();
        if ($exist_file) {
            unlink(base_path('/storage/app/public/other_images/' . $exist_file->image));
        }

        $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('image')->getClientOriginalName());
        $request->file('image')->storeAs("public/other_images", $imageName);

        DB::table('galleries')->where('gallery_id', $request->id)->update([
            'image' => $imageName,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        activity($request, "updated", 'galleries', $request->id);
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/gallery');
    }

    public function delete(Request $request)
    {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
            activity($request, "deleted", $request['module'], $request['table_id']);
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

    public function status(Request $request)
    {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_active' => $request['status'],
                'updated_at' => date("Y-m-d H:i:s")
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
            activity($request, "updated", $request['module'], $request['table_id']);
            return response()->json($data);
        }
    }
}
