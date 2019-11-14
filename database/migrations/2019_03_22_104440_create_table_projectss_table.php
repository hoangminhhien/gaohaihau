<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProjectssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique('projects_project_code_unique');
            $table->unique(array('project_code', 'deleted_at'), 'project_code_deleted_at_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unique('project_code', 'projects_project_code_unique');
            $table->dropUnique('project_code_deleted_at_unique');
        });
    }
}
