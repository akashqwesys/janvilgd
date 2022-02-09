<?php

namespace App\Http\Controllers;

use App\Models\CustomerCompanyDetail;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\CommonEmail;

class CustomersController extends Controller {

    public function index(Request $request) {
        $data['title'] = 'List-Customers';
        return view('admin.customers.list', ["data" => $data, 'request' => $request]);
    }

    public function add(Request $request) {
        $customer_type = DB::table('customer_type')->select('customer_type_id', 'name', 'discount', 'allow_credit', 'credit_limit', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        // $designation = DB::table('designation')->select('id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        $country = DB::table('country')->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'country_code')->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')->where('is_active', 1)->where('is_deleted', 0)->orderBy('country_code', 'asc')->get();
        // $data['designation'] = $designation;
        $data['customer_type'] = $customer_type;
        $data['country'] = $country;
        $data['title'] = 'Add-Customers';
        // session()->put('error', null);
        return view('admin.customers.add', ["data" => $data]);
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'password' => ['required', 'between:6,15'],
            'confirm_password' => ['required', 'same:password'],
            'mobile' => ['nullable', 'regex:/^[0-9]{8,11}$/ix'],
            'address' => ['required'],
            // 'refCountry_id' => ['required'],
            'refState_id' => ['required'],
            'refCity_id' => ['required'],
            'pincode' => ['required'],
            'company_name' => ['required'],
            'office_no' => ['required', 'regex:/^[0-9]{8,11}$/ix'],
            'official_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'pan_gst_no' => ['required', 'between:5,15'],
            'office_pincode' => ['required'],
            'office_address' => ['required'],
            // 'office_country_id' => ['required'],
            'office_state_id' => ['required'],
            'office_city_id' => ['required'],
            'pan_gst_no_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf']
        ];

        $message = [
            // 'mobile.required' => 'Please enter phone number',
            'mobile.regex' => 'Please enter valid 10 digits phone number',
            'email.required' => 'Please enter email address',
            'email.regex' => 'Please enter valid email address',
            'password.required' => 'Please enter password',
            'confirm_password.same' => 'Those password didn\'t match. Try again',
            'refCountry_id.required' => 'Please enter country',
            'refState_id.required' => 'Please enter state',
            'refCity_id.required' => 'Please enter city',
            'company_name.required' => 'Please enter your company name',
            'office_no.required' => 'Please enter company office number',
            'official_email.required' => 'Please enter company email address',
            'pan_gst_no.required' => 'Please enter company VAT or TIN or GST or PAN',
            'office_address.required' => 'Please enter company address',
            'office_country_id.required' => 'Please enter company country',
            'office_state_id.required' => 'Please enter company state',
            'office_city_id.required' => 'Please enter company city',
            'pan_gst_no_file.required' => 'Please select ID proof'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
        }

        $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')
            ->where('email', strtolower($request->email))
            ->first();
        if ($exists) {
            return response()->json(['error' => 1, 'message' => 'Email is already registered, Try with new email']);
        }

        $customer = new Customers;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->pincode = $request->pincode;
        $customer->refCity_id = $request->refCity_id;
        $customer->refState_id = $request->refState_id;
        $customer->refCountry_id = $request->country_code;
        $customer->refCustomerType_id = 1;
        $customer->restrict_transactions = $request->restrict_transactions;
        $customer->added_by = $request->session()->get('loginId');
        $customer->is_active = 1;
        $customer->is_deleted = 0;
        $customer->date_added = date('Y-m-d H:i:s');
        $customer->date_updated = date('Y-m-d H:i:s');
        $customer->otp = 0;
        $customer->otp_status = 0;
        $customer->verified_status = 0;
        $customer->save();

