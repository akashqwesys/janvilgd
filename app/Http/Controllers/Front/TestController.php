<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Diamonds;
use App\Models\DiamondTemp;
use DB;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Namespaces\SqlNamespace;

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

        $all = [
            'scroll' => '30s',          // how long between scroll requests. should be small!
            'size'   => 1000,             // how many results *per shard* you want back
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];
        // $sql = [
        //     'body' => [
        //         'query' => 'select * from diamonds_temp where (attributes_id.value1 = 376 OR attributes_id.value1 = 375) and (attributes_id.value1 = 422 OR attributes_id.value1 = 425) and refCategory_id = 3 and (expected_polish_cts > 0.5 and expected_polish_cts < 0.6)'
        //     ]
        // ];
        // $results = $client->sql()->translate($sql);
        // echo "<pre>";
        // var_export($results);die;

        /* $params = [
            'index' => 'diamonds_temp',
            'body'  => array(
                'size' => 1000,
                'query' =>
                array(
                    'bool' =>
                    array(
                        'must' =>
                        array(
                            array(
                                'bool' =>
                                array(
                                    'must' =>
                                    array(
                                        array(
                                            'nested' =>
                                            array(
                                                'query' =>
                                                array(
                                                    'terms' =>
                                                    array(
                                                        'attributes_id.value1' =>
                                                        array(
                                                            0 => 376,
                                                            1 => 378,
                                                        ),
                                                        'boost' => 1.0,
                                                    ),
                                                ),
                                                'path' => 'attributes_id',
                                                'ignore_unmapped' => false,
                                                'score_mode' => 'none',
                                                'boost' => 1.0,
                                            ),
                                        ),
                                        array(
                                            'nested' =>
                                            array(
                                                'query' =>
                                                array(
                                                    'terms' =>
                                                    array(
                                                        'attributes_id.value1' =>
                                                        array(
                                                            0 => 427,
                                                            1 => 426,
                                                        ),
                                                        'boost' => 1.0,
                                                    ),
                                                ),
                                                'path' => 'attributes_id',
                                                'ignore_unmapped' => false,
                                                'score_mode' => 'none',
                                                'boost' => 1.0,
                                            ),
                                        ),
                                        array(
                                            'nested' =>
                                            array(
                                                'query' =>
                                                array(
                                                    'terms' =>
                                                    array(
                                                        'attributes_id.value1' =>
                                                        array(
                                                            0 => 395,
                                                            1 => 396,
                                                        ),
                                                        'boost' => 1.0,
                                                    ),
                                                ),
                                                'path' => 'attributes_id',
                                                'ignore_unmapped' => false,
                                                'score_mode' => 'none',
                                                'boost' => 1.0,
                                            ),
                                        ),
                                    ),
                                    'adjust_pure_negative' => true,
                                    'boost' => 1.0,
                                ),
                            ),
                            array(
                                'bool' =>
                                array(
                                    'must' =>
                                    array(
                                        array(
                                            'term' =>
                                            array(
                                                'refCategory_id' =>
                                                array(
                                                    'value' => 3,
                                                    'boost' => 1.0,
                                                ),
                                            ),
                                        ),
                                        array(
                                            'range' =>
                                            array(
                                                'expected_polish_cts' =>
                                                array(
                                                    'from' => 0,
                                                    'to' => 5,
                                                    'include_lower' => false,
                                                    'include_upper' => false,
                                                    'time_zone' => 'Z',
                                                    'boost' => 1.0,
                                                ),
                                            ),
                                        ),
                                    ),
                                    'adjust_pure_negative' => true,
                                    'boost' => 1.0,
                                ),
                            ),
                        ),
                        'adjust_pure_negative' => true,
                        'boost' => 1.0,
                    ),
                )
            )
        ]; */
        $results = $client->search($all);
        echo "<pre>";
        print_r($results);
    }

    public function createElasticIndex(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $params = [
            'index' => 'diamonds',
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