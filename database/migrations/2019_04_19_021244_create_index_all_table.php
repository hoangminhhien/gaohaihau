<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['customer_id']);
            $table->index(['status']);
            $table->index(['shipper_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['to_id']);
            $table->index(['is_read']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['quantity']);
        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->index(['product_id']);
            $table->index(['order_id', 'product_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index(['project_code', 'building_code']);
        });

        Schema::table('buildings', function (Blueprint $table) {
            $table->index(['project_code']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->index(['project_code', 'building_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['shipper_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['to_id']);
            $table->dropIndex(['is_read']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['quantity']);
        });

        Schema::table('order_products', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['order_id', 'product_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['project_code', 'building_code']);
        });

        Schema::table('buildings', function (Blueprint $table) {
            $table->dropIndex(['project_code']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['project_code', 'building_code']);
        }); 
    }
}
