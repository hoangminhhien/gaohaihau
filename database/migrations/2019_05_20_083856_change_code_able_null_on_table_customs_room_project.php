<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCodeAbleNullOnTableCustomsRoomProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('customers', function (Blueprint $table) {
            $table->string('project_code', 64)->nullable()->change();
            $table->string('building_code', 64)->nullable()->change();
            $table->string('room_no', 64)->nullable()->change();
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
            $table->dropColumn('project_code')->change();
            $table->dropColumn('building_code')->change();
            $table->dropColumn('room_no')->change();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->string('project_code',64)->after('phone');
            $table->string('building_code',64)->after('project_code');
            $table->string('room_no',64)->after('building_code');
            $table->index(['project_code', 'building_code']);
        });
    }
}
