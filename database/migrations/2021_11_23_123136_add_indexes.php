<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_groups', function (Blueprint $table) {
            $table->index('attribute_group_id');
        });
        Schema::table('attributes', function (Blueprint $table) {
            $table->index('attribute_id');
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->index('blog_id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->index('category_id');
        });
        Schema::table('city', function (Blueprint $table) {
            $table->index('city_id');
        });
        Schema::table('country', function (Blueprint $table) {
            $table->index('country_id');
        });
        Schema::table('customer', function (Blueprint $table) {
            $table->index('customer_id');
        });
        /* Schema::table('customer_activity', function (Blueprint $table) {
            $table->index('customer_activity_id');
        }); */
        Schema::table('customer_cart', function (Blueprint $table) {
            $table->index('customer_cart_id');
        });
        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->index('customer_company_id');
        });
        Schema::table('customer_type', function (Blueprint $table) {
            $table->index('customer_type_id');
        });
        Schema::table('customer_whishlist', function (Blueprint $table) {
            $table->index('customer_wishlist_id');
        });
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->index('delivery_charge_id');
        });
        Schema::table('designation', function (Blueprint $table) {
            $table->index('id');
        });
        Schema::table('diamonds', function (Blueprint $table) {
            $table->index('diamond_id');
        });
        Schema::table('diamonds_attributes', function (Blueprint $table) {
            $table->index('diamond_attribute_id');
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->index('discount_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->index('event_id');
        });
        Schema::table('informative_pages', function (Blueprint $table) {
            $table->index('informative_page_id');
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->index('module_id');
        });
        Schema::table('order_diamonds', function (Blueprint $table) {
            $table->index('order_diamond_id');
        });
        Schema::table('order_statuses', function (Blueprint $table) {
            $table->index('order_status_id');
        });
        Schema::table('order_updates', function (Blueprint $table) {
            $table->index('order_update_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index('order_id');
        });
        Schema::table('payment_modes', function (Blueprint $table) {
            $table->index('payment_mode_id');
        });
        Schema::table('rapaport', function (Blueprint $table) {
            $table->index('rapaport_id');
        });
        Schema::table('rapaport_type', function (Blueprint $table) {
            $table->index('rapaport_type_id');
        });
        Schema::table('recently_view_diamonds', function (Blueprint $table) {
            $table->index('id');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->index('setting_id');
        });
        Schema::table('share_cart', function (Blueprint $table) {
            $table->index('share_cart_id');
        });
        Schema::table('share_wishlist', function (Blueprint $table) {
            $table->index('share_wishlist_id');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->index('slider_id');
        });
        Schema::table('state', function (Blueprint $table) {
            $table->index('state_id');
        });
        Schema::table('taxes', function (Blueprint $table) {
            $table->index('tax_id');
        });
        Schema::table('transport', function (Blueprint $table) {
            $table->index('transport_id');
        });
        Schema::table('user_activity', function (Blueprint $table) {
            $table->index('user_activity_id');
        });
        Schema::table('user_role', function (Blueprint $table) {
            $table->index('user_role_id');
        });
        Schema::table('users', function (Blueprint $table) {
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
        //
    }
}
