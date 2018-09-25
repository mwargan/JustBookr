<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReportedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reported_posts', function (Blueprint $table) {
            $table->foreign('reported_by', 'reported_posts_ibfk_1')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('post-id', 'reported_posts_ibfk_2')->references('post-id')->on('posts')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reported_posts', function (Blueprint $table) {
            $table->dropForeign('reported_posts_ibfk_1');
            $table->dropForeign('reported_posts_ibfk_2');
        });
    }
}
