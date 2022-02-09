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
use Illuminate\Support\Facades\Hash;
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
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'password' => ['required', 'between:6,15']
            ];

            $message = [
                'email.required' => 'Please enter email address',
                'email.regex' => 'Please enter valid email address',
                'password.required' => 'Please enter password'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Customers::select('customer_id', 'email', 'mobile', 'otp', 'otp_status', 'updated_at', 'name', 'refCity_id', 'address', 'pincode')
                    ->where('email', strtolower($request->email))
                    ->first();
                $all = $this->getUserData($user);
                return $this->successResponse('Logged in successfully', $all, 1);
            } else {
                return $this->errorResponse('Invalid Credentials');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'name' => ['required'],
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'password' => ['required', 'between:6,15'],
                'confirm_password' => ['required', 'same:password'],
                'country_code' => ['required'],
                'mobile' => ['required', 'regex:/^[0-9]{8,11}$/ix'],
                'address' => ['required'],
                'country' => ['required', 'integer', 'exists:country,country_id'],
                'state' => ['required', 'integer', 'exists:state,state_id'],
                'city' => ['required', 'integer', 'exists:city,city_id'],
                'pincode' => ['nullable', 'integer'],
                'company_name' => ['required'],
                'company_country_code' => ['required'],
                'company_office_no' => ['required', 'regex:/^[0-9]{8,11}$/ix'],
                'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                // 1 - VAT, 2 - TIN, 3 - PAN, 4 - OTHERS
                // 'company_id_type' => ['required', Rule::in([1, 2, 3, 4])],
                'company_gst_pan' => ['required', 'between:5,15'],
                'company_address' => ['required'],
                'company_country' => ['required', 'integer', 'exists:country,country_id'],
                'company_state' => ['required', 'integer', 'exists:state,state_id'],
                'company_city' => ['required', 'integer', 'exists:city,city_id'],
                'company_pincode' => ['required', 'integer'],
                'id_upload' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf']
            ];

            $message = [
                'email.required' => 'Please enter email address',
                'email.regex' => 'Please enter valid email address',
                'mobile.required' => 'Please enter phone number',
                'mobile.regex' => 'Please enter valid 10 digits phone number',
                'password.required' => 'Please enter password',
                'confirm_password.same' => 'Those password didn\'t match. Try again',
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

            $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')
                ->where('email', strtolower($request->email))
                ->first();
            if ($exists) {
                return $this->errorResponse('Email is already registered, Try with new email');
            } else {
                $customer = new Customers;
                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->password = Hash::make($request->password);
                $customer->mobile = $request->mobile;
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
                $customer->otp = 0;
                $customer->otp_status = 0;
                $customer->verified_status = 0;

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

                $customer->save();

                $company = new CustomerCompanyDetail;
                $company->refCustomer_id = $customer->customer_id;
                $company->name = $request->company_name;
                $company->office_no = $request->company_office_no;
                $company->official_email = strtolower($request->company_email);
                $company->refDesignation_id = 1;
                $company->designation_name = 'owner';
                $company->office_address = $request->company_address;
                $company->pincode = $request->company_pincode;
                $company->refCity_id = $request->company_city;
                $company->refState_id = $request->company_state;
                $company->refCountry_id = $request->company_country;
                // $company->company_id_type = $request->company_id_type;
                $company->pan_gst_no = $request->company_gst_pan;
                if ($request->hasFile('id_upload')) {
                    $imageName = time() . '_' . preg_replace('/\s+/', '_', $request->file('id_upload')->getClientOriginalName());
                    $request->file('id_upload')->storeAs("public/user_files", $imageName);
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
                            'subject' => 'New User in Janvi LGD',
                            'data' => [
                                'time' => date('Y-m-d H:i:s'),
                                'link' => url("/admin/customers/edit/{$customer->customer_id}")
                            ],
                            'view' => 'emails.commonEmail'
                        ])
                    );

                $all = $this->getUserData($customer);
                return $this->successResponse('Congrats, you are now successfully registered', $all);

            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $rules = [
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
            ];

            $message = [
                'email.required' => 'Please enter email address',
                'email.regex' => 'Please enter valid email address'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }

            $user = Customers::select('customer_id', 'name', 'email', 'mobile', 'otp', 'updated_at', 'otp_status')
                ->where('email', strtolower($request->email))
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
            if (!empty(trim($user->email))) {
                Mail::to($user->email)
                    ->send(
                        new EmailVerification([
                            'subject' => 'Email Verification from Janvi LGD',
                            'name' => $user->email,
                            'otp' => $otp,
                            'link' => null,
                            'view' => 'emails.codeVerification'
                        ])
                    );
            }
            $user->save();
            return $this->successResponse('Verification code has been resent to your registered email address');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function forgotPassword(Request $request)
    {
        $rules = [
            'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
        ];

        $message = [
            'email.required' => 'Please enter email address',
            'email.regex' => 'Please enter valid email address',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $email = trim(strtolower($request['email']));
        $user = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at')
            ->where('email', $email)
            ->first();
        if ($user == null) {
            return $this->errorResponse('You have not registered with us yet');
        } else {
            $otp = mt_rand(1111, 9999);
            $user->otp = $otp;
            $user->otp_status = 0;
            $user->save();
            Mail::to($email)
            ->send(
                new EmailVerification([
                    'subject' => 'Email Verification from Janvi LGD',
                    'name' => $email,
                    'otp' => $otp,
                    'link' => null,
                    'view' => 'emails.codeVerification'
                    ])
                );
            return $this->successResponse('OTP has been sent to your registered email address');
        }
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'step' => 'required|numeric',
            'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'otp' => 'required_if:step,1|nullable|digits:4',
            'password' => 'required_if:step,2|between:6,15',
            'confirm_password' => 'required_with:password|same:password'
        ];

        $message = [
            'step.numeric' => 'Enter valid step',
            'email.required' => 'Email is required',
            'email.regex' => 'Enter valid email address',
            'otp.required_if' => 'Enter valid 4 digits OTP',
            'otp.numeric' => 'Enter valid 4 digits OTP',
            'otp.digits' => 'Enter valid 4 digits OTP',
            'password.required_if' => 'Password is required'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $user = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at', 'password')
            ->where('email', $request['email'])
            ->first();
        if ($user == null) {
            return $this->errorResponse('You have not registered with us yet');
        } elseif ($request['step'] == 1 && $user->otp_status == 0) {
            if ($request['otp'] == $user->otp) {
                $user->otp_status = 1;
                $user->save();
                return $this->successResponse('OTP verified successfully');
            } else {
                return $this->errorResponse('Incorrect OTP');
            }
        } elseif ($request['step'] == 2 && $user->otp_status == 1) {
            $user->password = Hash::make($request['password']);
            $user->save();
            return $this->successResponse('Password updated successfully');
        } else {
            return $this->errorResponse('Invalid Call');
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
        $data->token = $user->createToken($user->email)->accessToken;

        $company = DB::table('customer_company_details')
            ->select('customer_company_id', 'name', 'office_no', 'official_email', 'designation_name', 'office_address', 'pincode', 'refCity_id', 'pan_gst_no', 'pan_gst_attachment')
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

    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return $this->successResponse('Logged out successfully');
    }
}
