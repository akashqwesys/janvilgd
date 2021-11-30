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

        // Get settings for one index
        // $params = ['index' => 'diamonds'];
        // $response = $client->indices()->getSettings($params);
        // $response = $client->indices()->getMapping($params);
        // dd($response);

        $params = [
            'index' => 'diamonds',
            'body'  => [
                'query' => [
                    'match' => [
                        'barcode' => '435435'
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
            // 'id'    => 'diamond_id',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1
                ],
                'mappings' => [
                    'properties' => [
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
                            "type" => "long"
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
                            "type" => "flattened"
                        ]
                    ]
                ]
            ]
        ];

        $client->indices()->create($params);
    }
}