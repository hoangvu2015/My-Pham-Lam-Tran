<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('result_tests', function (Blueprint $table) {
            $table->dropForeign('result_tests_user_id_foreign');
            $table->dropForeign('result_tests_test_id_foreign');
            $table->dropColumn(['user_id', 'test_id']);
            // $table->bigInteger('user_id')->unsigned();
            // $table->integer('test_id')->unsigned();
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
