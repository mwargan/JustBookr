<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 11)->nullable();
            $table->string('display', 150)->nullable();
            $table->string('data', 150)->nullable();
            $table->integer('uni-id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('support_channels');
    }
}
