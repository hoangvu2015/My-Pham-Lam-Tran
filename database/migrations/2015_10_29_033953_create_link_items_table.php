<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this table contants all fields doesn't translate
        Schema::create('link_items', function (Blueprint $table) {
            $table->bigIncrements('id'); //primary key
            $table->string('image');
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
        });

        //this table contants all fields need to translate
        Schema::create('link_items_translations', function (Blueprint $table) {
            $table->bigIncrements('id'); //primary key
            $table->bigInteger('itm_id')->unsigned(); //primary key
            $table->string('name');
            $table->string('description');
            $table->string('link');
            $table->string('locale')->index();

            $table->unique(['itm_id', 'locale']);
            $table->foreign('itm_id')->references('id')->on('link_items')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('link_items_translations');
        Schema::drop('link_items');
    }
}
