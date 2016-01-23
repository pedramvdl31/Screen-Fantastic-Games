<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id',false)->nullable();
            $table->string('naver_username')->nullable();
            $table->string('firstname', 25)->nullable();
            $table->string('lastname', 25)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('country', 3)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('street', 125)->nullable();
            $table->integer('zipcode')->nullable();
            $table->decimal('pretax', 11,2)->nullable();
            $table->decimal('tax', 11,2)->nullable();
            $table->decimal('aftertax', 11,2)->nullable();
            $table->integer('payment_id')->nullable();
            $table->tinyInteger('payment_merchant')->nullable();
            $table->tinyInteger('quantity')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}
