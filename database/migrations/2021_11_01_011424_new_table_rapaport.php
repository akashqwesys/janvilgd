<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewTableRapaport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapaport', function (Blueprint $table) {
            $table->id('rapaport_id');
            $table->text('shape');
            $table->text('clarity');
            $table->text('color');
            $table->text('from_range');
            $table->text('to_range');
            $table->text('rapaport_price');
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
        Schema::dropIfExists('rapaport');
    }
}
