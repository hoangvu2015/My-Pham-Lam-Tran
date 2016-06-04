<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogCategoriesArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories_articles', function (Blueprint $table) {
            $table->bigInteger('art_id')->unsigned();
            $table->integer('cat_id')->unsigned();

            $table->primary(['art_id', 'cat_id']);
            //foreign key
            $table->foreign('art_id')->references('id')->on('blog_articles')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('blog_categories');
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
        Schema::drop('blog_categories_articles');
    }
}
