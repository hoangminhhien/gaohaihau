<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();
            $table->string('name',256)->nullable();
            $table->string('project_code',64)->nullable();
            $table->string('building_code',64)->nullable();
            $table->string('room_no',64)->nullable();
            $table->string('phone',64)->nullable();
            $table->integer('family_number_of_adults');
            $table->integer('family_number_of_children');
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
        Schema::dropIfExists('customers');
    }
}
