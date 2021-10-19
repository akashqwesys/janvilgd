<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformativePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informative_pages', function (Blueprint $table) {
            $table->id('informative_page_id');
            $table->string('name',30);
            $table->text('content');     
            $table->text('slug');                          
            $table->foreignId('updated_by');
            $table->tinyInteger('is_active');                                  
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
        Schema::dropIfExists('informative_pages');
    }
}
