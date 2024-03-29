<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedinUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linkedin_universities', function (Blueprint $table) {
            $table->integer('uni-id', true);
            $table->string('uni-name', 150);
            $table->string('en-name', 150)->nullable();
            $table->string('abr', 64)->nullable();
            $table->integer('country_id')->index('country_id');
            $table->string('city', 64)->nullable();
            $table->string('address', 259)->nullable();
            $table->text('description', 65535)->nullable();
            $table->string('uni-tel', 59)->nullable();
            $table->string('uni-pic', 259)->nullable();
            $table->string('uni-logo', 259)->nullable();
            $table->float('uni-lat', 10, 6)->nullable();
            $table->float('uni-lon', 10, 6)->nullable();
            $table->string('url', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('linkedin_universities');
    }
}
