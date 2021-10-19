<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('name',30);
            $table->text('image');  
            $table->text('description');  
            $table->text('slug');                          
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
        Schema::dropIfExists('categories');
    }
}
