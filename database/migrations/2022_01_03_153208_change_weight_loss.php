<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeWeightLoss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diamonds', function (Blueprint $table) {
            $table->dropColumn('weight_loss');
        });

        Schema::table('order_diamonds', function (Blueprint $table) {
            $table->dropColumn('weight_loss');
        });

        Schema::table('diamonds', function (Blueprint $table) {
            $table->float('weight_loss')->nullable();
        });

        Schema::table('order_diamonds', function (Blueprint $table) {
            $table->float('weight_loss')->nullable();
            $table->text('images')->nullable()->change();
            $table->text('video_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
