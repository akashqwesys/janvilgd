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
            $table->string('name',30);
            $table->string('mobile',10);
            $table->string('email',30);
            $table->longText('address');
            $table->foreignId('city_id');
            $table->foreignId('state_id');
            $table->foreignId('country_id');
            $table->longText('id_proof_1');
            $table->longText('id_proof_2');
            $table->longText('profile_pic');
            $table->foreignId('role_id');
            $table->string('username',30);
            $table->string('password',30);
            $table->foreignId('added_by');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_deleted');
            $table->enum('last_login_type',["mobile","web"]);
            $table->dateTime('last_login_date_time');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');            
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
