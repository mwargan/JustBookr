<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUniversityTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('university_tags', function (Blueprint $table) {
            $table->foreign('tag_id', 'tag_key')->references('tag-id')->on('tags')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('uni_id', 'university_key')->references('uni-id')->on('universities')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('university_tags', function (Blueprint $table) {
            $table->dropForeign('tag_key');
            $table->dropForeign('university_key');
        });
    }
}
