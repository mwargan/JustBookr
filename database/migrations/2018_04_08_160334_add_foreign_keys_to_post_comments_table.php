<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->foreign('user-id', 'post_comments_ibfk_1')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('post-id', 'post_to_id')->references('post-id')->on('posts')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropForeign('post_comments_ibfk_1');
            $table->dropForeign('post_to_id');
        });
    }
}
