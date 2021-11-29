<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Diamonds;
use App\Models\DiamondTemp;
use DB;
use Elasticsearch\ClientBuilder;

class TestController extends Controller
{
    public function index(Request $request)
    {
        /* Diamonds::where('diamond_id', 466)->update([
            'image' => '["sa-1","sa-2"]'
        ]); */
        // $diamonds = DiamondTemp::search()->where('image', 'sa')->get();

        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        // $params = [
        //     'index' => 'diamonds',
        //     'id'    => 'diamond_id'
        // ];
        // dd($client->get($params));
        // dd($client->indices()->delete(['index' => 'diamonds']));

        // Get settings for one index
        $params = ['index' => 'diamonds'];
        // $response = $client->indices()->getSettings($params);
        $response = $client->indices()->getMapping($params);
        dd($response);

        $params = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'match' => [
                        'barcode' => 'vc234'
                    ]
                ]
            ]
        ];

        $results = $client->search($params);
        dd($results);
    }

    public function createElasticIndex(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $params = [
            'index' => 'diamonds',
            'id'    => 'diamond_id',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ];

        $client->indices()->create(['index' => 'diamonds']);
    }
}