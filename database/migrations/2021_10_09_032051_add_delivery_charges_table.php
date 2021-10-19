<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->id('delivery_charge_id');
            $table->string('name',30);
            $table->foreignId('reftransport_id',30);
            $table->string('transport_name',50);
            $table->string('from_weight',30);
            $table->string('to_weight',30);
            $table->string('amount',30);
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
        Schema::dropIfExists('delivery_charges');
    }
}
