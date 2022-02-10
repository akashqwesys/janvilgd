<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMostOrderedDiamondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('most_ordered_diamonds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCategory_id');
            $table->string('shape')->nullable();
            $table->string('color')->nullable();
            $table->double('carat')->nullable();
            $table->string('clarity')->nullable();
            $table->string('cut')->nullable();
            $table->double('shape_cnt')->nullable();
            $table->double('color_cnt')->nullable();
            $table->double('carat_cnt')->nullable();
            $table->double('clarity_cnt')->nullable();
            $table->double('cut_cnt')->nullable();
            $table->timestamps();
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('most_ordered_diamonds');
    }
}
