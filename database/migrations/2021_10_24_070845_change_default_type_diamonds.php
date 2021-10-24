<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultTypeDiamonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diamonds', function (Blueprint $table) {
            $table->dropColumn('barcode');       
            $table->dropColumn('packate_no');       
            $table->dropColumn('actual_pcs');       
            $table->dropColumn('available_pcs');       
            $table->dropColumn('remarks'); 
            $table->dropColumn('weight_loss'); 
            $table->dropColumn('video_link');                         
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
            $table->dropColumn('barcode');       
            $table->dropColumn('packate_no');       
            $table->dropColumn('actual_pcs');       
            $table->dropColumn('available_pcs');       
            $table->dropColumn('remarks'); 
            $table->dropColumn('weight_loss'); 
            $table->dropColumn('video_link'); 
        });
    }
}
