<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
use Carbon\Carbon;

class ContactController extends Controller {

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('front.contact');
        } else {

        }
    }
}