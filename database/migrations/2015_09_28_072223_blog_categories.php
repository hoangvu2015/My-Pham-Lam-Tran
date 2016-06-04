<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this table contants all fields doesn't translate
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id'); //primary key
            $table->timestamps();
        });


        //this table contants all fields need to translate
        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->increments('id'); //primary key
            $table->integer('cat_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['cat_id', 'locale']);
            $table->foreign('cat_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog_category_translations');
        Schema::drop('blog_categories');
    }
}
