<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->text('content')->nullable();
            $table->tinyInteger('rate')->unsigned()->default(1);
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });

        Schema::create('teacher_reviews', function (Blueprint $table) {
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('review_id')->unsigned();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teacher_reviews');
        Schema::drop('reviews');
    }
}
