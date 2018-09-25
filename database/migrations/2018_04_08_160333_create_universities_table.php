<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->integer('uni-id', true);
            $table->string('uni-name', 64);
            $table->string('abr', 64);
            $table->string('country', 64)->index('country');
            $table->string('city', 64);
            $table->string('address', 259);
            $table->text('description', 65535);
            $table->string('uni-tel', 59);
            $table->string('uni-pic', 259);
            $table->string('uni-logo', 259);
            $table->float('uni-lat', 10, 6)->nullable();
            $table->float('uni-lon', 10, 6)->nullable();
            $table->index(['city', 'uni-name', 'en-name', 'abr', 'country', 'description', 'address'], 'search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('universities');
    }
}
