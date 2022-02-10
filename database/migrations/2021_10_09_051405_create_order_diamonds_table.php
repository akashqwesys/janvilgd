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
            $table->text('name');
            $table->float('makable_cts');
            $table->float('expected_polish_cts');
            $table->text('remarks');
            $table->float('rapaport_price');
            $table->float('price');
            $table->float('discount');
            $table->string('weight_loss', 30);
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
