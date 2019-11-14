<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->datetime('delivery_time_expect_from')->nullable()->change();
            $table->datetime('delivery_time_expect_to')->nullable()->change();
            $table->datetime('delivered_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->date('delivery_time_expect_from')->nullable()->change();
            $table->date('delivery_time_expect_to')->nullable()->change();
            $table->date('delivered_time')->nullable()->change();
        });
    }
}
