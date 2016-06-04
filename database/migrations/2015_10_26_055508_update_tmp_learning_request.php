<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTmpLearningRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tmp_learning_requests', function (Blueprint $table) {
            $table->string('wizard_key')->index();
            $table->string('facebook')->default('');
            $table->integer('quick_test_time')->default(0);
            $table->string('voice')->default('');
            $table->text('about_me')->default('');
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
