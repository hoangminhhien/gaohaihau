<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->softDeletes();
            $table->integer('custormer_id');
            $table->date('delivery_time_expect_from')->nullable();
            $table->date('delivery_time_expect_to')->nullable();
            $table->integer('status')->comment('1: customer_order; 2: Inprogess; 3: canceled; 4: delivered; 5: archived');
            $table->date('delivered_time')->nullable();
            $table->string('canceled_note',256)->nullable();
            $table->integer('shipper_id')->nullable();
            $table->string('delivery_image_url',256)->nullable()->comment('envidence giao gao');
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
