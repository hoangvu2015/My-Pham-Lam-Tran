<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemeWidget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('widget_name');
            $table->string('theme_name')->default('');
            $table->string('placeholder');
            $table->boolean('translatable')->default(false);
            $table->text('constructing_data');
            $table->boolean('active')->default(true);
            $table->tinyInteger('order')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('theme_widgets');
    }
}
