<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_fields', function (Blueprint $table) { // tạo bảng trong db
            $table->increments('id'); // => tạo cột id kiểu int + tự tăng + primary key
            $table->timestamps(); // -> tạo 2 trường dữ liệu created_at vs update_at
        });

        Schema::create('working_fields_translations', function (Blueprint $table) {
            $table->increments('id'); //primary
            $table->integer('fields_id')->unsigned(); //primary key
            $table->string('locale', 10)->index();
            $table->string('slug');
            $table->string('name');
            $table->text('description');

            $table->unique(['fields_id', 'locale']);
            $table->foreign('fields_id')->references('id')->on('working_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('working_fields');
        Schema::drop('working_fields_translations');
    }
}
