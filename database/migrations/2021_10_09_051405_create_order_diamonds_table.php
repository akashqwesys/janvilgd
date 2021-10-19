<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDiamondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_diamonds', function (Blueprint $table) {
            $table->id('order_diamond_id');
            $table->foreignId('refOrder_id');
            $table->foreignId('refDiamond_id');
            $table->text('barcode');
            $table->string('makable_cts',30);
            $table->string('expected_polish_cts',30);
            $table->text('remarks');
            $table->string('rapaport_price',30);
            $table->string('discount',30);
            $table->string('weight_loss',10);
            $table->text('video_link');
            $table->text('images');
            $table->foreignId('refCategory_id');
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
        Schema::dropIfExists('order_diamonds');
    }
}
