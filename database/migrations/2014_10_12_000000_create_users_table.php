<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realtime_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('secret')->unique();
            $table->string('name')->nullable();
            $table->enum('type', ['notification', 'message', 'module']);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('provider')->default('');
            $table->string('provider_id')->default('');
            $table->string('profile_picture')->default(env('APP_HOME_URL') . '/storage/app/profile_pictures/default.png');
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('channel_id')->unsigned();
            $table->string('phone')->default('');
            $table->boolean('phone_verified')->default(false);
            $table->string('skype')->default('');
            $table->char('gender', 10);
            $table->dateTime('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->char('country', 2)->default('US');
            $table->char('language', 2)->default('en');
            $table->string('timezone')->default('UTC');
            $table->tinyInteger('first_day_of_week')->unsigned()->default(0);
            $table->tinyInteger('long_date_format')->unsigned()->default(0);
            $table->tinyInteger('short_date_format')->unsigned()->default(0);
            $table->tinyInteger('long_time_format')->unsigned()->default(0);
            $table->tinyInteger('short_time_format')->unsigned()->default(0);
            $table->string('activation_code')->default('');
            $table->boolean('active')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('channel_id')->references('id')->on('realtime_channels')->onDelete('cascade');
        });

        Schema::create('realtime_subscribers', function (Blueprint $table) {
            $table->bigInteger('channel_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->primary(['channel_id', 'user_id']);
            $table->foreign('channel_id')->references('id')->on('realtime_channels')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('channel_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('client_ip');
            $table->text('message');
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('realtime_channels');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conversations');
        Schema::drop('realtime_subscribers');
        Schema::drop('users');
        Schema::drop('realtime_channels');
    }
}
