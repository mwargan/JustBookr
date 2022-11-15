<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatter', function (Blueprint $table) {
            $table->integer('chat_id', true);
            $table->integer('chat_by');
            $table->integer('chat_to');
            $table->timestamp('chat_timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('chat_message', 65535);
            $table->integer('chat_status')->default(1);
            $table->dateTime('chat_seen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chatter');
    }
}
