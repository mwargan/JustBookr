<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_classes', function (Blueprint $table) {
            $table->integer('uc-id', true);
            $table->string('state', 11)->nullable();
            $table->integer('class')->nullable();
            $table->integer('user')->nullable();
            $table->string('start', 20)->nullable();
            $table->string('end', 20)->nullable();
            $table->string('user_group', 10)->nullable();
            $table->index(['class', 'user'], 'class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_classes');
    }
}
