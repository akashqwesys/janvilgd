<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state', function (Blueprint $table) {
            $table->id('state_id');
            $table->string('name',30); 
            $table->foreignId('refCountry_id');
            $table->foreignId('added_by');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_deleted');
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
        Schema::dropIfExists('state');
    }
}
