<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Blogs::factory()->create();
        \App\Models\Categories::factory()->create();
        \App\Models\CustomerType::factory()->create();
        \App\Models\Designation::factory()->create();
        \App\Models\Discounts::factory()->create();
        \App\Models\Events::factory()->create();
        \App\Models\InformativePages::factory()->create();
        \App\Models\LabourCharges::factory()->create();
        \App\Models\User::factory()->create();
    }
}
