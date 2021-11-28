<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameTypeOrderDiamonds1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_diamonds', function (Blueprint $table) {
            $table->longText('name')->change();
            $table->longText('images')->change();
            $table->longText('video_link')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_diamonds', function (Blueprint $table) {
            //
        });
    }
}
