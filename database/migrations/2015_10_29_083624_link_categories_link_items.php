<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkCategoriesLinkItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_categories_items', function (Blueprint $table) {
            $table->integer('cat_id')->unsigned();
            $table->bigInteger('itm_id')->unsigned();

            $table->primary(['itm_id', 'cat_id']);
            //foreign key
            $table->foreign('cat_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->foreign('itm_id')->references('id')->on('link_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('link_categories_items');
    }
}
