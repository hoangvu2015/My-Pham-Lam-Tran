<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTeacher2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('know_us_from')->default('');
            $table->string('know_us_from_detail')->default('');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook')->default('');
            $table->string('fastest_contact_ways')->default('');
            $table->text('bio')->nullable();
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
