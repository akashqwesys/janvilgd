<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use DataTables;

class UsersController extends Controller {

    public function index() {
        $data['title'] = 'List-Users';
        return view('admin.users.list', ["data" => $data]);
    }

    public function add() {
        $user_role = DB::table('user_role')->select('user_role_id', 'name', 'access_permission', 'modify_permission', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $city = DB::table('city')->select('city_id', 'name', 'refState_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $country = DB::table('country')->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['user_role'] = $user_role;
        $data['city'] = $city;
        $data['state'] = $state;
        $data['country'] = $country;
        $data['title'] = 'Add-Users';
        return view('admin.users.add', ["data" => $data]);
    }

    public function save(Request $request) {

        $request->validate([
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_proof_1' => 'mimes:doc,pdf,docx|max:2048',
            'id_proof_2' => 'mimes:doc,pdf,docx|max:2048',
            'email' => 'required|email|unique:users,email',
        ]);
        $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('profile_pic')->getClientOriginalName());
        $request->file('profile_pic')->storeAs("public/user_images", $imageName);
        $id_proof_1 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_1')->getClientOriginalName());
        $request->file('id_proof_1')->storeAs("public/user_files", $id_proof_1);
        $id_proof_2 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_2')->getClientOriginalName());
        $request->file('id_proof_2')->storeAs("public/user_files", $id_proof_2);
        /* $imageName = time() . '.' . $request->profile_pic->extension();
        $id_proof_1 = time() . '.' . $request->id_proof_1->extension();
        $id_proof_2 = time() . '.' . $request->id_proof_2->extension();
        $request->profile_pic->move(public_path('images'), $imageName);
        $request->id_proof_1->move(public_path('files'), $id_proof_1);
        $request->id_proof_2->move(public_path('files'), $id_proof_2); */
        DB::table('users')->insert([
            'name' => $request->name,
            'profile_pic' => $imageName,
            'id_proof_1' => $id_proof_1,
            'id_proof_2' => $id_proof_2,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'role_id' => $request->user_role_id,
            'address' => $request->address,
            'added_by' => $request->session()->get('loginId'),
            'is_active' => 1,
            'is_deleted' => 0,
            'last_login_type' => 'web',
            'last_login_date_time' => date("Y-m-d h:i:s"),
            'user_type' => 'USER',
            'date_added' => date("Y-m-d h:i:s"),
            'date_updated' => date("Y-m-d h:i:s")
        ]);
        activity($request, "inserted", 'users');
        successOrErrorMessage("Data added Successfully", 'success');
        return redirect('admin/users');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = User::latest()->orderBy('id','desc')->get();
            return Datatables::of($data)
                            // ->addIndexColumn()
                            ->addColumn('index', '')
                            ->editColumn('date_added', function ($row) {                                
                                return date_formate($row->date_added);
                            })
                            ->editColumn('last_login_date_time', function ($row) {                                
                                return date_time_formate($row->last_login_date_time);
                            })
                            ->editColumn('profile_pic', function ($row) {                               
                                if($row->profile_pic==0){
                                    return '';
                                }else{
                                    return '<img src="storage/app/public/user_images/'.$row->profile_pic.'" style="border-radius:100%;height:50px;width:50px;">';
                                }                                                                
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
                                $actionBtn = '<a href="/admin/users/edit/' . $row->id . '" class="btn btn-xs btn-warning">&nbsp;<em class="icon ni ni-edit-fill"></em></a> <button class="btn btn-xs btn-danger delete_button" data-module="users" data-id="' . $row->id . '" data-table="users" data-wherefield="id">&nbsp;<em class="icon ni ni-trash-fill"></em></button> <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->id . '" data-status="' . $row->is_active . '" data-table="users" data-wherefield="id" data-module="users">' . $str . '</button>';
                                return $actionBtn;
                            })
                            ->escapeColumns([])
                            ->make(true);
        }
    }

    public function edit($id) {

        $user_role = DB::table('user_role')->select('user_role_id', 'name', 'access_permission', 'modify_permission', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $city = DB::table('city')->select('city_id', 'name', 'refState_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $country = DB::table('country')->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $data['user_role'] = $user_role;
        $data['city'] = $city;
        $data['state'] = $state;
        $data['country'] = $country;

        $result = DB::table('users')->where('id', $id)->first();
        $data['title'] = 'Edit-Users';
        $data['result'] = $result;
        return view('admin.users.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'role_id' => $request->role_id,
            'date_updated' => date("Y-m-d h:i:s")
        ];
        if (isset($request->profile_pic)) {
            $request->validate([
                'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('profile_pic')->getClientOriginalName());
            $request->file('profile_pic')->storeAs("public/user_images", $imageName);
            $data['profile_pic'] = $imageName;
        }
        if (isset($request->id_proof_1)) {
            $request->validate([
                'id_proof_1' => 'mimes:doc,pdf,docx|max:2048',
            ]);
            $id_proof_1 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_1')->getClientOriginalName());
            $request->file('id_proof_1')->storeAs("public/user_files", $id_proof_1);
            $data['id_proof_1'] = $id_proof_1;
        }
        if (isset($request->id_proof_2)) {
            $request->validate([
                'id_proof_2' => 'mimes:doc,pdf,docx|max:2048',
            ]);
            $id_proof_2 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_2')->getClientOriginalName());
            $request->file('id_proof_2')->storeAs("public/user_files", $id_proof_2);
            $data['id_proof_2'] = $id_proof_2;
        }        
        DB::table('users')->where('id', $request->id)->update($data);
        activity($request, "updated", 'users');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/users');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d h:i:s")
            ]);
            activity($request, "deleted", $request['module']);
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
            activity($request, "updated", $request['module']);
            return response()->json($data);
        }
    }

}
