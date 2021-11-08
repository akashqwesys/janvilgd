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
            ->select('category_id', 'name')
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
}
