<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this table haves all fields which don't translate
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->bigIncrements('id'); //primary key
            $table->bigInteger('auth_id')->unsigned();
            $table->timestamps();

            //foreign key
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
        });


        //this table haves all fields which need to translate
        Schema::create('blog_article_translations', function (Blueprint $table) {
            $table->bigIncrements('id'); //primary key
            $table->bigInteger('art_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content');
            $table->string('locale')->index();

            $table->unique(['art_id', 'locale']);
            $table->foreign('art_id')->references('id')->on('blog_articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog_article_translations');
        Schema::drop('blog_articles');
    }
}
