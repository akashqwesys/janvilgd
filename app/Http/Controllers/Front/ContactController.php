<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\CommonEmail;
use Illuminate\Support\Facades\Mail;
use DB;
use Session;
use Carbon\Carbon;

class ContactController extends Controller {

    public function index(Request $request)
    {
        if(isset($request->txt_name)) {

            // $request->txt_phone=$request->txt_phone['full'];

            $rules = [
                'txt_name' => ['required'],
                'txt_email' => ['required', 'email'],
                'txt_phone' => ['required', 'numeric'],
                'txt_msg' => ['required']
            ];

            $message = [];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json(['error' => 1, 'message' => $validator->errors()->all()[0]]);
            }

            $data_array = array();
            $data_array['name']=$request->txt_name;
            $data_array['phone']=$request->txt_phone;
            $data_array['email']=$request->txt_email;
            $data_array['subject']=$request->txt_subject;
            $data_array['message']=$request->txt_msg;
            $data_array['date_added']=date('Y-m-d H:i:s');
            $data_array['country_id'] = $request->country_code;

            sendPushNotification('New Inquiry', $request->txt_name . ' has sent an inquiry', url('/admin/inquiries'));
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
                            'name' => $request->txt_name,
                            'phone' => $request->txt_phone,
                            'email' => $request->txt_email,
                            'subject' => $request->txt_subject,
                            'msg' => $request->txt_msg,
                        ],
                        'view' => 'emails.inquiryEmail'
                        ])
                    );
            return response()->json(['success' => 1, 'message' => 'Inquiry sent successfully']);
            // return redirect('/contact')->with(['success' => 1, 'message' => 'Inquiry sent successfully']);
            // successOrErrorMessage("Inquiry sent successfully", 'success');
        }
        // return redirect('/contact');
        return response()->json(['error' => 1, 'message' => 'Please enter Name']);
    }
}