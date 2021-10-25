<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use DB;

class FrontAuthController extends Controller
{
    use APIResponse;

    public function login(Request $request)
    {
        dd(1);
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

                $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')->where('mobile', $request->mobile)->orWhere('email', $request->email)->first();
                if ($exists) {
                    return response()->json(['success' => 1, 'message' => 'You have successfully logged in', 'url' => '/']);
                }
                else {
                    return response()->json(['success' => 2, 'message' => '', 'url' => '/signup']);
                }
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
            try {
                $rules = [
                    'mobile' => ['required', 'nullable', 'regex:/^[0-9]{8,11}$/ix'],
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

                $exists = DB::table('customer')->select('customer_id', 'name', 'mobile', 'email')->where('mobile', $request->mobile)->orWhere('email', $request->email)->first();
                if ($exists) {
                    return redirect('/');
                } else {
                    return redirect('/signup');
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
