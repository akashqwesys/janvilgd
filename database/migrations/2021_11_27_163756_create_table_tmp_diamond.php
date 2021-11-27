<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTmpDiamond extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_diamond_polish', function (Blueprint $table) {
            $table->id();
            $table->text('stock')->nullable();
            $table->text('availability')->nullable();
            $table->text('shape')->nullable();
            $table->text('weight')->nullable();
            $table->text('stock')->nullable();
            $table->text('clarity')->nullable();
            $table->text('Color')->nullable();
            $table->text('discount_percent')->nullable();
            $table->text('video_link')->nullable();
            $table->text('cut')->nullable();
            $table->text('polish')->nullable();
            $table->text('symmetry')->nullable();
            $table->text('depth_percent')->nullable();
            $table->text('table_percent')->nullable();
            $table->text('lab')->nullable();
            $table->text('certificate')->nullable();  
            $table->text('certificate_url')->nullable();  
            $table->text('culet_size')->nullable();  
            $table->text('girdle_percent')->nullable();  
            $table->text('girdle_condition')->nullable(); 
            $table->text('measurements')->nullable(); 
            $table->text('pavilion_depth')->nullable(); 
            $table->text('crown_height')->nullable();   
            $table->text('crown_angle')->nullable();   
            $table->text('pavilion_angle')->nullable();   
            $table->text('growth_type')->nullable();   
            $table->text('image_1')->nullable(); 
            $table->text('image_2')->nullable(); 
            $table->text('image_3')->nullable(); 
            $table->text('image_4')->nullable();
            $table->text('location')->nullable();
            $table->text('comment')->nullable();            
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
        Schema::dropIfExists('tmp_diamond');
    }
}
