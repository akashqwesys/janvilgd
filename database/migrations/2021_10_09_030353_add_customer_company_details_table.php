<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_company_details', function (Blueprint $table) {
            $table->id('customer-company_id');
            $table->foreignId('refCustomer_id');
            $table->string('name',30);
            $table->string('office_no',20);
            $table->string('official_email',30);
            $table->foreignId('refDesignation_id');
            $table->string('designation_name',30);                        
            $table->text('office_address');
            $table->integer('pincode');
            $table->foreignId('refCity_id');
            $table->foreignId('refState_id');
            $table->foreignId('refCountry_id');
            $table->string('pan_gst_no',30);
            $table->text('pan_gst_attachment');
            $table->tinyInteger('is_approved');
            $table->dateTime('approved_date_time');
            $table->foreignId('approved_by');
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
        Schema::dropIfExists('customer_company_details');
    }
}
