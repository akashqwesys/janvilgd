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
        return view('front.profile.my_account', compact('title', 'company', 'customer', 'country', 'state', 'city'));
    }

    public function getMyProfile(Request $request)
    {
        $title = 'My Profile';
        $data = new APIUserController;
        $api = $data->myAccount($request);
        // $company = $api->original['data']['company'];
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

        return view('front.profile.my_profile', compact('title', 'customer', 'country', 'state', 'city'));
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

    public function getMyCompanies(Request $request)
    {
        $title = 'My Addresses';
        $data = new APIUserController;
        $api = $data->getCompanies($request);
        $company = $api->original['data']['company'];
        $country = DB::table('country')
            ->select('country_id', 'name', 'country_code')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        return view('front.companies.companies', compact('title', 'company', 'country'));
    }

    public function saveMyCompanies(Request $request)
    {
        $data = new APIUserController;
        $api = $data->addUpdateCompany($request);

        if ($request->ajax()) {
            if ($api->original['flag'] == true) {
                $address = $data->getCompanies($request);
                return response()->json([
                    'success' => 1,
                    'message' => $api->original['message'],
                    'data' => $address->original['data']['company'],
                    'id' => $api->original['data']['id']
                ]);
            } else {
                return response()->json(['error' => 1, 'message' => $api->original['message']]);
            }
        }

        if ($api->original['flag'] == true) {
            return back()->with(['success' => 1, 'message' => $api->original['message']]);
        } else {
            return back()->with(['error' => 1, 'message' => $api->original['message']]);
        }
    }

    public function deleteMyCompany(Request $request)
    {
        $data = new APIUserController;
        $api = $data->deleteCompany($request);

        if ($api->original['flag'] == true) {
            return response()->json(['success' => 1, 'message' => $api->original['message']]);
        } else {
            return response()->json(['error' => 1, 'message' => $api->original['message']]);
        }
    }

}