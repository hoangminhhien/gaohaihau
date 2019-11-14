<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // drop old unique
            $table->dropUnique(array('project_code', 'building_code', 'room_no'));
            //
            $table->unique(array('project_code', 'building_code', 'room_no', 'deleted_at'));
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
            $table->dropUnique(array('project_code', 'building_code', 'room_no', 'deleted_at'));
            $table->unique(array('project_code', 'building_code', 'room_no'));
        });
    }
}
