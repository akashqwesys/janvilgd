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
        //     'id'    => 'd_id_494'
        // ];
        // dd($client->get($params));
        // dd($client->delete($params));
        // dd($client->indices()->delete(['index' => 'diamonds']));
        // dd($client->search(['index' => 'diamonds']));

        // Get settings for one index
        // $params = ['index' => 'diamonds'];
        // $response = $client->indices()->getSettings($params);
        // $response = $client->indices()->getMapping($params);
        // dd($response);

        /* $params = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [ 'term' => [ 'attributes_id.19' => '463' ] ],
                            [ 'term' => [ 'attributes_id.11' => '427' ] ],
                            [ 'range' => [ 'expected_polish_cts' => [ 'gte' => 0, 'lte' => 2 ] ] ],
                            [ 'range' => [ 'total' => [ 'gte' => 100, 'lte' => 10000 ] ] ]
                        ]
                    ]
                ]
            ]
        ]; */
        $params = [
            'index' => 'diamonds_temp',
            'body'  => [
                'query' => [
                    'nested' => [
                        'path' => 'attributes_id',
                        'query' => [
                            [
                                'bool' => [
                                    'must' => [
                                        ['term' => ['attributes_id.key1' => '13']],
                                    ],
                                    'should' => [
                                        ['match' => ['attributes_id.value1' => '376']],
                                        ['match' => ['attributes_id.value1' => '378']],
                                        ['match' => ['attributes_id.value1' => '379']],
                                    ]
                                    // 'must' => [
                                    //     'bool' => [
                                    //         'should' => [
                                    //     ['term' => ['attributes_id.12' => '395']],
                                    //     ['term' => ['attributes_id.12' => '396']]
                                    // ]]],
                                    // 'must' => [
                                    //     'bool' => [
                                    //         'should' => [
                                    //     ['term' => ['attributes_id.11' => '422']],
                                    //     ['term' => ['attributes_id.11' => '425']],
                                    //     ['term' => ['attributes_id.11' => '426']]
                                    // ]]]
                                    ],
                                'bool' => [
                                    'must' => [
                                        ['term' => ['attributes_id.key1' => '11']],
                                    ],
                                    'should' => [
                                        ['match' => ['attributes_id.value1' => '422']],
                                        ['match' => ['attributes_id.value1' => '425']]
                                    ]
                                ]
                            ],
                            // [ 'term' => [ 'refCategory_id' => '3' ] ],
                            // [ 'range' => [ 'expected_polish_cts' => [ 'gte' => 0.5, 'lte' => 0.6 ] ] ],
                            // [ 'range' => [ 'total' => [ 'gte' => 100, 'lte' => 10000 ] ] ]
                        ]
                    ]
                ]
            ]
        ];
        /* $tt = [];
        for ($i=0; $i < 5; $i++) {
            $tt[] = [ 'term' => [ 'attributes_id.'.$i => $i ] ];
        }
        array_push($tt, [ 'range' => [ 'expected_polish_cts' => [ 'gte' => 1, 'lte' => 2 ] ] ]); */
        // $all = [
        //     'scroll' => '30s',          // how long between scroll requests. should be small!
        //     'size'   => 100,             // how many results *per shard* you want back
        //     'index' => 'diamonds_temp',
        //     'body'  => [
        //         'query' => [
        //             'match_all' => new \stdClass()
        //         ]
        //     ]
        // ];

        $results = $client->search($params);
        echo "<pre>";print_r($results);
    }

    public function createElasticIndex(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $params = [
            'index' => 'diamonds_temp',
            // 'id'    => 'diamond_id',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1
                ],
                'mappings' => [
                    'properties' => [
                        "diamond_id" => [
                            "type" => "unsigned_long"
                        ],
                        'name' => [
                            'type' => 'text'
                        ],
                        "actual_pcs" => [
                            "type" => "long"
                        ],
                        "added_by" => [
                            "type" => "unsigned_long"
                        ],
                        "available_pcs" => [
                            "type" => "long"
                        ],
                        "barcode" => [
                            "type" => "text"
                        ],
                        "date_added" => [
                            "type" => "date",
                            "format" => "yyyy-MM-dd HH:mm:ss"
                        ],
                        "date_updated" => [
                            "type" => "date",
                            "format" => "yyyy-MM-dd HH:mm:ss"
                        ],
                        "discount" => [
                            "type" => "float"
                        ],
                        "expected_polish_cts" => [
                            "type" => "double"
                        ],
                        "makable_cts" => [
                            "type" => "double"
                        ],
                        "image" => [
                            "type" => "flattened"
                        ],
                        "is_active" => [
                            "type" => "byte"
                        ],
                        "is_deleted" => [
                            "type" => "byte"
                        ],
                        "is_recommended" => [
                            "type" => "byte"
                        ],
                        "packate_no" => [
                            "type" => "text"
                        ],
                        "rapaport_price" => [
                            "type" => "double"
                        ],
                        "refCategory_id" => [
                            "type" => "integer"
                        ],
                        "remarks" => [
                            "type" => "text"
                        ],
                        "total" => [
                            "type" => "double"
                        ],
                        "weight_loss" => [
                            "type" => "text"
                        ],
                        "attributes" => [
                            "type" => "flattened"
                        ],
                        "attributes_id" => [
                            "type" => "nested"
                        ]
                    ]
                ]
            ]
        ];

        $client->indices()->create($params);
    }
}