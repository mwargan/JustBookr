<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('post-id', true);
            $table->integer('user-id')->nullable()->index('user-id');
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('post-description', 65535);
            $table->string('isbn', 17)->index('isbn');
            $table->string('quality', 64)->nullable()->default('');
            $table->integer('uni-id')->index('uni-id');
            $table->integer('sku');
            $table->integer('price');
            $table->boolean('status')->default(1);
            // $table->index(['isbn', 'post-description'], 'search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
