<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->integer('pincode')->nullable()->change();
            $table->string('password')->nullable();
            $table->integer('approved_by')->default(0);
            $table->tinyInteger('is_approved')->default(0);
            $table->dateTime('approved_at')->nullable();
        });

        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->tinyInteger('company_id_type')->nullable()->comment('1-VAT,2-TIN,3-PAN,4-OTHERS');
            $table->dropColumn(['approved_date_time', 'approved_by', 'is_approved']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
