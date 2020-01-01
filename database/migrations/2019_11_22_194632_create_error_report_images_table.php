<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorReportImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_report_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_error_report')->unsigned()->index();
            $table->bigInteger('id_image')->unsigned()->index();
            $table->foreign('id_error_report')->references('id')
                ->on('error_reports')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('error_report_images');
    }
}
