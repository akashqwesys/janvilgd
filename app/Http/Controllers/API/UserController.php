<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use App\Mail\EmailVerification;
use App\Mail\CommonEmail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use APIResponse;

    public function myAccount(Request $request)
    {
        $customer = DB::table('customer as c')
            ->join('country as ctr', 'c.refCountry_id', '=', 'ctr.country_id')
            ->join('state as s', 'c.refState_id', '=', 's.state_id')
            ->join('city as ct', 'c.refCity_id', '=', 'ct.city_id')
            ->select('c.customer_id', 'c.name', 'c.mobile', 'c.email', 'c.address', 'c.pincode', 'ctr.name as country_name', 's.name as state_name', 'ct.name as city_name', 'c.refCountry_id', 'c.refState_id', 'c.refCity_id')
            ->where('c.customer_id', Auth::id())
            ->first();

        $company = DB::table('customer_company_details as ccd')
            ->join('country as ctr', 'ccd.refCountry_id', '=', 'ctr.country_id')
            ->join('state as s', 'ccd.refState_id', '=', 's.state_id')
            ->join('city as ct', 'ccd.refCity_id', '=', 'ct.city_id')
            ->select('ccd.customer_company_id', 'ccd.refCustomer_id', 'ccd.name', 'ccd.office_no', 'ccd.official_email', 'ccd.refDesignation_id', 'ccd.designation_name', 'ccd.office_address', 'ccd.pincode', 'ccd.pan_gst_no', 'ccd.pan_gst_attachment', 'ctr.name as country_name', 's.name as state_name','ct.name as city_name', 'ccd.refCountry_id', 'ccd.refState_id', 'ccd.refCity_id')
            ->where('ccd.refCustomer_id', $customer->customer_id)
            ->get();

        $data = ['customer' => $customer, 'company' => $company];

        return $this->successResponse('Success', $data);
    }

    /* public function getProfile(Request $request)
    {
        $customer = DB::table('customer as c')
            ->select('c.customer_id', 'c.name', 'c.mobile', 'c.email', 'c.address', 'c.pincode', 'c.refCountry_id', 'c.refState_id', 'c.refCity_id')
            ->where('c.customer_id', Auth::id())
            ->first();

        $company = DB::table('customer_company_details as ccd')
            ->select('ccd.customer_company_id', 'ccd.refCustomer_id', 'ccd.name', 'ccd.office_no', 'ccd.official_email', 'ccd.refDesignation_id', 'ccd.designation_name', 'ccd.office_address', 'ccd.pincode', 'ccd.pan_gst_no', 'ccd.pan_gst_attachment', 'ccd.is_approved', 'ccd.refCountry_id', 'ccd.refState_id', 'ccd.refCity_id')
            ->where('ccd.refCustomer_id', $customer->customer_id)
            ->first();

        $data = ['customer' => $customer, 'company' => $company];

        return $this->successResponse('Success', $data);
    } */

    public function updateProfile(Request $request)
    {
        try {
            $rules = [
                'name' => ['required'],
                'mobile' => ['nullable', 'regex:/^[0-9]{8,11}$/ix'],
                'email' => ['regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'address' => ['required'],
                'country' => ['required_with:mobile', 'integer', 'exists:country,country_id'],
                'state' => ['required', 'integer', 'exists:state,state_id'],
                'city' => ['required', 'integer', 'exists:city,city_id'],
                'pincode' => ['required'],
                /* 'company_name' => ['required'],
                'company_office_no' => ['required'],
                'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'company_gst_pan' => ['required', 'between:10,15'],
                'company_address' => ['required'],
                'company_country' => ['required', 'integer', 'exists:country,country_id'],
                'company_state' => ['required', 'integer', 'exists:state,state_id'],
                'company_city' => ['required', 'integer', 'exists:city,city_id'],
                'company_pincode' => ['required', 'digits:6'],
                'id_upload' => ['file', 'mimes:jpg,jpeg,png,pdf'] */
            ];

            $message = [
                // 'mobile.required' => 'Please enter phone number',
                'mobile.regex' => 'Please enter valid 10 digits phone number',
                // 'email.required' => 'Please enter email address',
                'email.regex' => 'Please enter valid email address',
                'country.required' => 'Please enter country',
                'state.required' => 'Please enter state',
                'city.required' => 'Please enter city',
                /* 'company_name.required' => 'Please enter your company name',
                'company_office_no.required' => 'Please enter company office number',
                'company_email.required' => 'Please enter company email address',
                'company_gst_pan.required' => 'Please enter company GST or PAN',
                'company_address.required' => 'Please enter company address',
                'company_country.required' => 'Please enter company country',
                'company_state.required' => 'Please enter company state',
                'company_city.required' => 'Please enter company city',
                'id_upload.required' => 'Please select ID proof' */
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $customer = Auth::user();
            $customer->name = $request->name;
            $customer->address = $request->address;
            if (empty(trim($customer->email))){
                $customer->email = $request->email;
            }
            if (empty(trim($customer->mobile))) {
                $customer->mobile = $request->mobile;
                $customer->refCountry_id = $request->country ?? $request->country_code;
            }
            $customer->pincode = $request->pincode;
            $customer->refCity_id = $request->city;
            $customer->refState_id = $request->state;
            $customer->date_updated = date('Y-m-d H:i:s');
            $customer->save();

            $data = new \stdClass;
            $data->email = $customer->email;
            $data->mobile = $customer->mobile;
            $data->name = $customer->name;
            $data->address = $customer->address;
            $data->pincode = $customer->pincode;
            $csc = DB::table('country as c')
                ->join('state as s', 'c.country_id', '=', 's.refCountry_id')
                ->join('city as ct', 's.state_id', '=', 'ct.refState_id')
                ->select('c.name as country', 's.name as state', 'ct.name as city')
                ->where('ct.city_id', $customer->refCity_id)
                ->first();
            $data->city = $csc->city;
            $data->state = $csc->state;
            $data->country = $csc->country;
            $data->cart = DB::table('customer_cart')->select('id')->where('refCustomer_id')->count();

            /* $company = CustomerCompanyDetail::where('refCustomer_id', $customer->customer_id)->first();
            $company->name = $request->company_name;
            $company->office_no = $request->company_office_no;
            $company->official_email = $request->company_email;
            $company->office_address = $request->company_address;
            // $company->pincode = $request->pincode;
            $company->refCity_id = $request->company_city;
            $company->refState_id = $request->company_state;
            $company->refCountry_id = $request->company_country;
            $company->pan_gst_no = $request->company_gst_pan;

            if ($request->hasfile('id_upload')) {
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_upload')->getClientOriginalName());
                $request->file('id_upload')->storeAs("public/user_files", $imageName);

                if ($company->pan_gst_attachment) {
                    unlink(base_path('/storage/app/public/user_files/' . $company->pan_gst_attachment));
                }
                $company->pan_gst_attachment = $imageName;
            }

            $company->save(); */

            /* $admin_email = DB::table('settings')
            ->select('value')
                ->where('key', 'admin_email')
                ->pluck('value')
                ->first();
            Mail::to($admin_email)
                ->send(
                    new CommonEmail([
                        'subject' => 'Email Verification from Janvi LGE',
                        'data' => [
                            'time' => date('Y-m-d H:i:s'),
                            'link' => url("/admin/customers/edit/{$customer->customer_id}")
                        ],
                        'view' => 'emails.commonEmail'
                    ])
                ); */
            customer_activity('updated', $customer->name . ' has updated the profile', '/customer/my-account');
            return $this->successResponse('Profile updated successfully', ['personal' => $data]);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getCompanies(Request $request)
    {
        $customer = Auth::user();
        $company = DB::table('customer_company_details as ccd')
            ->join('country as ctr', 'ccd.refCountry_id', '=', 'ctr.country_id')
            ->join('state as s', 'ccd.refState_id', '=', 's.state_id')
            ->join('city as ct', 'ccd.refCity_id', '=', 'ct.city_id')
            ->select('ccd.customer_company_id', 'ccd.refCustomer_id', 'ccd.name', 'ccd.office_no', 'ccd.official_email', 'ccd.refDesignation_id', 'ccd.designation_name', 'ccd.office_address', 'ccd.pincode', 'ccd.pan_gst_no', 'ccd.pan_gst_attachment', 'ctr.name as country_name', 's.name as state_name', 'ct.name as city_name', 'ccd.refCountry_id', 'ccd.refState_id', 'ccd.refCity_id')
            ->where('ccd.refCustomer_id', $customer->customer_id)
            ->orderBy('ccd.customer_company_id', 'asc')
            ->get();
        foreach ($company as $v) {
            $v->pan_gst_attachment = '/storage/user_files/'.$v->pan_gst_attachment;
        }

        $data = ['company' => $company];

        return $this->successResponse('Success', $data);
    }

    public function addUpdateCompany(Request $request)
    {
        try {
            $rules = [
                'customer_company_id' => ['nullable', 'integer'],
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
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $customer = Auth::user();
            if ($request->customer_company_id) {
                $company = CustomerCompanyDetail::where('refCustomer_id', $customer->customer_id)
                    ->where('customer_company_id', $request->customer_company_id)
                    ->first();
                if (empty($company)) {
                    return $this->errorResponse('Not a valid company');
                }
                $msg = 'Address updated successfully';
            } else {
                $msg = 'Address added successfully';
                $company = new CustomerCompanyDetail;
                $company->refCustomer_id = $customer->customer_id;
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
            $company->refDesignation_id = 1;
            $company->designation_name = 'owner';
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

            if ($request->customer_company_id) {
                customer_activity('updated', $customer->name . ' has updated company (' . $company->name . ')', '/customer/my-account');
            } else {
                customer_activity('inserted', $customer->name . ' has added new company (' . $company->name . ')', '/customer/my-account');
            }

            /* $admin_email = DB::table('settings')
            ->select('value')
                ->where('key', 'admin_email')
                ->pluck('value')
                ->first();
            Mail::to($admin_email)
                ->send(
                    new CommonEmail([
                        'subject' => 'Email Verification from Janvi LGE',
                        'data' => [
                            'time' => date('Y-m-d H:i:s'),
                            'link' => url("/admin/customers/edit/{$customer->customer_id}")
                        ],
                        'view' => 'emails.commonEmail'
                    ])
                ); */

            return $this->successResponse($msg, ['id' => $company->customer_company_id]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteCompany(Request $request)
    {
        try {
            $rules = [
                'customer_company_id' => ['required', 'integer']
            ];

            $message = [
                'customer_company_id.required' => 'Not a valid request',
                'customer_company_id.integer' => 'Not a valid request'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $exists = $this->getCompanies($request);
            if (count($exists->original['data']['company']) == 1) {
                return $this->errorResponse('You cannot delete your last address...!');
            }
            $customer = Auth::user();
            $company = CustomerCompanyDetail::where('refCustomer_id', $customer->customer_id)
                ->where('customer_company_id', $request->customer_company_id)
                ->first();

            if ($company) {
                if ($company->pan_gst_attachment) {
                    unlink(base_path('/storage/app/public/user_files/' . $company->pan_gst_attachment));
                }
                $company->delete();
                return $this->successResponse('Address deleted successfully');
            } else {
                return $this->errorResponse('You are not authorized');
            }

            /* $admin_email = DB::table('settings')
            ->select('value')
                ->where('key', 'admin_email')
                ->pluck('value')
                ->first();
            Mail::to($admin_email)
                ->send(
                    new CommonEmail([
                        'subject' => 'Email Verification from Janvi LGE',
                        'data' => [
                            'time' => date('Y-m-d H:i:s'),
                            'link' => url("/admin/customers/edit/{$customer->customer_id}")
                        ],
                        'view' => 'emails.commonEmail'
                    ])
                ); */
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