        $company = new CustomerCompanyDetail;
        $company->refCustomer_id = $customer->customer_id;
        $company->name = $request->company_name;
        $company->office_no = $request->office_no;
        $company->official_email = strtolower($request->official_email);
        $company->refDesignation_id = 0;
        $company->designation_name = 'customer';
        $company->office_address = $request->office_address;
        $company->pincode = $request->office_pincode;
        $company->refCountry_id = $request->company_country_code;
        $company->refState_id = $request->office_state_id;
        $company->refCity_id = $request->office_city_id;
        $company->pan_gst_no = $request->pan_gst_no;
        if ($request->hasFile('pan_gst_no_file')) {
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('pan_gst_no_file')->getClientOriginalName());
            $request->file('pan_gst_no_file')->storeAs("public/user_files", $imageName);
            $company->pan_gst_attachment = $imageName;
        }
        $company->save();
        $admin_email = DB::table('settings')
            ->select('value')
            ->where('key', 'admin_email')
            ->pluck('value')
            ->first();
        Mail::to($admin_email)
            ->send(
                new CommonEmail([
                    'subject' => 'New User on Janvi LGD',
                    'data' => [
                        'time' => date('Y-m-d H:i:s'),
                        'link' => url("/admin/customers/edit/{$customer->customer_id}")
                    ],
                    'view' => 'emails.commonEmail'
                ])
            );
        Mail::to($customer->email)
            ->send(
                new EmailVerification([
                    'subject' => 'Email Verification from Janvi LGD',
                    'name' => $customer->name,
                    'link' => url('/') . '/customer/email-verification/' . encrypt(($customer->email . '--' . $customer->date_added), false),
                    'otp' => 0,
                    'view' => 'emails.codeVerification_2'
                ])
            );
        activity($request, "inserted", 'customers', $customer->customer_id);
        // successOrErrorMessage("Data added Successfully", 'success');
        // return redirect('admin/customers');
        return response()->json(['success' => 1, 'message' => 'Customer added successfully']);
    }

    public function list(Request $request) {
        if ($request->ajax()) {

            $data = DB::table('customer as c')
                // ->joinSub('SELECT "refCustomer_id", pan_gst_attachment FROM customer_company_details WHERE "refCustomer_id" = customer.customer_id ORDER BY customer_company_id ASC LIMIT 1', 'ccd', function ($join) {
                //     $join->on('ccd.refCustomer_id', '=', 'c.customer_id');
                // })
                // ->join('customer_company_details as ccd', 'ccd.refCustomer_id', '=', 'c.customer_id')
                ->select('c.*', DB::raw('(SELECT pan_gst_attachment FROM customer_company_details WHERE "refCustomer_id" = c.customer_id ORDER BY customer_company_id ASC LIMIT 1) as pan_gst_attachment'));
            if ($request->is_approved == 1 || $request->is_approved == 0) {
                $data = $data->where('c.is_approved', $request->is_approved);
            }
            $data = $data->orderBy('c.customer_id', 'desc')
                ->get();

            // $data = Customers::select('customer_id', 'name', 'mobile', 'email', 'address', 'pincode', 'refCity_id', 'refState_id', 'refCountry_id', 'refCustomerType_id', 'restrict_transactions', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->latest()->orderBy('customer_id','desc')->get();
            return Datatables::of($data)
                // ->addIndexColumn()
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
                ->editColumn('is_approved', function ($row) {
                    if ($row->is_approved == 1) {
                        return '<button class="btn btn-xs btn-success" >Yes</button>';
                    } else {
                        return '<button class="btn btn-xs btn-danger active_inactive_button" data-id="' . $row->customer_id . '" data-approved="true" data-module="customers">No</button>';
                    }

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
                    $actionBtn = '<a href="/admin/customers/edit/' . $row->customer_id . '" class="btn btn-xs btn-warning"> <em class="icon ni ni-edit-fill"></em></a>&nbsp; <button class="btn btn-xs btn-danger delete_button" data-module="customers" data-id="' . $row->customer_id . '" data-table="customer" data-wherefield="customer_id"> <em class="icon ni ni-trash-fill"></em></button>&nbsp; <button class="btn btn-xs ' . $class . ' active_inactive_button" data-id="' . $row->customer_id . '" data-status="' . $row->is_active . '" data-table="customer" data-wherefield="customer_id" data-module="customers">' . $str . '</button>&nbsp;';
                    if ($row->pan_gst_attachment) {
                        $actionBtn.= ' <a href="/storage/user_files/' . $row->pan_gst_attachment . '" class="btn btn-xs btn-info" target="_blank">ID &nbsp;<em class="icon ni ni-eye-fill"></em></a>&nbsp;';
                    }

                    $actionBtn.=' <a href="/admin/customer-login-by-admin/'. encrypt($row->email,false).'" class="btn btn-xs text-white btn-primary">Login</a>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function edit($id) {
        $customer_type = DB::table('customer_type')->select('customer_type_id', 'name', 'discount', 'allow_credit', 'credit_limit', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();
        // $designation = DB::table('designation')->select('id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated')->where('is_active', 1)->where('is_deleted', 0)->get();

        $country = DB::table('country')->select('country_id', 'name', 'added_by', 'is_active', 'is_deleted', 'date_added', 'date_updated', 'country_code')->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')->where('is_active', 1)->where('is_deleted', 0)->orderBy('country_code', 'asc')->get();
        // $data['designation'] = $designation;
        $data['customer_type'] = $customer_type;

        $data['country'] = $country;
        $result = DB::table('customer')->where('customer_id', $id)->first();
        // $result2 = DB::table('customer_company_details')->where('refCustomer_id', $id)->get();
        $result2 = DB::table('customer_company_details as ccd')
            ->join('country as ctr', 'ccd.refCountry_id', '=', 'ctr.country_id')
            ->join('state as s', 'ccd.refState_id', '=', 's.state_id')
            ->join('city as ct', 'ccd.refCity_id', '=', 'ct.city_id')
            ->select('ccd.customer_company_id', 'ccd.refCustomer_id', 'ccd.name', 'ccd.office_no', 'ccd.official_email', 'ccd.refDesignation_id', 'ccd.designation_name', 'ccd.office_address', 'ccd.pincode', 'ccd.pan_gst_no', 'ccd.pan_gst_attachment', 'ctr.name as country_name', 's.name as state_name', 'ct.name as city_name', 'ccd.refCountry_id', 'ccd.refState_id', 'ccd.refCity_id')
            ->where('ccd.refCustomer_id', $id)
            ->orderBy('ccd.customer_company_id', 'asc')
            ->get();
        $data['title'] = 'Edit-Customers';
        $data['result'] = $result;
        $data['result2'] = $result2;
        return view('admin.customers.edit', ["data" => $data]);
    }

    public function update(Request $request) {
        /* if (isset($request->pan_gst_no_file)) {
            $request->validate([
                'pan_gst_no_file' => 'mimes:doc,pdf,docx|max:6000',
            ]);
            $exist_file = DB::table('customer_company_details')->where('refCustomer_id', $request->id)->first();
            if ($exist_file) {
                if(file_exists('/public/user_files/' . $exist_file->pan_gst_attachment)){
                    unlink(base_path('/storage/app/public/user_files/' . $exist_file->pan_gst_attachment));
                }
            }
            $pan_gst_no_file = time() . '_' . preg_replace('/\s+/', '_', $request->file('pan_gst_no_file')->getClientOriginalName());
            $request->file('pan_gst_no_file')->storeAs("public/user_files", $pan_gst_no_file);
            DB::table('customer_company_details')->where('refCustomer_id', $request->id)->update([
                'pan_gst_attachment' => $pan_gst_no_file,
            ]);
        } */

        DB::table('customer')->where('customer_id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'refCity_id' => $request->refCity_id,
            'refState_id' => $request->refState_id,
            'refCountry_id' => $request->refCountry_id ?? $request->country_code,
            'refCustomerType_id' => $request->refCustomerType_id,
            'restrict_transactions' => $request->restrict_transactions,
            'date_updated' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        /* DB::table('customer_company_details')->where('refCustomer_id', $request->id)->update([
            'refCustomer_id' => $request->id,
            'name' => $request->company_name,
            'office_no' => $request->office_no,
            'official_email' => $request->official_email,
            'refDesignation_id' => $request->designation_id,
            'designation_name' => 'demo',
            'office_address' => $request->office_address,
            'pincode' => $request->office_pincode,
            'refCountry_id' => $request->office_country_id,
            'refState_id' => $request->office_state_id,
            'refCity_id' => $request->office_city_id,
            'pan_gst_no' => $request->pan_gst_no,
            'approved_by' => $request->session()->get('loginId'),
            'is_approved' => $request->is_approved,
            'approved_date_time' => date("Y-m-d H:i:s")
        ]); */

        activity($request, "updated", 'customers');
        successOrErrorMessage("Data updated Successfully", 'success');
        return redirect('admin/customers');
    }

    public function delete(Request $request) {
        if (isset($request['table_id'])) {

            $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_deleted' => 1,
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            activity($request, "deleted", $request['module']);
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
            if($request['table']=="customer_company_details"){
                $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                'is_approved' => $request['status'],
                'approved_by' => $request->session()->get('loginId')
            ]);
            } else if ($request['approved'] == true) {
                $res = DB::table('customer')->where('customer_id', $request['table_id'])->update([
                    'is_approved' => 1,
                    'approved_by' => $request->session()->get('loginId'),
                    'date_updated' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'approved_at' => date("Y-m-d H:i:s")
                ]);
            } else {
                $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->update([
                    'is_active' => $request['status'],
                    'date_updated' => date("Y-m-d H:i:s")
                ]);
            }
            //  $res = DB::table($request['table'])->where($request['wherefield'], $request['table_id'])->delete();
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

    public function saveAddress(Request $request)
    {
        try {
            $rules = [
                'customer_company_id' => ['nullable', 'integer'],
                'form_customer_id' => ['required', 'integer'],
                'company_name' => ['required'],
                'company_office_no' => ['required'],
                'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'company_gst_pan' => ['required', 'min:8'],
                'company_address' => ['required'],
                // 'company_country' => ['required', 'integer', 'exists:country,country_id'],
                'company_state' => ['required', 'integer', 'exists:state,state_id'],
                'company_city' => ['required', 'integer', 'exists:city,city_id'],
                'company_pincode' => ['required'],
                'id_upload' => [/* 'required_if:customer_company_id,null', */ 'file', 'mimes:jpg,jpeg,png,pdf']
            ];

            $message = [
                'company_name.required' => 'Please enter your company name',
                'company_office_no.required' => 'Please enter company office number',
                'company_email.required' => 'Please enter company email address',
                'company_gst_pan.required' => 'Please enter company GST or PAN',
                'company_address.required' => 'Please enter company address',
                'company_country.required' => 'Please enter company country',
                'company_state.required' => 'Please enter company state',
                'company_city.required' => 'Please enter company city',
                // 'id_upload.required' => 'Please select ID proof'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            if ($request->customer_company_id) {
                $company = CustomerCompanyDetail::where('refCustomer_id', $request->form_customer_id)
                    ->where('customer_company_id', $request->customer_company_id)
                    ->first();
                if (empty($company)) {
                    return $this->errorResponse('Not a valid company');
                }
                $msg = 'Address updated successfully';
            } else {
                $msg = 'Address added successfully';
                $company = new CustomerCompanyDetail;
                $company->refCustomer_id = $request->form_customer_id;
            }
            $company->name = $request->company_name;
            $company->office_no = $request->company_office_no;
            $company->official_email = $request->company_email;
            $company->office_address = $request->company_address;
            $company->pincode = $request->company_pincode;
            $company->refCity_id = $request->company_city;
            $company->refState_id = $request->company_state;
            $company->refCountry_id = $request->company_country ?? $request->company_country_code;
            $company->pan_gst_no = $request->company_gst_pan;
            // $company->refDesignation_id = 0;
            // $company->designation_name = 'owner';
            /* $company->is_approved = 1;
            $company->approved_date_time = date('Y-m-d H:i:s');
            $company->approved_by = 0; */
            if ($request->hasfile('id_upload')) {
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_upload')->getClientOriginalName());
                $request->file('id_upload')->storeAs("public/user_files", $imageName);

                if ($company->pan_gst_attachment) {
                    unlink(base_path('/storage/app/public/user_files/' . $company->pan_gst_attachment));
                }
                $company->pan_gst_attachment = $imageName;
            }
            $company->save();

            activity($request, "inserted", 'customer_company_details', $company->customer_company_id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => 1,
                    'message' => $msg,
                    'id' => $company->customer_company_id
                ]);
            } else {
                return back()->with(['success' => 1, 'message' => $msg]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
        }
    }

    public function deleteAddress(Request $request)
    {
        try {
            $rules = [
                'customer_id' => ['required', 'integer'],
                'customer_company_id' => ['required', 'integer']
            ];

            $message = [
                'customer_company_id.required' => 'Not a valid request',
                'customer_company_id.integer' => 'Not a valid request'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            $exists = DB::table('customer_company_details as ccd')
                ->join('country as ctr', 'ccd.refCountry_id', '=', 'ctr.country_id')
                ->join('state as s', 'ccd.refState_id', '=', 's.state_id')
                ->join('city as ct', 'ccd.refCity_id', '=', 'ct.city_id')
                ->select('ccd.customer_company_id', 'ccd.refCustomer_id', 'ccd.name', 'ccd.office_no', 'ccd.official_email', 'ccd.refDesignation_id', 'ccd.designation_name', 'ccd.office_address', 'ccd.pincode', 'ccd.pan_gst_no', 'ccd.pan_gst_attachment', 'ccd.is_approved', 'ctr.name as country_name', 's.name as state_name', 'ct.name as city_name', 'ccd.refCountry_id', 'ccd.refState_id', 'ccd.refCity_id')
                ->where('ccd.refCustomer_id', $request->form_customer_id)
                ->get();
            if (count($exists) == 1) {
                return response()->json(['error' => 1, 'message' => 'You cannot delete your last address...!']);
            }

            $company = CustomerCompanyDetail::where('refCustomer_id', $request->customer_id)
                ->where('customer_company_id', $request->customer_company_id)
                ->first();

            if ($company) {
                if ($company->pan_gst_attachment) {
                    unlink(base_path('/storage/app/public/user_files/' . $company->pan_gst_attachment));
                }
                $company->delete();
                return response()->json(['success' => 1, 'message' => 'Address deleted successfully']);
            } else {
                return response()->json(['error' => 1, 'message' => 'You are not authorized']);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
        }
    }

}
