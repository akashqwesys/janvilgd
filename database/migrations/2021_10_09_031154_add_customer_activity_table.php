<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_activity', function (Blueprint $table) {
            $table->id('customer_activity_id'); 
            $table->foreignId('refCustomer_id');
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
        Schema::dropIfExists('customer_activity');
    }
}
