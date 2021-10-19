<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondsAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diamonds_attributes', function (Blueprint $table) {
            $table->id('diamond_attribute_id');
            $table->foreignId('refDiamond_id');
            $table->foreignId('refAttribute_group_id');
            $table->foreignId('refAttribute_id');
            $table->string('value',30);
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
        Schema::dropIfExists('diamonds_attributes');
    }
}
