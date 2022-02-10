<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactReq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_req', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('phone');
            $table->text('email');
            $table->text('subject');
            $table->text('message');
            $table->dateTime('date_added');
            $table->timestamps();
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_req');
    }
}
