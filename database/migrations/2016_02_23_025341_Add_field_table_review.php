<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTableReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('teaching_content');
            $table->integer('teaching_method');
            $table->integer('attitude_work');
            $table->integer('network_quality');
            $table->integer('value_received');
            $table->integer('status_learn');
            $table->integer('learn_time');
            $table->text('course')->nullable();
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
