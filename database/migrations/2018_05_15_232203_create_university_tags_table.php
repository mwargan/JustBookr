<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUniversityTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('university_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uni_id')->index('uni_id');
            $table->integer('tag_id')->index('tag_id');
            $table->timestamps();
            $table->unique(['uni_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('university_tags');
    }
}
