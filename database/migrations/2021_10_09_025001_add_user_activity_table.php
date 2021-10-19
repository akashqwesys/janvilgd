<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity', function (Blueprint $table) {
            $table->id('user_activity_id'); 
            $table->foreignId('refUser_id');
            $table->foreignId('refModule_id');
            $table->text('activity');
            $table->text('subject');
            $table->text('url');
            $table->string('device',20);
            $table->string('ip_address',30);            
             $table->dateTime('date_added');             
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
        Schema::dropIfExists('user_activity');
    }
}
