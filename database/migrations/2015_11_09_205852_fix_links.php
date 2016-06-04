<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_categories_items', function (Blueprint $table) {
            $table->dropForeign('link_categories_items_itm_id_foreign');
            $table->dropForeign('link_categories_items_cat_id_foreign');

            $table->foreign('cat_id')->references('id')->on('blog_categories');
            $table->foreign('itm_id')->references('id')->on('link_items')->onDelete('cascade');
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
