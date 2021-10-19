<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diamonds', function (Blueprint $table) {
            $table->id('diamond_id');
            $table->string('name',30);
            $table->text('barcode');
            $table->string('packate_no',50);
            $table->integer('actual_pcs');
            $table->integer('available_pcs');                       
            $table->float('makable_cts');
            $table->float('expected_polish_cts');
            $table->text('remarks');
            $table->float('rapaport_price');
            $table->float('discount');
            $table->string('weight_loss',30);
            $table->text('video_link');
            $table->text('images');
            $table->foreignId('refCategory_id');            
            $table->foreignId('added_by');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_deleted');            
            $table->dateTime('date_added');
            $table->dateTime('date_updated');            
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
        Schema::dropIfExists('diamonds');
    }
}
