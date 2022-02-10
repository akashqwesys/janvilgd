<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diamonds', function (Blueprint $table) {
            $table->index('refCategory_id');
        });
        Schema::table('diamonds_attributes', function (Blueprint $table) {
            $table->index('refDiamond_id');
            $table->index('refAttribute_group_id');
            $table->index('refAttribute_id');
        });
        Schema::table('attribute_groups', function (Blueprint $table) {
            $table->index('refCategory_id');
        });
        Schema::table('attributes', function (Blueprint $table) {
            $table->index('attribute_group_id');
        });
        Schema::table('city', function (Blueprint $table) {
            $table->index('refState_id');
        });
        /* Schema::table('customer_activity', function (Blueprint $table) {
            $table->index('refCustomer_id');
            $table->index('refModule_id');
        }); */
        Schema::table('customer_cart', function (Blueprint $table) {
            $table->index('refCustomer_id');
            $table->index('refDiamond_id');
        });
        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->index('refCustomer_id');
        });
        Schema::table('customer_whishlist', function (Blueprint $table) {
            $table->index('refCustomer_id');
            $table->index('refdiamond_id');
        });
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->index('reftransport_id');
        });
        Schema::table('order_diamonds', function (Blueprint $table) {
            $table->index('refOrder_id');
            $table->index('refDiamond_id');
        });
        Schema::table('order_updates', function (Blueprint $table) {
            $table->index('refOrder_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['refCustomer_id', 'refPayment_mode_id', 'refTransaction_id', 'refCustomer_company_id_billing', 'refCity_id_billing', 'refState_id_billing', 'refCountry_id_billing', 'refCustomer_company_id_shipping', 'refCity_id_shipping', 'refState_id_shipping', 'refCountry_id_shipping', 'refDelivery_charge_id', 'refDiscount_id', 'refTax_id']);
        });
        Schema::table('recently_view_diamonds', function (Blueprint $table) {
            $table->index(['refCustomer_id', 'refDiamond_id', 'refAttribute_group_id', 'refAttribute_id']);
        });
        Schema::table('share_cart', function (Blueprint $table) {
            $table->index('refDiamond_id');
        });
        Schema::table('share_wishlist', function (Blueprint $table) {
            $table->index('refDiamond_id');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->index('refCategory_id');
        });
        Schema::table('state', function (Blueprint $table) {
            $table->index('refCountry_id');
        });
        Schema::table('taxes', function (Blueprint $table) {
            $table->index(['refCity_id', 'refState_id', 'refCountry_id']);
        });
        Schema::table('user_activity', function (Blueprint $table) {
            $table->index('refUser_id');
            $table->index('refModule_id');
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
