<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerWhishlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_whishlist', function (Blueprint $table) {
            $table->id('customer_wishlist_id');            
            $table->foreignId('refCustomer_id');
            $table->foreignId('refdiamond_id');                      
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
        Schema::dropIfExists('customer_whishlist');
    }
}
