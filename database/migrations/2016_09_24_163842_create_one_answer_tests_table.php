<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOneAnswerTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_answer_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('create_user_id');
            $table->unsignedInteger('changed_user_id');
            $table->unsignedInteger('test_id');
            $table->text('question');
            $table->json('answers');
            $table->string('true');
            $table->tinyInteger('points');
            $table->unsignedInteger('order');
            $table->boolean('enable');
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
        Schema::dropIfExists('one_answer_tests');
    }
}
