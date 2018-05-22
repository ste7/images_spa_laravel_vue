<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('image_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');;
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_tag');

        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
        });
    }
}
