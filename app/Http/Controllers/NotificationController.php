<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $data['title'] = 'Notifications';
        $notifications = DB::table('notifications')
            ->select('id', 'title', 'body', 'url', 'status', 'created_at')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.notifications.list', compact('data', 'notifications'));
    }
}
