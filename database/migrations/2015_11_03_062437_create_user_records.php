<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->text('description')->default('');
            $table->string('image')->default('');
            $table->string('source')->default('');
            $table->string('organization')->default('');
            $table->dateTime('recorded_at')->nullable();
            $table->string('verified_image_1')->default('');
            $table->string('verified_image_2')->default('');
            $table->string('verified_image_3')->default('');
            $table->string('verified_image_4')->default('');
            $table->string('verified_image_5')->default('');
            $table->tinyInteger('status')->default(0); // 0 - not verified
            $table->tinyInteger('type')->unsigned()->default(0); // 0 = CERTIFICATE
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_records');
    }
}
