<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stand_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stand_id')->unsigned()->index();
            $table->string('isbn');
            $table->string('description', 500)->nullable();
            $table->integer('price');
            $table->boolean('is_active')->nullable();
            $table->timestamps();
            $table->unique(['stand_id', 'isbn']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stand_posts');
    }
}
