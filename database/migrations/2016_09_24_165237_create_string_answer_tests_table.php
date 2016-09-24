<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStringAnswerTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('string_answer_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('create_user_id');
            $table->unsignedInteger('changed_user_id');
            $table->unsignedInteger('test_id');
            $table->text('question');
            $table->text('true');
            $table->tinyInteger('points');
            $table->unsignedTinyInteger('order');
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
        Schema::dropIfExists('string_answer_tests');
    }
}
