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
        $contacts = DB::table('contact_req as cr')
            ->join('country as c', 'cr.country_id', '=', 'c.country_id')
            ->select('cr.id', 'cr.name', 'cr.phone', 'cr.email', 'cr.subject', 'cr.message', 'cr.date_added', 'c.country_code')
            ->orderBy('cr.id', 'desc')
            ->get();
        return view('admin.contacts.list', compact('data', 'contacts'));
    }
}
