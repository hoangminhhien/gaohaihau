<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type')->comment('1: Info, 2: Warning, 3: Error');
            $table->integer('from_id')->default(0)->comment('User id send notification');
            $table->integer('to_id')->default(0)->comment('User id reiceive notification');
            $table->string('title', 64);
            $table->string('object_type', 64);
            $table->boolean('is_read')->default(0);
            $table->string('content', 512);
            $table->string('data', 4096);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
