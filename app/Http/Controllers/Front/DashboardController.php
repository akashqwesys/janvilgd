<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rule;
// use App\Models\Customers;
// use App\Models\CustomerCompanyDetail;
use DB;
// use Carbon\Carbon;
use Elastic\Elasticsearch\ClientBuilder;

class DashboardController extends Controller {

    public function dashboard(Request $request)
    {
        $title = 'Dashboard';
        $category = DB::table('categories')
            ->select('category_id', 'slug')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();
        $rough = $polish = $p4 = 0;
        foreach ($category as $v) {
            if ($v->slug == 'rough-diamonds') {
                $rough = $v->category_id;
            }
            else if ($v->slug == 'polish-diamonds') {
                $polish = $v->category_id;
            }
            else if ($v->slug == '4p-diamonds') {
                $p4 = $v->category_id;
            }
        }
        $diamond = DB::table('diamonds')
            ->select(
                DB::raw('count(case when "refCategory_id" = '. $rough .' then 1 end) as total_rough'),
                DB::raw('count(case when "refCategory_id" = '. $polish .' then 1 end) as total_polish'),
                DB::raw('count(case when "refCategory_id" = '. $p4 .' then 1 end) as total_4p')
            )
            ->where('available_pcs', '>', 0)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->first();

        $recently_viewed = DB::table('recently_view_diamonds as r')
            ->join('diamonds as d', 'r.refDiamond_id', '=', 'd.diamond_id')
            ->select('d.name', 'd.diamond_id', 'r.created_at', 'r.updated_at')
            ->orderBy('r.id', 'desc')
            ->limit(3)
            ->get();

        return view('front.dashboard', compact('title', 'diamond', 'recently_viewed'));
    }

    public function latest_diamonds(Request $request)
    {
        $title = 'Latest Diamonds';
        $elastic_params = [
            'index' => 'diamonds',
            'body'  => [
                'size'  =>  8,
                'sort' => [
                    [
                        'diamond_id' => [ 'order' => 'desc' ]
                    ]
                ]
            ]
        ];
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $diamonds = $client->search($elastic_params);
        if ($diamonds['hits']['hits'] && count($diamonds['hits']['hits'])) {
            $diamonds = $diamonds['hits']['hits'];
        } else {
            $diamonds = [];
        }

        return view('front.latest_diamond', compact('title', 'diamonds'));
    }

    public function recommended_diamonds(Request $request)
    {
        $title = 'Recommended Diamonds';
        $elastic_params = [
            'index' => 'diamonds',
            'body'  => [
                'size'  =>  8,
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['is_recommended' => ['value' => 1]]]
                        ]
                    ]
                ]
            ]
        ];
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $diamonds = $client->search($elastic_params);
        if ($diamonds['hits']['hits'] && count($diamonds['hits']['hits'])) {
            $diamonds = $diamonds['hits']['hits'];
        } else {
            $diamonds = [];
        }

        return view('front.latest_diamond', compact('title', 'diamonds'));
    }
}
