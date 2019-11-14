<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropUnique(array('project_code', 'building_code'));
            $table->unique(array('project_code', 'building_code', 'deleted_at'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropUnique(array('project_code', 'building_code', 'deleted_at'));
            $table->unique(array('project_code', 'building_code'));
        });
    }
}
