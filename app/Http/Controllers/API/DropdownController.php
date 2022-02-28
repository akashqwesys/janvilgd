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
            ->select('country_id', 'name', 'country_code')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')
            ->get();

        /* $state = DB::table('state as s')
            ->join('country as c', 's.refCountry_id', '=', 'c.country_id')
            ->select('s.state_id', 's.name', 'c.country_id')
            ->where('s.is_active', 1)
            ->where('s.is_deleted', 0)
            ->orderBy('name', 'asc')
            ->get();

        $city = DB::table('city as c')
            ->join('state as s', 'c.refState_id', '=', 's.state_id')
            ->select('c.city_id', 'c.name', 's.state_id')
            ->where('c.is_active', 1)
            ->where('c.is_deleted', 0)
            ->get(); */

        $categories = DB::table('categories')
            ->select('category_id', 'name', 'slug')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('name', 'asc')
            ->get();

        $data = [
            'diamond_categories' => $categories,
            'country' => $country,
            'whatsapp_usa' => '+1-9122456789',
            'whatsapp_india' => '+91-9714405421',
            'mobile_usa' => '+1-9122456789',
            'mobile_india' => '+91-9714405421',
            'email' => 'support@janvilgd.com'
            /* 'state' => $state,
            'city' => $city */
        ];

        return $this->successResponse('Success', $data);
    }

    public function getStates(Request $request)
    {
        $states = DB::table('state')
            ->select('state_id', 'name')
            ->where('refCountry_id', $request->id)
            ->orderBy('name', 'asc')
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
            ->orderBy('name', 'asc')
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

    public function getStatesCitiesAPI(Request $request)
    {
        if ($request->status == 'states') {
            $data = DB::table('state')
                ->select('state_id', 'name')
                ->where('refCountry_id', $request->id)
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $data = DB::table('city')
                ->select('city_id', 'name')
                ->where('refState_id', $request->id)
                ->orderBy('name', 'asc')
                ->get();
        }
        return $this->successResponse('Success', $data);
    }

}
