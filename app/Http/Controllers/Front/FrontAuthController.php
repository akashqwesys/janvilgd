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
use App\Mail\CommonEmail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class FrontAuthController extends Controller
{
    use APIResponse;

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/customer/dashboard');
        }
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
                    ->when($request->email, function ($q) use ($request) {
                        $q->where('email', $request->email);
                    })
                    ->when($request->mobile, function ($q) use ($request) {
                        $q->where('mobile', $request->mobile);
                    })
                    ->first();
                $otp = mt_rand(1111, 9999);
                if ($exists) {
                    $exists->otp = $otp;
                    $exists->otp_status = 0;
                    $exists->save();
                    $email = $exists->email;
                }
                else {
                    /* if (empty($request->mobile)) {
                        return response()->json(['error' => 1, 'message' => 'Please also enter your phone number']);
                    }
                    if (empty($request->email)) {
                        return response()->json(['error' => 1, 'message' => 'Please also enter your email address']);
                    } */
                    /* $customer = new Customers;
                    $customer->name = ' ';
                    $customer->mobile = $request->mobile;
                    $customer->email = $request->email;
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
                    $customer->save(); */
                    DB::table('customer')->insert([
                        'name' => ' ',
                        'mobile' => $request->mobile ?? ' ',
                        'email' => $request->email ?? ' ',
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
                        'otp_status' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $email = $request->email;
                }
                if ($email) {
                    /* Mail::to($email)
                    ->send(
                        new EmailVerification([
                            'subject' => 'Email Verification from Janvi LGE',
                            'name' => $email,
                            'otp' => $otp,
                            'view' => 'emails.codeVerification'
                        ])
                    ); */
                    send_email($email, 'Email Verification from Janvi LGE');
                }
                $em_token = !empty(trim($request->email)) ? $request->email : $request->mobile;
                return response()->json(['success' => 1, 'message' => 'Success', 'url' => '/customer/verify/' . Crypt::encryptString($em_token)]);
            }
            catch (\Exception $e) {
                return response()->json(['error' => 1, 'message' => $e->getMessage()]);
            }
        }
        else {
            if (Auth::check())
                return redirect('/customer/dashboard');
            else
                return view('front.login');
        }
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect('/customer/dashboard');
        }
        if ($request->ajax()) {
            try {
                $rules = [
                    'name' => ['required'],
                    // 'mobile' => ['required', 'nullable', 'regex:/^[0-9]{8,11}$/ix'],
                    // 'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'address' => ['required'],
                    'country' => ['required'],
                    'state' => ['required'],
                    'city' => ['required'],
                    'pincode' => ['required', 'digits:6'],
                    'company_name' => ['required'],
                    'company_office_no' => ['required'],
                    'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'company_gst_pan' => ['required', 'between:10,15'],
                    'company_address' => ['required'],
                    'company_country' => ['required'],
                    'company_state' => ['required'],
                    'company_city' => ['required'],
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
                    return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
                }

                $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')
                    ->when($request->email, function ($q) use ($request) {
                        $q->where('email', $request->email);
                    })
                    ->when($request->mobile, function ($q) use ($request) {
                        $q->where('mobile', $request->mobile);
                    })
                    ->first();
                if ($exists) {
                    if (strlen($exists->name) < 3) {
                        $customer = Customers::where('customer_id', $exists->customer_id)->first();
                        $customer->name = $request->name;
                        // $customer->mobile = $request->mobile;
                        // $customer->email = $request->email;
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
                                'subject' => 'New User on Janvi LGE',
                                'data' => [
                                    'time' => date('Y-m-d H:i:s'),
                                    'link' => url("/admin/customers/edit/{$customer->customer_id}")
                                ],
                                'view' => 'emails.commonEmail'
                            ])
                        );

                        return response()->json(['success' => 1, 'message' => 'Congrats, you are now successfully registered', 'url' => '/customer/authenticate/' . encrypt($exists->email, false)]);
                    } else {
                        return response()->json(['error' => 1, 'message' => 'You are already registered', 'url' => '/']);
                    }
                } else {
                    return response()->json(['error' => 1, 'message' => 'Oops, something went wrong...!']);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 1, 'message' => $e->getMessage()]);
            }
        } else {
            if (empty($request->token)) {
                return redirect('/');
            } else {
                try {
                    $token = explode('---', Crypt::decryptString($request->token));
                    $exists = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at')
                    ->when($token[0], function ($q) use ($token) {
                        $q->where('email', $token[0]);
                    })
                    ->when($token[1], function ($q) use ($token) {
                        $q->where('mobile', $token[1]);
                    })
                    ->first();
                    if (!$exists) {
                        return redirect('/');
                    } else {
                        if (strlen($exists->name) >= 3) {
                            return redirect('/');
                        }
                        $email = $token[0];
                        $mobile = $token[1];
                        $city = DB::table('city')->select('city_id', 'name')->where('is_active', 1)->where('is_deleted', 0)->get();
                        $state = DB::table('state')->select('state_id', 'name')->where('is_active', 1)->where('is_deleted', 0)->get();
                        $country = DB::table('country')->select('country_id', 'name')->where('is_active', 1)->where('is_deleted', 0)->get();
                        return view('front.register', compact('email', 'mobile', 'city', 'state', 'country'));
                    }
                } catch (\Throwable $th) {
                    return redirect('/');
                }
            }
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $rules = [
                'token' => ['required'],
            ];

            $message = [];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            $email = decrypt($request->token, false);
            $user = Customers::select('customer_id', 'name', 'email', 'mobile', 'otp', 'created_at', 'updated_at', 'otp_status')
                ->when($request->email, function ($q) use ($email) {
                        $q->where('email', $email);
                    })
                    ->when($request->mobile, function ($q) use ($email) {
                        $q->where('mobile', $email);
                    })
                ->first();
            if (!$user) {
                return response()->json(['error' => 1, 'message' => 'Not a registered email address']);
            } else {
                $dt = new Carbon($user->updated_at);
                if ($dt->diffInSeconds(date('Y-m-d H:i:s')) <= 60) {
                    return response()->json(['error' => 1, 'message' => 'Wait for 60 seconds']);
                }
            }
            $otp = mt_rand(1111, 9999);
            $user->otp = $otp;
            $user->otp_status = 0;
            if ($user->email) {
                Mail::to($user->email)
                ->send(
                    new EmailVerification([
                        'subject' => 'Email Verification from Janvi LGE',
                        'name' => $user->email,
                        'otp' => $otp,
                        'view' => 'emails.codeVerification'
                    ])
                );
            }
            $user->save();
            return response()->json(['success' => 1, 'message' => 'Verification code has been resent to your registered email address']);
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
        }
    }

    public function otpVerify(Request $request)
    {
        if (Auth::check()) {
            return redirect('/customer/dashboard');
        }
        if ($request->isMethod('GET')) {
            if (empty($request->token)) {
                return redirect('/customer/login');
            }
            return view('front.otp_verification', compact('request'));
        } else {
            $rules = [
                'token' => ['required'],
                'otp' => ['required', 'digits:4']
            ];

            $message = [];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            try {
                $user = Customers::select('customer_id', 'email', 'mobile', 'otp', 'otp_status', 'updated_at', 'name')
                    ->where('email', Crypt::decryptString($request->token))
                    ->orWhere('mobile', Crypt::decryptString($request->token))
                    ->first();
                if (!$user) {
                    return response()->json(['error' => 1, 'message' => 'Not authorized', 'url' => '/customer/login']);
                } else {
                    if ($request->otp == $user->otp && $user->otp_status === 0) {
                        if ($user->name == ' ' || strlen($user->name) < 3) {
                            /* $user->otp_status = 1;
                            $user->save(); */
                            return response()->json(['success' => 1, 'message' => 'Verified successfully', 'url' => '/customer/signup/' . Crypt::encryptString($user->email . '---' . $user->mobile)]);
                        } else {
                            $user->otp_status = 1;
                            $user->save();
                            return response()->json(['success' => 1, 'message' => 'Verified successfully', 'url' => '/customer/authenticate/' . encrypt($user->email, false)]);
                        }
                    } else {
                        return response()->json(['error' => 1, 'message' => 'Incorrect OTP']);
                    }
                }
            } catch (\Throwable $th) {
                return redirect('/');
            }
        }
    }

    public function auth_customer(Request $request)
    {
        $user = DB::table('customer')->select('customer_id')->where('email', decrypt($request->token, false))->first();
        Auth::loginUsingId($user->customer_id);
        return redirect('/customer/dashboard');
    }

    public function customer_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
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
