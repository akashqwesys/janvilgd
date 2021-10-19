<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_groups', function (Blueprint $table) {
            $table->id('attribute_group_id');
            $table->string('name',30);
            $table->text('image');   
            $table->text('field_type');               
            $table->foreignId('refCategory_id');
            $table->text('is_required'); 
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
        Schema::dropIfExists('attribute_groups');
    }
}
