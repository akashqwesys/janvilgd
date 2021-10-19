<?php

namespace Database\Factories;

use App\Models\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesignationFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Designation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => "CEO",
            'added_by' => 1,
            'is_active' => 1,
            'is_deleted' => 0,
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-m h:i:s")
        ];
    }

}
