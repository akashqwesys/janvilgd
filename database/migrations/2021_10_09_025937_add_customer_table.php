<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('name',30);
            $table->string('mobile',10);
            $table->string('email',30);
            $table->longText('address');
            $table->integer('pincode');
            $table->foreignId('refCity_id');
            $table->foreignId('refState_id');
            $table->foreignId('refCountry_id');
            $table->foreignId('refCustomerType_id');
            $table->tinyInteger('restrict_transactions');
            $table->foreignId('added_by');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_deleted');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');
            $table->string('device_token', 400)->nullable();
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
        Schema::dropIfExists('customer');
    }
}
