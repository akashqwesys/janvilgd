<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\CommonEmail;
use DB;
use Carbon\Carbon;

class ContactController extends Controller {

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('front.contact');
        } else {
            $rules = [
                'txt_name' => ['required'],
                'txt_phone' => ['required'],
                'txt_email' => ['required', 'email'],
                'txt_msg' => ['required']
            ];

            $message = [];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return back()->with(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }
            $admin_email = DB::table('settings')
                ->select('value')
                ->where('key', 'admin_email')
                ->pluck('value')
                ->first();
            Mail::to($admin_email)
                ->send(
                    new CommonEmail([
                        'subject' => 'Inquiry from Janvi LGE',
                        'data' => [
                            'time' => date('Y-m-d H:i:s'),
                            'name' => $request->txt_name,
                            'phone' => $request->txt_phone,
                            'email' => $request->txt_email,
                            'subject' => $request->txt_subject,
                            'msg' => $request->txt_msg,
                        ],
                        'view' => 'emails.inquiryEmail'
                        ])
                    );
            return back()->with(['success' => 1, 'message' => 'Inquiry sent successfully']);
        }
    }
}