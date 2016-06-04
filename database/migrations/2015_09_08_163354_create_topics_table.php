<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) { // tạo bảng trong db
            $table->increments('id'); // => tạo cột id kiểu int + tự tăng + primary key
            $table->string('name'); // -> cột string
            $table->timestamps(); // -> tạo 2 trường dữ liệu created_at vs update_at thì phải :))
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics');
    }
}
