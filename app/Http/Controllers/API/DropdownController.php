<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
use Carbon\Carbon;

class DropdownController extends Controller
{
    use APIResponse;

    public function index(Request $request)
    {
        $country = DB::table('country')
            ->select('country_id', 'name')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $state = DB::table('state')
            ->select('state_id', 'name')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $city = DB::table('city')
            ->select('city_id', 'name')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $categories = DB::table('categories')
            ->select('category_id', 'name', 'slug')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $data = [
            'diamond_categories' => $categories,
            'country' => $country,
            'state' => $state,
            'city' => $city
        ];

        return $this->successResponse('Success', $data);
    }

    public function getStates(Request $request)
    {
        $states = DB::table('state')
            ->select('state_id', 'name')
            ->where('refCountry_id', $request->id)
            ->get();
        $data = '<option value=""> Select State </option>';
        if (count($states)) {
            foreach ($states as $v) {
                $data .= '<option value="'.$v->state_id.'">'.$v->name.'</option>';
            }
        } else {
            $data .= '<option value=""> No data found </option>';
        }
        return response()->json(['success' => 1, 'data' => $data]);
    }

    public function getCities(Request $request)
    {
        $cities = DB::table('city')
            ->select('city_id', 'name')
            ->where('refState_id', $request->id)
            ->get();
        $data = '<option value=""> Select City </option>';
        if (count($cities)) {
            foreach ($cities as $v) {
                $data .= '<option value="' . $v->city_id . '">' . $v->name . '</option>';
            }
        } else {
            $data .= '<option value=""> No data found </option>';
        }
        return response()->json(['success' => 1, 'data' => $data]);
    }
}
