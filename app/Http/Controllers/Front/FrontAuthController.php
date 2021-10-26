<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use App\Mail\EmailVerification;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class FrontAuthController extends Controller
{
    use APIResponse;

    public function login(Request $request)
    {
        if ($request->ajax()) {
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
                    return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
                }

                $exists = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at')
                    ->where('mobile', $request->mobile)
                    ->orWhere('email', $request->email)
                    ->first();
                $otp = mt_rand(1111, 9999);
                if ($exists) {
                    $exists->otp = $otp;
                    $exists->otp_status = 0;
                    $exists->save();
                    $email = $exists->email;
                }
                else {
                    $customer = new Customers;
                    $customer->name = '';
                    $customer->mobile = $request->mobile;
                    $customer->email = $request->email;
                    $customer->address = '';
                    $customer->pincode = '';
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
                    $email = $customer->email;
                }
                Mail::to($email)
                ->send(
                    new EmailVerification([
                        'name' => $email,
                        'otp' => $otp,
                        'view' => 'emails.codeVerification'
                    ])
                );
                return response()->json(['success' => 1, 'message' => 'Success', 'url' => '/c/verify/' . Crypt::encryptString($email)]);
            }
            catch (\Exception $e) {
                return response()->json(['error' => 1, 'message' => $e->getMessage()]);
            }
        }
        else {
            return view('front.login');
        }
    }

    public function register(Request $request)
    {
        if ($request->ajax()) {
            dd($request->all());
            try {
                $rules = [
                    'name' => ['required'],
                    'mobile' => ['required', 'nullable', 'regex:/^[0-9]{8,11}$/ix'],
                    'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'address' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'city' => ['required'],
                    'company_name' => ['required'],
                    'company_office_no' => ['required'],
                    'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'company_gst_pan' => ['required', 'between:10,15'],
                    'company_address' => ['required'],
                    'company_country' => ['required'],
                    'company_state' => ['required'],
                    'company_city' => ['required'],
                    'id_upload' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf']
                ];

                $message = [
                    'mobile.required' => 'Please enter phone number',
                    'mobile.regex' => 'Please enter valid 10 digits phone number',
                    'email.required' => 'Please enter email address',
                    'email.regex' => 'Please enter valid email address',
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
                    return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
                }

                $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')->where('mobile', $request->mobile)->orWhere('email', $request->email)->first();
                if ($exists) {
                    if ($request->mobile == $exists->mobile) {
                        return response()->json(['error' => 1, 'message' => 'Please register with new mobile number']);
                    }
                    else {
                        return response()->json(['error' => 1, 'message' => 'Please register with new email address']);
                    }
                } else {
                    $customer = new Customers;
                    $customer->name = $request->name;
                    $customer->mobile = $request->mobile;
                    $customer->email = $request->email;
                    $customer->address = $request->address;
                    // $customer->pincode = $request->pincode;
                    $customer->refCity_id = $request->city;
                    $customer->refState_id = $request->state;
                    $customer->refCountry_id = $request->country;
                    // $customer->refCustomerType_id = $request->refCustomerType_id;
                    // $customer->restrict_transactions = $request->restrict_transactions;
                    $customer->added_by = 0;
                    $customer->is_active = 1;
                    $customer->is_deleted = 0;
                    $customer->date_added = date('Y-m-d H:i:s');
                    $customer->date_updated = date('Y-m-d H:i:s');
                    $customer->save();

                    $company = new CustomerCompanyDetail;
                    $company->refCustomer_id = $customer->id;
                    $company->name = $request->company_name;
                    $company->office_no = $request->company_office_no;
                    $company->official_email = $request->company_email;
                    // $company->refDesignation_id = $request->refDesignation_id;
                    // $company->designation_name = $request->designation_name;
                    $company->office_address = $request->company_address;
                    // $company->pincode = $request->pincode;
                    $company->refCity_id = $request->company_city;
                    $company->refState_id = $request->company_state;
                    $company->refCountry_id = $request->company_country;
                    $company->pan_gst_no = $request->company_gst_pan;
                    // $company->pan_gst_attachment = $request->pan_gst_attachment;
                    // $company->is_approved = $request->is_approved;
                    $company->approved_date_time = date('Y-m-d H:i:s');
                    // $company->approved_by = $request->approved_by;
                    $company->save();

                    return response()->json(['success' => 1, 'message' => 'Congrats, you are now successfully registered']);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 1, 'message' => $e->getMessage()]);
            }
        } else {
            $city = DB::table('city')->select('city_id', 'name')->where('is_active', 1)->where('is_deleted', 0)->get();
            $state = DB::table('state')->select('state_id', 'name')->where('is_active', 1)->where('is_deleted', 0)->get();
            $country = DB::table('country')->select('country_id', 'name')->where('is_active', 1)->where('is_deleted', 0)->get();
            return view('front.register', compact('request', 'city', 'state', 'country'));
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $rules = [
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            ];

            $message = [
                'email.required' => 'Please enter email address',
                'email.regex' => 'Please enter valid email address',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $user = User::select('id', 'name', 'email', 'otp', 'updated_at')
                ->where('email', $request->email)
                ->first();
            if (!$user) {
                return $this->errorResponse('Not a registered email address');
            } else {
                $dt = new Carbon($user->updated_at);
                if ($dt->diffInSeconds(date('Y-m-d H:i:s')) <= 30) {
                    return $this->errorResponse('Wait for 30 seconds');
                }
                /*$dt1 = date_create($user->updated_at);
				$dt2 = date_create(date('Y-m-d H:i:s'));
				$interval = date_diff($dt1, $dt2);
    			if ($interval->format('%s') <= 30) {
    				return $this->errorResponse('Wait for 30 seconds');
    			}*/
            }
            $otp = mt_rand(1111, 9999);
            $user->otp = $otp;
            $user->otp_status = 0;
            Mail::to($request->email)
            ->send(
                new EmailVerification([
                    'name' => $request->email,
                    'otp' => $otp,
                    'view' => 'emails.codeVerification'
                ])
            );
            $user->update();
            return $this->successResponse('Verification code has been resent to your registered email address');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function otpVerify(Request $request)
    {
        if ($request->isMethod('GET')) {
            if (empty($request->token)) {
                return redirect('/c/login');
            }
        } else {
            $rules = [
                'token' => ['required'],
                'otp' => ['required', 'digits:4']
            ];

            $message = [];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all()[0]);
            }
            $user = Customers::select('customer_id', 'email', 'mobile', 'otp', 'updated_at')
                ->where('email', Crypt::decryptString($request->token))
                ->first();
            if (!$user) {
                return $this->errorResponse('Not authorized');
            } else {
                $dt = new Carbon($user->updated_at);
                if ($dt->diffInSeconds(date('Y-m-d H:i:s')) <= 30) {
                    return $this->errorResponse('Wait for 30 seconds');
                }
                /*$dt1 = date_create($user->updated_at);
                $dt2 = date_create(date('Y-m-d H:i:s'));
                $interval = date_diff($dt1, $dt2);
                if ($interval->format('%s') <= 30) {
                    return $this->errorResponse('Wait for 30 seconds');
                }*/
            }
            $otp = mt_rand(1111, 9999);
            $user->otp = $otp;
            $user->otp_status = 0;
            Mail::to($request->email)
                ->send(
                    new EmailVerification([
                        'name' => $request->email,
                        'otp' => $otp,
                        'view' => 'emails.codeVerification'
                    ])
                );
            $user->update();
            return $this->successResponse('Verification code has been resent to your registered email address');
        }
    }

    public function checkEmailMobile(Request $request)
    {
        try {
            if ($request->type == 2 && !preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $request->name)) {
                return response()->json(['error' => 1, 'message' => 'Please enter valid email address']);
            } else if ($request->type == 1 && !preg_match('/^[1-9]{1}[0-9]{9}$/ix', $request->name)) {
                return response()->json(['error' => 1, 'message' => 'Please enter valid 10 digits phone number']);
            }
            $field = $request->type == 2 ? 'email address' : 'mobile number';

            $exists = DB::table('customer')->select('customer_id')->where('mobile', $request->name)->orWhere('email', $request->name)->first();
            if ($exists) {
                return response()->json(['error' => 1, 'message' => 'Please register with new ' . $field]);
            } else {
                return response()->json(['success' => 1]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
        }
    }
}
