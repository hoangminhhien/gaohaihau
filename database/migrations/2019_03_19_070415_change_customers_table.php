<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('name', 256)->nullable(false)->change();
            $table->string('project_code', 64)->nullable(false)->change();
            $table->string('building_code', 64)->nullable(false)->change();
            $table->string('room_no', 64)->nullable(false)->change();
            $table->string('phone', 64)->nullable(false)->change();
            $table->integer('family_number_of_adults')->nullable()->change();
            $table->integer('family_number_of_children')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('project_code')->nullable()->change();
            $table->string('building_code')->nullable()->change();
            $table->string('room_no')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->dropColumn('family_number_of_adults');
            $table->dropColumn('family_number_of_children');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->integer('family_number_of_adults');
            $table->integer('family_number_of_children');
        });
    }
}
