<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\CommonEmail;
use Illuminate\Support\Facades\Mail;
use DB;

class NotificationController extends Controller
{
    use APIResponse;

    public function index(Request $request)
    {
        $data = DB::table('notifications')
            ->select('id', 'title', 'body', 'created_at')
            ->where('user_id', Auth::id())
            ->get();
        return $this->successResponse('Success', $data);
    }
}
