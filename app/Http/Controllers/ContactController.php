<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\CommonEmail;
use DB;
use Session;
use Carbon\Carbon;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $data['title'] = 'Inquiry List';
        $contacts = DB::table('contact_req')
            ->select('id', 'name', 'phone', 'email', 'subject', 'message', 'date_added')
            ->latest()
            ->orderBy('id','desc')
            ->get();
        return view('admin.contacts.list', compact('data', 'contacts'));
    }
}
