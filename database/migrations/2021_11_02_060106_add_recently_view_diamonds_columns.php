<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecentlyViewDiamondsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recently_view_diamonds', function (Blueprint $table) {
            $table->string('carat')->nullable();
            $table->string('price')->nullable();
            $table->string('shape')->nullable();
            $table->string('cut')->nullable();
            $table->string('color')->nullable();
            $table->string('clarity')->nullable();
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
