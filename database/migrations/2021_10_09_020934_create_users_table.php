<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->text('address');
            $table->foreignId('city_id');
            $table->foreignId('state_id');
            $table->foreignId('country_id');
            $table->text('id_proof_1')->nullable();
            $table->text('id_proof_2')->nullable();
            $table->text('profile_pic')->nullable();
            $table->foreignId('role_id');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('added_by');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_deleted');
            $table->enum('last_login_type',["mobile","web"]);
            $table->dateTime('last_login_date_time');
            $table->dateTime('date_added')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('device_token', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
