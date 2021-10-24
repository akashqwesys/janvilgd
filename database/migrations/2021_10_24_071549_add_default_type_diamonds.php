<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultTypeDiamonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diamonds', function (Blueprint $table) {
            $table->text('barcode')->default(0);
            $table->string('packate_no',50)->default(0);
            $table->integer('actual_pcs')->default(0);
            $table->integer('available_pcs')->default(0); 
            $table->text('remarks')->default(0);
            $table->string('weight_loss',30)->default(0);
            $table->text('video_link')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diamonds', function (Blueprint $table) {
            //
        });
    }
}
