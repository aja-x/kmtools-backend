<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned()->index();
            $table->bigInteger('id_article')->unsigned()->nullable()->index();
            $table->timestamp('last_accessed');
            $table->foreign('id_user')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_article')->references('id')
                ->on('articles')->onUpdate('cascade')->onDelete('no action');
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
        Schema::dropIfExists('activity_histories');
    }
}
