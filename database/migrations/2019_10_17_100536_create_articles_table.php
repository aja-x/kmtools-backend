<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('content');
            $table->timestamp('last_edited')->nullable();
            $table->timestamp('published_date')->nullable();
            $table->bigInteger('id_user')->unsigned()->index();
            $table->bigInteger('id_interest_category')->unsigned()->nullable()->index();
            $table->bigInteger('id_error_report')->unsigned()->nullable()->index();
            $table->foreign('id_user')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_interest_category')->references('id')
                ->on('interest_categories')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('id_error_report')->references('id')
                ->on('error_reports')->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
