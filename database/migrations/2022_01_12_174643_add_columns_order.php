<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('attention')->nullable();
            $table->string('billing_remarks')->nullable();
            $table->string('shipping_remarks')->nullable();
        });

        Schema::table('order_diamonds', function (Blueprint $table) {
            $table->float('new_discount')->nullable()->default(0);
        });

        Schema::table('order_updates', function (Blueprint $table) {
            $table->text('comment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
