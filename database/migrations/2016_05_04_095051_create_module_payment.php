<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // -> cột string
            $table->string('code');
            $table->timestamps();
        });
        Schema::create('payments_info', function (Blueprint $table) {
            $table->increments('id');
            $table->char('national', 2)->nullable(); //new
            $table->string('name_account')->nullable();
            $table->string('email')->nullable();
            $table->char('country', 2)->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_city')->nullable(); //new
            $table->string('bank_branch')->nullable(); //new
            $table->string('bank_code')->nullable();
            $table->string('local_code')->nullable();
            $table->string('postal_code')->nullable(); //new
            $table->string('local_phone')->nullable(); //new
            $table->string('bank_number')->nullable();
            $table->string('orther_info')->nullable();
            $table->string('orther_pay_method')->nullable();
            $table->string('account_owner')->nullable(); //new
            $table->tinyInteger('group')->unsigned()->nullable(); //new
            $table->timestamps();
            $table->integer('type_pay_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('type_pay_id')->references('id')->on('payments_type')->onDelete('cascade');
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
        Schema::drop('payments_type');
        Schema::drop('payments_info');
    }
}
