<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reported_by')->nullable()->index('reported_by');
            $table->integer('post-id')->nullable()->index('post-id');
            $table->string('reason', 150)->nullable();
            $table->timestamp('report_time')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('resolved')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reported_posts');
    }
}
