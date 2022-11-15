<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('user-id', true);
            $table->string('name', 64);
            $table->string('surname', 64);
            $table->text('about-me', 16777215)->nullable();
            $table->string('username', 259)->nullable();
            $table->text('password', 16777215);
            $table->string('email', 64);
            $table->integer('uni-id')->nullable()->index('uni-id');
            $table->string('country', 20)->nullable();
            $table->string('city', 64)->nullable();
            $table->string('address', 259)->nullable();
            $table->string('user-tel', 20)->nullable();
            $table->timestamp('user-registered')->useCurrent();
            $table->boolean('userlevel')->default(1);
            $table->string('profilepic', 259)->default('https://justbookr.com/images/JBicon.svg');
            $table->timestamp('seen')->useCurrent();
            $table->timestamp('last_login')->nullable()->useCurrent();
            $table->string('last_ip_access', 17)->nullable();
            $table->string('sess-id', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
