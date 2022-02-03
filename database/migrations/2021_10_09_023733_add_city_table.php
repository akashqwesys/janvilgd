<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->id('city_id');
            $table->string('name',30);
            $table->foreignId('refState_id');
            $table->foreignId('added_by')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->tinyInteger('is_deleted')->nullable();
             $table->dateTime('date_added')->nullable();
            $table->dateTime('date_updated')->nullable();
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
        Schema::dropIfExists('city');
    }
}
