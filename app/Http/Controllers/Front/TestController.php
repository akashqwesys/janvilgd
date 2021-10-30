<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $result = DB::select('select
            "da"."refAttribute_id",
            "d"."diamond_id",
            "d"."expected_polish_cts" as "carat",
            "d"."image",
            "d"."video_link",
            "d"."total" as "price"
            from
            "diamonds" as "d"
            inner join "diamonds_attributes" as "da" on "d"."diamond_id" = "da"."refDiamond_id"
            where
            (
                "da"."refAttribute_group_id" = 5
                and "da"."refAttribute_id" in (30, 27)
            )
            or (
                "da"."refAttribute_group_id" = 9
                and "da"."refAttribute_id" in (21, 32)
            )
            or (
                "da"."refAttribute_group_id" = 12
                and "da"."refAttribute_id" in (34)
            )
            or (
                "da"."refAttribute_group_id" = 17
                and "da"."refAttribute_id" in (17, 12)
            )
            or (
                "da"."refAttribute_group_id" = 18
                and "da"."refAttribute_id" in (41, 13, 35, 43, 45)
            )
            or (
                "da"."refAttribute_group_id" = 19
                and "da"."refAttribute_id" in (36, 14)
            )
            or (
                "da"."refAttribute_group_id" = 24
                and "da"."refAttribute_id" in (2, 3)
            )
            or (
                "da"."refAttribute_group_id" = 30
                and "da"."refAttribute_id" in (5)
            )
            and "da"."refAttribute_id" <> 0
            and "d"."is_active" = 1
            and "d"."is_deleted" = 0
            group by
            "d"."diamond_id"
            order by
            "d"."diamond_id" desc');

        echo '<pre>';
        print_r($result);
    }
}