<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\API\UserController as APIUserController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\CustomerCompanyDetail;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function getMyAccount(Request $request)
    {
        $title = 'My Account';
        $data = new APIUserController;
        $api = $data->myAccount($request);
        $company = $api->original['data']['company'];
        $customer = $api->original['data']['customer'];
        return view('front.profile.my_account', compact('title', 'company', 'customer'));
    }

    public function getMyProfile(Request $request)
    {
        $title = 'My Profile';
        $data = new APIUserController;
        $api = $data->myAccount($request);
        $company = $api->original['data']['company'];
        $customer = $api->original['data']['customer'];
        $country = DB::table('country')
            ->select('country_id', 'name')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $state = DB::table('state')
            ->select('state_id', 'name')
            ->where('refCountry_id', $customer->refCountry_id)
            ->get();

        $city = DB::table('city')
            ->select('city_id', 'name')
            ->where('refState_id', $customer->refState_id)
            ->get();

        $cp_state = DB::table('state')
            ->select('state_id', 'name')
            ->where('refCountry_id', $company->refCountry_id)
            ->get();

        $cp_city = DB::table('city')
            ->select('city_id', 'name')
            ->where('refState_id', $company->refState_id)
            ->get();

        return view('front.profile.my_profile', compact('title', 'company', 'customer', 'country', 'state', 'city', 'cp_state', 'cp_city'));
    }

    public function updateMyProfile(Request $request)
    {
        $data = new APIUserController;
        $api = $data->updateProfile($request);
        if ($api->original['flag'] == true) {
            return back()->with(['success' => 1, 'message' => $api->original['message']]);
        } else {
            return back()->with(['error' => 1, 'message' => $api->original['message']]);
        }
    }

}