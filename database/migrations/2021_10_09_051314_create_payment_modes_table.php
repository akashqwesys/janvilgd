<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_modes', function (Blueprint $table) {
            $table->id('payment_mode_id');
            $table->string('name',30);
            $table->string('sort_order',30);
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
        Schema::dropIfExists('payment_modes');
    }
}
