<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => "Akash",
            'mobile' => "9989856456",
            'email' => "admin@gmail.com",
            'address' => "Surat",
            'city_id' => 1,
            'state_id' => 1,
            'country_id' => 1,
            'id_proof_1' => "No proof",
            'id_proof_2' => "Dummy proof",
            'profile_pic' => "profile.png",
            'role_id' => 1,
            'username' => "admin",
            'password' => "123",
            'added_by' => 1,
            'is_active' => 1,
            'is_deleted' => 0,
            'user_type'=>"MASTER_ADMIN",
            'last_login_type' => "web",
            'last_login_date_time' => date("yy-m-d h:i:s"),
            'date_added' => date("yy-m-d h:i:s"),
            'date_updated' => date("yy-m-m h:i:s")
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
//    public function unverified() {
//        return $this->state(function (array $attributes) {
//                    return [
//                'email_verified_at' => null,
//                    ];
//                });
//    }

}
