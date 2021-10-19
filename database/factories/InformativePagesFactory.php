<?php

namespace Database\Factories;

use App\Models\InformativePages;
use Illuminate\Database\Eloquent\Factories\Factory;

class InformativePagesFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InformativePages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name'=>"Privacy and Policy page",
            'content'=>"Dummy content",
            'slug'=>"Informative slug",
            'updated_by'=>1,
            'is_active'=>1,
            'date_updated' => date("yy-m-m h:i:s")
        ];
    }

}
