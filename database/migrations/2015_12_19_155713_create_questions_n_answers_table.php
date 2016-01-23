<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsNAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_n_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id',false)->nullable();
            $table->unsignedInteger('inventory_id',false)->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('parent_id')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::drop('questions_n_answers');
    }
}
