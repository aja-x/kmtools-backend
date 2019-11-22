<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_article')->unsigned()->index();
            $table->bigInteger('id_image')->unsigned()->index();
            $table->foreign('id_article')->references('id')
                ->on('articles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_image')->references('id')
                ->on('images')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_images');
    }
}
