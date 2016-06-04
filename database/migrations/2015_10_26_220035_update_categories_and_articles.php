<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategoriesAndArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->tinyInteger('type')->unsigned()->default(0); // 0 = BLOG

            $table->foreign('parent_id')->references('id')->on('blog_categories');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->bigInteger('publisher_id')->unsigned()->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->tinyInteger('type')->unsigned()->default(1); // 0 = PAGE, 1 = POST, 2 ...
            $table->tinyInteger('status')->unsigned()->default(0); // 0 = DRAFT
            $table->boolean('comment_allowed')->default(true);

            $table->foreign('publisher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
