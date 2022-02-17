<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Facades\Validator;
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
        // $city = DB::table('city')->select('city_id', 'name', 'refState_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        // $state = DB::table('state')->select('state_id', 'name', 'refCountry_id', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $country = DB::table('country')
        ->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'country_code', DB::raw("cast (country_code as integer) as cc"))
        ->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')
        ->where('is_active', 1)->where('is_deleted', 0)
        ->orderBy('cc', 'asc')
        ->get();
        $data['user_role'] = $user_role;
        // $data['city'] = $city;
        // $data['state'] = $state;
        $data['country'] = $country;
        $data['title'] = 'Add-Users';
        return view('admin.users.add', ["data" => $data]);
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'mobile' => ['nullable', 'regex:/^[0-9]{8,11}$/ix'],
            'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'password' => ['required', 'between:6,15'],
            'confirm_password' => ['required', 'same:password'],
            'address' => ['required'],
            'profile_pic' => ['file', 'mimes:jpeg,png,jpg,gif', 'max:3072'],
            'id_proof_1' => ['file', 'mimes:doc,pdf,docx', 'max:3072'],
            'id_proof_2' => ['file', 'mimes:doc,pdf,docx', 'max:3072']
        ];

        $message = [
            'mobile.required' => 'Please enter phone number',
            'mobile.regex' => 'Please enter valid 10 digits phone number',
            'email.required' => 'Please enter email address',
            'email.regex' => 'Please enter valid email address',
            'password.required' => 'Please enter password',
            'confirm_password.same' => 'Those password didn\'t match. Try again',
            'address.required' => 'Please enter address'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
        }
        $exists = DB::table('users')->select('id', 'email')
            ->where('email', strtolower($request->email))
            ->first();
        if ($exists) {
            return response()->json(['error' => 1, 'message' => 'Email is already registered, Try with new email']);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->city_id = $request->city_id ?? 0;
        $user->state_id = $request->state_id ?? 0;
        $user->country_id = $request->country_id ?? $request->country_code;
        $user->role_id = $request->role_id;
        $user->added_by = $request->session()->get('loginId');
        $user->is_active = 1;
        $user->is_deleted = 0;
        $user->last_login_type = 'web';
        $user->last_login_date_time = date("Y-m-d H:i:s");
        $user->user_type = $request->user_type;
        $user->date_added = date("Y-m-d H:i:s");
        $user->date_updated = date("Y-m-d H:i:s");

        if ($request->hasFile('profile_pic')) {
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('profile_pic')->getClientOriginalName());
            $request->file('profile_pic')->storeAs("public/user_images", $imageName);
            $user->profile_pic = $imageName;
        }
        if ($request->hasFile('id_proof_1')) {
            $id_proof_1 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_1')->getClientOriginalName());
            $request->file('id_proof_1')->storeAs("public/user_files", $id_proof_1);
            $user->id_proof_1 = $id_proof_1;
        }
        if ($request->hasFile('id_proof_2')) {
            $id_proof_2 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_2')->getClientOriginalName());
            $request->file('id_proof_2')->storeAs("public/user_files", $id_proof_2);
            $user->id_proof_2 = $id_proof_2;
        }

        $user->save();

        activity($request, "inserted", 'users', $user->id);
        /* $admin_email = DB::table('settings')
            ->select('value')
            ->where('key', 'admin_email')
            ->pluck('value')
            ->first();
        Mail::to($admin_email)
            ->send(
                new CommonEmail([
                    'subject' => 'New Employee on Janvi LGD',
                    'data' => [
                        'time' => date('Y-m-d H:i:s'),
                        'link' => url("/admin/customers/edit/{$customer->customer_id}")
                    ],
                    'view' => 'emails.commonEmail'
                ])
            ); */
        return response()->json(['success' => 1, 'message' => 'Employee added successfully']);
        // successOrErrorMessage("Data added Successfully", 'success');
        // return redirect('admin/users');
    }

    public function list(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('users')->select('users.*', 'user_role.name as role_name')
                    ->leftJoin('user_role','user_role.user_role_id', '=', 'users.role_id')
                    ->get();
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
                        return '<img src="/storage/user_images/'.$row->profile_pic.'" style="border-radius:100%;height:50px;width:50px;">';
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
        $result = DB::table('users')->where('id', $id)->first();
        $country = DB::table('country')
            ->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'country_code', DB::raw("cast (country_code as integer) as cc"))
            ->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('cc', 'asc')
            ->get();

        $state = DB::table('state')
            ->select('state_id', 'name')
            ->where('refCountry_id', $result->country_id)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('name', 'asc')
            ->get();

        $city = DB::table('city')
            ->select('city_id', 'name')
            ->where('refState_id', $result->state_id)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('name', 'asc')
            ->get();

        $data['user_role'] = $user_role;
        $data['country'] = $country;
        $data['state'] = $state;
        $data['city'] = $city;
        $data['title'] = 'Edit-Users';
        $data['result'] = $result;
        return view('admin.users.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        $rules = [
            'id' => [],
            'name' => ['required'],
            'mobile' => ['nullable', 'regex:/^[0-9]{8,11}$/ix'],
            'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            // 'password' => ['required', 'between:6,15'],
            // 'confirm_password' => ['required', 'same:password'],
            'address' => ['required'],
            'profile_pic' => ['file', 'mimes:jpeg,png,jpg,gif', 'max:3072'],
            'id_proof_1' => ['file', 'mimes:doc,pdf,docx', 'max:3072'],
            'id_proof_2' => ['file', 'mimes:doc,pdf,docx', 'max:3072']
        ];

        $message = [
            'mobile.required' => 'Please enter phone number',
            'mobile.regex' => 'Please enter valid 10 digits phone number',
            'email.required' => 'Please enter email address',
            'email.regex' => 'Please enter valid email address',
            'password.required' => 'Please enter password',
            'confirm_password.same' => 'Those password didn\'t match. Try again',
            'address.required' => 'Please enter address'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id ?? $request->country_code,
            'role_id' => isset($request->role_id) ? $request->role_id : 0,
            'date_updated' => date("Y-m-d H:i:s")
        ];
        $exist_file = DB::table('users')->where('id', $request->id)->first();
        if (isset($request->profile_pic)) {
            $request->validate([
                'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('profile_pic')->getClientOriginalName());
            $request->file('profile_pic')->storeAs("public/user_images", $imageName);
            $data['profile_pic'] = $imageName;
            if ($exist_file) {
                unlink(base_path('/storage/app/public/user_images/' . $exist_file->profile_pic));
            }
        }
        if (isset($request->id_proof_1)) {
            $request->validate([
                'id_proof_1' => 'mimes:doc,pdf,docx|max:2048',
            ]);
            $id_proof_1 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_1')->getClientOriginalName());
            $request->file('id_proof_1')->storeAs("public/user_files", $id_proof_1);
            $data['id_proof_1'] = $id_proof_1;
            if ($exist_file) {
                unlink(base_path('/storage/app/public/user_images/' . $exist_file->id_proof_1));
            }
        }
        if (isset($request->id_proof_2)) {
            $request->validate([
                'id_proof_2' => 'mimes:doc,pdf,docx|max:2048',
            ]);
            $id_proof_2 = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_proof_2')->getClientOriginalName());
            $request->file('id_proof_2')->storeAs("public/user_files", $id_proof_2);
            $data['id_proof_2'] = $id_proof_2;
            if ($exist_file) {
                unlink(base_path('/storage/app/public/user_images/' . $exist_file->id_proof_2));
            }
        }
        DB::table('users')->where('id', $request->id)->update($data);
        activity($request, "updated", 'users', $request->id);
        return response()->json(['success' => 1, 'message' => 'Employee updated successfully']);
        // successOrErrorMessage("User updated Successfully", 'success');
        // return redirect('admin/users');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            activity($request, "deleted", $request['module'],$request['table_id']);
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
                'date_updated' => date("Y-m-d H:i:s")
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
            activity($request, "updated", $request['module'],$request['table_id']);
            return response()->json($data);
        }
    }

    public function saveFirebaseToken(Request $request)
    {
        DB::table('users')->where('id', $request->session()->get('loginId'))->update(['device_token' => $request->token]);
        return response()->json(['Token saved successfully.']);
    }

    public function testNoti()
    {
        sendWebNotification('Hi', 'Body 123');
    }

}
