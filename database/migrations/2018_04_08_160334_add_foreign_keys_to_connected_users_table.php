<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToConnectedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connected_users', function (Blueprint $table) {
            $table->foreign('post-id', 'connected_users_ibfk_1')->references('post-id')->on('posts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user-id-sell', 'connected_users_ibfk_2')->references('user-id')->on('posts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user-id-buy', 'connected_users_ibfk_3')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connected_users', function (Blueprint $table) {
            $table->dropForeign('connected_users_ibfk_1');
            $table->dropForeign('connected_users_ibfk_2');
            $table->dropForeign('connected_users_ibfk_3');
        });
    }
}
