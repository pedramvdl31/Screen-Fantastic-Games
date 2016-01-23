<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username')->nullable();
            $table->string('firstname', 25)->nullable();
            $table->string('lastname', 25)->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('age')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('country', 3)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('street', 125)->nullable();
            $table->integer('zipcode')->nullable();
            $table->integer('payment_id')->nullable();
            $table->string('company', 25)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('profile_image')->nullable();
            $table->tinyInteger('roles');
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
