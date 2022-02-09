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
use Illuminate\Support\Facades\Hash;

class FrontAuthController extends Controller
{
    use APIResponse;

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/customer/search-diamonds/polish-diamonds');
        }
        if ($request->isMethod('post')) {
            try {
                $rules = [
                    'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'password' => ['required'/* , 'between:6,15' */]
                ];

                $message = [
                    'email.required' => 'Please enter email address',
                    'email.regex' => 'Please enter valid email address',
                    'password.required' => 'Please enter password'
                ];

                $validator = Validator::make($request->all(), $rules, $message);

                if ($validator->fails()) {
                    return back()->with('error', $validator->errors()->all()[0]);
                }

                $exists = DB::table('customer')
                    ->select('customer_id', 'email', 'verified_status', 'is_approved', 'is_active', 'password')
                    ->where('email', strtolower($request->email))
                    ->first();
                if ($exists && Hash::check($request->password, $exists->password)) {
                    if ($exists->verified_status === 0) {
                        return back()->with('error', 'Your account is not verified yet, please check your registered email inbox');
                    } else if ($exists->is_approved === 0) {
                        return back()->with('error', 'Your account is not approved yet. You will get an approval email when your account is approved');
                    } else if ($exists->is_active === 0) {
                        return back()->with('error', 'Your account is temporarily deactivated, please contact support team');
                    }
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                        return redirect('/customer/search-diamonds/polish-diamonds');
                    }
                } else {
                    return back()->with('error', 'Your email address and password do not match. Please try again.');
                }
            }
            catch (\Exception $e) {
                return response()->json(['error' => 1, 'message' => $e->getMessage()]);
            }
        }
        else {
            return view('front.auth.login');
        }
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect('/customer/search-diamonds/polish-diamonds');
        }
        if ($request->isMethod('post')) {
            try {
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'password' => ['required', 'between:6,15'],
                    'confirm_password' => ['required', 'same:password'],
                    'mobile' => ['required', 'regex:/^[0-9]{8,11}$/ix'],
                    'country_code' => ['required'],
                    'address' => ['required'],
                    // 'country' => ['required'],
                    'state' => ['required'],
                    'city' => ['required'],
                    'pincode' => ['required'],
                    'company_name' => ['required'],
                    'company_country_code' => ['required'],
                    'company_office_no' => ['required', 'regex:/^[0-9]{8,11}$/ix'],
                    'company_email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                    'company_gst_pan' => ['required', 'between:5,15'],
                    'company_address' => ['required'],
                    // 'company_country' => ['required'],
                    'company_state' => ['required'],
                    'company_city' => ['required'],
                    'company_pincode' => ['required'],
                    'id_upload' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf']
                ];

                $message = [
                    // 'mobile.required' => 'Please enter phone number',
                    'mobile.regex' => 'Please enter valid 10 digits phone number',
                    'email.required' => 'Please enter email address',
                    'email.regex' => 'Please enter valid email address',
                    'password.required' => 'Please enter password',
                    'confirm_password.same' => 'Those password didn\'t match. Try again',
                    'country.required' => 'Please enter country',
                    'state.required' => 'Please enter state',
                    'city.required' => 'Please enter city',
                    'company_name.required' => 'Please enter your company name',
                    'company_office_no.required' => 'Please enter company office number',
                    'company_email.required' => 'Please enter company email address',
                    'company_gst_pan.required' => 'Please enter company VAT or TIN or GST or PAN',
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
                    ->where('email', strtolower($request->email))
                    ->first();
                if ($exists) {
                    return response()->json(['error' => 1, 'message' => 'Email is already registered, Try with new email']);
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
                    $customer->refCountry_id = $request->country ?? $request->country_code;
                    $customer->refCustomerType_id = 1;
                    $customer->restrict_transactions = 0;
                    $customer->added_by = 0;
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
                    $company->office_no = $request->company_office_no;
                    $company->official_email = strtolower($request->company_email);
                    $company->refDesignation_id = 1;
                    $company->designation_name = 'owner';
                    $company->office_address = $request->company_address;
                    $company->pincode = $request->company_pincode;
                    $company->refCity_id = $request->company_city;
                    $company->refState_id = $request->company_state;
                    $company->refCountry_id = $request->company_country_code;
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

                    return response()->json(['success' => 1, 'message' => '<div class="alert alert-success"> <b> <div class="text-center">Congrats, you are on the way of successful registration. We have sent you an verification email. Please go through it to complete the process from your side.</div> </b> </div> <div class="mt-4 text-center"><a href="/" class="btn btn-primary">Back to Home</a></div>']);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 1, 'message' => $e->getMessage()]);
            }
        } else {
            $country = DB::table('country')->select('country_id', 'name', 'country_code')->where('is_active', 1)->where('is_deleted', 0)->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')->get();
            return view('front.auth.register', compact('country'));
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $rules = [
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            ];

            $message = [
                'email.required' => 'Email is required',
                'email.regex' => 'Enter valid email address'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            $user = Customers::select('customer_id', 'name', 'email', 'mobile', 'otp', 'created_at', 'updated_at', 'otp_status')
                ->where('email', $request->email)
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
                        'subject' => 'Email Verification from Janvi LGD',
                        'name' => $user->email,
                        'otp' => $otp,
                        'link' => null,
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

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'email' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
            ];

            $message = [
                'email.required' => 'Please enter email address',
                'email.regex' => 'Please enter valid email address',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            $email = trim(strtolower($request['email']));
            $user = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at')
                ->where('email', $email)
                ->first();
            if ($user == null) {
                return response()->json(['error' => 1, 'message' => 'You have not registered with us yet']);
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
                return response()->json(['success' => 1, 'message' => 'OTP has been sent to your registered email address']);
            }
        } else {
            return view('front.auth.forgot_password');
        }
    }

    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
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
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            $user = Customers::select('customer_id', 'name', 'mobile', 'email', 'otp', 'otp_status', 'updated_at', 'password')
            ->where('email', $request['email'])
            ->first();
            if ($user == null) {
                return response()->json(['error' => 1, 'message' => 'You have not registered with us yet']);
            } elseif ($request['step'] == 1 && $user->otp_status == 0) {
                if ($request['otp'] == $user->otp) {
                    $user->otp_status = 1;
                    $user->save();
                    return response()->json(['success' => 1, 'message' => 'OTP verified successfully']);
                } else {
                    return response()->json(['error' => 1, 'message' => 'Incorrect OTP']);
                }
            } elseif ($request['step'] == 2 && $user->otp_status == 1) {
                $dt = new Carbon($user->updated_at);
                if ($dt->diffInMinutes(date('Y-m-d H:i:s')) > 5) {
                    return response()->json(['error' => 1, 'message' => 'OTP expired']);
                }
                $user->password = Hash::make($request['password']);
                $user->save();
                return response()->json(['success' => 1, 'message' => 'Password updated successfully']);
            } else {
                return response()->json(['error' => 1, 'message' => 'Invalid Call']);
            }
        } else {
            return view('front.auth.reset_password');
        }
    }

    public function emailVerify(Request $request)
    {
        if (empty($request->token)) {
            return redirect('/customer/search-diamonds/polish-diamonds');
        } else {
            $token = decrypt($request->token, false);
            $token = explode('--', $token);
            if (count($token) == 2) {
                $valid = DB::table('customer')
                    ->select('customer_id')
                    ->where('email', $token[0])
                    ->where('date_added', $token[1])
                    ->where('verified_status', 0)
                    ->first();
                if ($valid) {
                    DB::table('customer')->where('customer_id', $valid->customer_id)->update(['verified_status' => 1]);
                    return view('front.auth.email_verify');
                } else {
                    return redirect('/customer/search-diamonds/polish-diamonds');
                }
            } else {
                return redirect('/customer/search-diamonds/polish-diamonds');
            }
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
        return redirect('/customer/search-diamonds/polish-diamonds');
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
