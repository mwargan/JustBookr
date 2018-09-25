<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConnectedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connected_users', function (Blueprint $table) {
            $table->integer('connect-id', true);
            $table->integer('user-id-sell');
            $table->integer('user-id-buy')->index('user-id-buy');
            $table->integer('post-id')->index('post-id');
            $table->string('comment', 500)->nullable();
            $table->timestamp('timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('location-meet', 150);
            $table->timestamp('location-date')->default('0000-00-00 00:00:00');
            $table->string('location-time', 20)->nullable()->default('');
            $table->timestamp('replied')->nullable();
            $table->index(['user-id-sell', 'user-id-buy', 'post-id'], 'user-id-sell');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('connected_users');
    }
}
