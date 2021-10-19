<?php

namespace Database\Factories;

use App\Models\CustomerType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [            
            'name'=>"akash",
            'discount'=>"500",
            'allow_credit'=>"3000",
            'credit_limit'=>"5000",                        
            'added_by' => 1,
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-m h:i:s")  
        ];
    }
}
