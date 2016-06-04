<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableTmpLearningRequestAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tmp_learning_requests', function (Blueprint $table) {
            $table->text('teacher_like')->nullable();
            $table->text('teacher_like_orther')->nullable();
            $table->text('exigency')->nullable();
            $table->text('how_before_learn')->nullable();
            $table->text('description_level')->nullable();
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
