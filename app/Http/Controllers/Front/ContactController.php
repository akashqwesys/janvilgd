<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\CommonEmail;
use DB;
use Carbon\Carbon;

class ContactController extends Controller {

    public function index(Request $request)
    {
        if (isset($request->txt_name)) {          
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

            $data_array=array();
            $data_array['name']=$request->txt_name;
            $data_array['phone']=$request->txt_phone;
            $data_array['email']=$request->txt_email;
            $data_array['subject']=$request->txt_subject;
            $data_array['message']=$request->txt_msg;
            $data_array['date_added']=date('Y-m-d H:i:s');
            
            DB::table('contact_req')->insert($data_array);
            $attr_id = DB::getPdo()->lastInsertId();
            echo $attr_id;die;
            // $admin_email = DB::table('settings')
            //     ->select('value')
            //     ->where('key', 'admin_email')
            //     ->pluck('value')
            //     ->first();
            // Mail::to($admin_email)
            //     ->send(
            //         new CommonEmail([
            //             'subject' => 'Inquiry from Janvi LGE',
            //             'data' => [
            //                 'time' => date('Y-m-d H:i:s'),
            //                 'name' => $request->txt_name,
            //                 'phone' => $request->txt_phone,
            //                 'email' => $request->txt_email,
            //                 'subject' => $request->txt_subject,
            //                 'msg' => $request->txt_msg,
            //             ],
            //             'view' => 'emails.inquiryEmail'
            //             ])
            //         );
            return back()->with(['success' => 1, 'message' => 'Inquiry sent successfully']);
        }
        return view('front.contact');
    }
}