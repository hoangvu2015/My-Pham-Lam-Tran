<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnableMultilangTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->removeColumn('name');
        });

        Schema::create('topic_translations', function (Blueprint $table) {
            $table->increments('id'); //primary
            $table->integer('topic_id')->unsigned(); //primary key
            $table->string('locale', 10)->index();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description');

            $table->unique(['topic_id', 'locale']);
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topic_translations');
    }
}
