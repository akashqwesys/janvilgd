<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponse;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\CommonEmail;
use Illuminate\Support\Facades\Mail;
use DB;

class ContactController extends Controller
{
    use APIResponse;

    public function index(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'country_code' => ['required', 'integer'],
            'mobile' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required']
        ];

        $message = [];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $data_array = array();
        $data_array['name'] = $request->name;
        $data_array['phone'] = $request->mobile;
        $data_array['email'] = $request->email;
        $data_array['subject'] = $request->subject;
        $data_array['message'] = $request->message;
        $data_array['date_added'] = date('Y-m-d H:i:s');

        DB::table('contact_req')->insert($data_array);
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
                        'name' => $request->name,
                        'phone' => $request->mobile,
                        'email' => $request->email,
                        'subject' => $request->subject,
                        'msg' => $request->message,
                    ],
                    'view' => 'emails.inquiryEmail'
                ])
            );
        return $this->successResponse('Inquiry sent successfully');
    }
}
