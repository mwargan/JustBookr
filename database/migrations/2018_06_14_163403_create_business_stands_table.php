<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessStandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_stands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->unsigned()->index();
            $table->integer('uni_id')->unsigned()->index();
            $table->string('stand_text')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['business_id', 'uni_id', 'location']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('business_stands');
    }
}
