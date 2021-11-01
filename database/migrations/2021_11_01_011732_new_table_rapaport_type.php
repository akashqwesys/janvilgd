<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewTableRapaportType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapaport_type', function (Blueprint $table) {
            $table->id('rapaport_type_id');
            $table->string('name',30);
            $table->string('rapaport_category',30);
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
        Schema::dropIfExists('rapaport_type');
    }
}
