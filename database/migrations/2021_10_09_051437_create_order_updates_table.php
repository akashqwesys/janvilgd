<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_updates', function (Blueprint $table) {
            $table->id('order_update_id');
            $table->string('order_status_name',30);
            $table->foreignId('refOrder_id');
            $table->text('comment');
            $table->foreignId('added_by');
            $table->tinyInteger('is_deleted');
            $table->dateTime('date_added');
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
        Schema::dropIfExists('order_updates');
    }
}
