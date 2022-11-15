<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJbdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jbdata', function (Blueprint $table) {
            $table->integer('name')->primary();
            $table->integer('logo');
            $table->integer('logodark');
            $table->integer('maintanmode');
            $table->integer('supportemail');
            $table->integer('contactemail');
            $table->integer('webadminemail');
            $table->integer('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jbdata');
    }
}
