<?php

namespace Database\Factories;

use App\Models\Discounts;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountsFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discounts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name'=>"Flat",
            'from_amount'=>"5000",
            'to_amount'=>"2000",
            'discount'=>"1500",
            'added_by' => 1,
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-m h:i:s")
        ];
    }

}
