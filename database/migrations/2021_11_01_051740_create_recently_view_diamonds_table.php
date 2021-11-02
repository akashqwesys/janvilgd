<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentlyViewDiamondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recently_view_diamonds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCustomer_id');
            $table->foreignId('refDiamond_id');
            $table->foreignId('refAttribute_group_id');
            $table->foreignId('refAttribute_id');
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
        Schema::dropIfExists('recently_view_diamonds');
    }
}
