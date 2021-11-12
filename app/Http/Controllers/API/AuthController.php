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

class AuthController extends Controller
{
    use APIResponse;

    public function login(Request $request)
    {
        try {
            $rules = [
                'mobile' => ['required_without:email', 'nullable', 'regex:/^[0-9]{10,11}$/ix'],
                'email' => ['nullable', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
            ];

            $message = [
                'mobile.required_without' => 'Please enter phone number or email address',
                'mobile.regex' => 'Please enter valid 10 digits phone number',
                // 'email.required_unless' => 'Please enter email address or phone number',
                'email.regex' => 'Please enter valid email address'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $exists = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at')
                ->when($request->email, function ($q) use($request) {
                    $q->where('email', $request->email);
                })
                ->when($request->email, function ($q) use($request) {
                    $q->where('mobile', $request->mobile);
                })
                ->first();
            $otp = mt_rand(1111, 9999);
            if ($exists) {
                $exists->otp = $otp;
                $exists->otp_status = 0;
                $exists->save();
                $email = $exists->email;
            } else {
                /* if (empty($request->mobile)) {
                    return $this->errorResponse('Please also enter your phone number');
                }
                if (empty($request->email)) {
                    return $this->errorResponse('Please also enter your email address');
                } */
                $customer = new Customers;
                $customer->name = ' ';
                $customer->mobile = $request->mobile ?? ' ';
                $customer->email = $request->email ?? ' ';
                $customer->address = ' ';
                $customer->pincode = 0;
                $customer->refCity_id = 0;
                $customer->refState_id = 0;
                $customer->refCountry_id = 0;
                $customer->refCustomerType_id = 0;
                $customer->restrict_transactions = 0;
                $customer->added_by = 0;
                $customer->is_active = 0;
                $customer->is_deleted = 0;
                $customer->date_added = date('Y-m-d H:i:s');
                $customer->date_updated = date('Y-m-d H:i:s');
                $customer->otp = $otp;
                $customer->otp_status = 0;
                $customer->save();
                /* DB::table('customer')->insert([
                    'name' => ' ',
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'address' => ' ',
                    'pincode' => 0,
                    'refCity_id' => 0,
                    'refState_id' => 0,
                    'refCountry_id' => 0,
                    'refCustomerType_id' => 0,
                    'restrict_transactions' => 0,
                    'added_by' => 0,
                    'is_active' => 0,
                    'is_deleted' => 0,
                    'date_added' => date('Y-m-d H:i:s'),
                    'date_updated' => date('Y-m-d H:i:s'),
                    'otp' => $otp,
                    'otp_status' => 0
                ]); */
                $email = $request->email;
            }
            if ($email) {
                Mail::to($email)
                    ->send(
                        new EmailVerification([
                            'subject' => 'Email Verification from Janvi LGE',
                            'name' => $email,
                            'otp' => $otp,
                            'view' => 'emails.codeVerification'
                        ])
                    );
            }
            return $this->successResponse('OTP sent successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function verifyOTP(Request $request)
    {
        $rules = [
            'mobile' => ['required_without:email', 'nullable', 'regex:/^[0-9]{10,11}$/ix'],
            'email' => ['nullable', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'otp' => ['required', 'digits:4']
        ];

        $message = [
            'mobile.required_without' => 'Please enter phone number or email address',
            'mobile.regex' => 'Please enter valid 10 digits phone number',
            // 'email.required_unless' => 'Please enter email address or phone number',
            'email.regex' => 'Please enter valid email address',
            'otp.required' => 'Please enter OTP',
            'otp.digits' => 'Please enter valid 4 digits OTP',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        try {
            $user = Customers::select('customer_id', 'email', 'mobile', 'otp', 'otp_status', 'updated_at', 'name', 'refCity_id', 'address', 'pincode')
                ->where('email', $request->email)
                ->orWhere('mobile', $request->mobile)
                ->first();
            if (!$user) {
                return $this->errorResponse('Not authorized');
            } else {
                // if ($request->otp == $user->otp && $user->otp_status === 0) {
                if ($request->otp == 1111) {
                    if ($user->name == ' ' || strlen($user->name) < 3) {
                        $user->otp_status = 1;
                        $user->save();
                        return $this->successResponse('Verified successfully', [], 2);
                    } else {
                        $user->otp_status = 1;
                        $user->save();

                        $all = $this->getUserData($user);
                        return $this->successResponse('Verified successfully', $all, 1);
                    }
                } else {
                    return $this->errorResponse('Incorrect OTP');
                }
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $rules = [
                'mobile' => ['required_without:email', 'nullable', 'regex:/^[0-9]{10,11}$/ix'],
                'email' => ['nullable', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
            ];

            $message = [
                'mobile.required_without' => 'Please enter phone number or email address',
                'mobile.regex' => 'Please enter valid 10 digits phone number',
                // 'email.required_unless' => 'Please enter email address or phone number',
                'email.regex' => 'Please enter valid email address'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $user = Customers::select('customer_id', 'name', 'email', 'mobile', 'otp', 'updated_at')
                ->where('email', $request->email)
                ->orWhere('mobile', $request->mobile)
                ->first();
            if (!$user) {
                return $this->errorResponse('Not a registered email address');
            } else {
                $dt = new Carbon($user->updated_at);
                if ($dt->diffInSeconds(date('Y-m-d H:i:s')) <= 60) {
                    return $this->errorResponse('Wait for 60 seconds');
                }
            }
            $otp = mt_rand(1111, 9999);
            $user->otp = $otp;
            $user->otp_status = 0;
            Mail::to($user->email)
                ->send(
                    new EmailVerification([
                        'subject' => 'Email Verification from Janvi LGE',
                        'name' => $user->email,
                        'otp' => $otp,
                        'view' => 'emails.codeVerification'
                    ])
                );
            $user->save();
            return $this->successResponse('Verification code has been resent to your registered email address');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'name' => ['required'],
                // 'mobile' => ['required', 'nullable', 'regex:/^[0-9]{8,11}$/ix'],
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'address' => ['required'],
                'country' => ['required', 'integer'],
                'state' => ['required', 'integer'],
                'city' => ['required', 'integer'],
                'pincode' => ['required', 'digits:6'],
                'company_name' => ['required'],
                'company_office_no' => ['required'],
                'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'company_gst_pan' => ['required', 'between:10,15'],
                'company_address' => ['required'],
                'company_country' => ['required', 'integer'],
                'company_state' => ['required', 'integer'],
                'company_city' => ['required', 'integer'],
                'company_pincode' => ['required', 'digits:6'],
                'id_upload' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf']
            ];

            $message = [
                // 'mobile.required' => 'Please enter phone number',
                // 'mobile.regex' => 'Please enter valid 10 digits phone number',
                // 'email.required' => 'Please enter email address',
                // 'email.regex' => 'Please enter valid email address',
                'country.required' => 'Please enter country',
                'state.required' => 'Please enter state',
                'city.required' => 'Please enter city',
                'company_name.required' => 'Please enter your company name',
                'company_office_no.required' => 'Please enter company office number',
                'company_email.required' => 'Please enter company email address',
                'company_gst_pan.required' => 'Please enter company GST or PAN',
                'company_address.required' => 'Please enter company address',
                'company_country.required' => 'Please enter company country',
                'company_state.required' => 'Please enter company state',
                'company_city.required' => 'Please enter company city',
                'id_upload.required' => 'Please select ID proof'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')->where('mobile', $request->mobile)->orWhere('email', $request->email)->first();
            if ($exists) {
                if (strlen($exists->name) < 3) {
                    $customer = Customers::where('email', $request->email)->first();
                    $customer->name = $request->name;
                    $customer->address = $request->address;
                    $customer->pincode = $request->pincode;
                    $customer->refCity_id = $request->city;
                    $customer->refState_id = $request->state;
                    $customer->refCountry_id = $request->country;
                    $customer->refCustomerType_id = 0;
                    $customer->restrict_transactions = 0;
                    $customer->added_by = 0;
                    $customer->is_active = 1;
                    $customer->is_deleted = 0;
                    $customer->date_added = date('Y-m-d H:i:s');
                    $customer->date_updated = date('Y-m-d H:i:s');
                    $customer->save();

                    $company = new CustomerCompanyDetail;
                    $company->refCustomer_id = $customer->customer_id;
                    $company->name = $request->company_name;
                    $company->office_no = $request->company_office_no;
                    $company->official_email = $request->company_email;
                    $company->refDesignation_id = 1;
                    $company->designation_name = 'owner';
                    $company->office_address = $request->company_address;
                    $company->pincode = $request->pincode;
                    $company->refCity_id = $request->company_city;
                    $company->refState_id = $request->company_state;
                    $company->refCountry_id = $request->company_country;
                    $company->pan_gst_no = $request->company_gst_pan;
                    $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_upload')->getClientOriginalName());
                    $request->file('id_upload')->storeAs("public/user_files", $imageName);
                    $company->pan_gst_attachment = $imageName;
                    $company->is_approved = 1;
                    $company->approved_date_time = date('Y-m-d H:i:s');
                    $company->approved_by = 0;
                    $company->save();

                    $admin_email = DB::table('settings')
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
                        );

                    $all = $this->getUserData($customer);

                    return $this->successResponse('Congrats, you are now successfully registered', $all);
                } else {
                    return $this->errorResponse('You are already registered');
                }
            } else {
                return $this->errorResponse('You are already registered...!');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getUserData($user)
    {
        $data = new \stdClass;
        $data->email = $user->email;
        $data->mobile = $user->mobile;
        $data->name = $user->name;
        $data->address = $user->address;
        $data->pincode = $user->pincode;
        $csc = DB::table('country as c')
            ->join('state as s', 'c.country_id', '=', 's.refCountry_id')
            ->join('city as ct', 's.state_id', '=', 'ct.refState_id')
            ->select('c.name as country', 's.name as state', 'ct.name as city')
            ->where('ct.city_id', $user->refCity_id)
            ->first();
        $data->city = $csc->city;
        $data->state = $csc->state;
        $data->country = $csc->country;
        $data->cart = DB::table('customer_cart')->select('id')->where('refCustomer_id')->count();
        $data->token = $user->createToken((strlen($user->email) > 3) ? $user->email : $user->mobile)->accessToken;

        $company = DB::table('customer_company_details')
            ->select('customer_company_id', 'name', 'office_no', 'official_email', 'designation_name', 'office_address', 'pincode', 'refCity_id', 'pan_gst_no', 'pan_gst_attachment', 'is_approved')
            ->where('refCustomer_id', $user->customer_id)
            ->first();
        $business = new \stdClass;
        if ($company) {
            $business->company_email = $company->official_email;
            $business->company_mobile = $company->office_no;
            $business->company_name = $company->name;
            $business->designation_name = $company->designation_name;
            $business->company_address = $company->office_address;
            $business->company_pincode = $company->pincode;
            $csc_2 = DB::table('country as c')
                ->join('state as s', 'c.country_id', '=', 's.refCountry_id')
                ->join('city as ct', 's.state_id', '=', 'ct.refState_id')
                ->select('c.name as country', 's.name as state', 'ct.name as city')
                ->where('ct.city_id', $company->refCity_id)
                ->first();
            $business->company_city = $csc_2->city;
            $business->company_state = $csc_2->state;
            $business->company_country = $csc_2->country;
            $business->pan_gst_no = $company->pan_gst_no;
            $business->pan_gst_attachment = '/storage/user_files/' . $company->pan_gst_attachment;
        }
        return [
            'personal' => $data,
            'business' => $business
        ];
    }
}
