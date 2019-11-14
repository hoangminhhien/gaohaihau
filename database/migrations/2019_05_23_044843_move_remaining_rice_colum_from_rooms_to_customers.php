<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveRemainingRiceColumFromRoomsToCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('remaining_rice');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('remaining_rice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('remaining_rice')->nullable();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('remaining_rice');
        });
    }
}
