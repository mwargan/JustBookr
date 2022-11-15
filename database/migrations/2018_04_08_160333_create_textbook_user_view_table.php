<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextbookUserViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('textbook_user_view', function (Blueprint $table) {
            $table->integer('tview-id', true);
            $table->integer('user-id')->nullable()->index('user-id');
            $table->string('view_IP', 45);
            $table->string('isbn-viewed', 13)->default('');
            $table->integer('uni-viewed')->nullable();
            $table->timestamp('date-viewed')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('textbook_user_view');
    }
}
