<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('refCustomer_id');
            $table->string('name', 50)->nullable();
            $table->string('mobile_no', 15)->nullable();
            $table->string('email_id', 100)->nullable();
            $table->foreignId('refPayment_mode_id');
            $table->string('payment_mode_name', 50);
            $table->foreignId('refTransaction_id');
            $table->foreignId('refCustomer_company_id_billing');
            $table->text('billing_company_name');
            $table->string('billing_company_office_no', 15);
            $table->string('billing_company_office_email', 100);
            $table->longText('billing_company_office_address');
            $table->integer('billing_company_office_pincode');
            $table->foreignId('refCity_id_billing');
            $table->foreignId('refState_id_billing');
            $table->foreignId('refCountry_id_billing');
            $table->string('billing_company_pan_gst_no', 30);

            $table->foreignId('refCustomer_company_id_shipping');
            $table->text('shipping_company_name');
            $table->string('shipping_company_office_no', 15);
            $table->string('shipping_company_office_email', 100);
            $table->longText('shipping_company_office_address');
            $table->integer('shipping_company_office_pincode');
            $table->foreignId('refCity_id_shipping');
            $table->foreignId('refState_id_shipping');
            $table->foreignId('refCountry_id_shipping');
            $table->string('shipping_company_pan_gst_no', 30);

            $table->float('sub_total');
            $table->foreignId('refDelivery_charge_id');
            $table->string('delivery_charge_name', 100);
            $table->float('delivery_charge_amount');
            $table->foreignId('refDiscount_id');
            $table->string('discount_name', 100);
            $table->float('discount_amount');
            $table->foreignId('refTax_id');
            $table->string('tax_name', 100);
            $table->float('tax_amount');
            $table->float('total_paid_amount');
            $table->string('order_status', 100)->nullable();
            $table->foreignId('added_by');
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
        Schema::dropIfExists('orders');
    }
}
