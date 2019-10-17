<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoThemeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_theme_options', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('theme__image')->nullable(); // Logo, icon
            $table->string('theme__colorScheme', 150)->nullable(); // Color Scheme
            $table->string('theme__bgColor', 150)->nullable(); // BgColor
            $table->longText('theme__banner')->nullable(); // Enable banner, Banner image
            $table->longText('theme__timePicker')->nullable(); //Timepicker - Limit, Timepicker - Annoucement, Timepicker Enable Image, Timepicker Image - Limit, Timepicker Image - Annoucement
            $table->string('theme__title', 255)->nullable(); // Title
            $table->longText('theme__editor')->nullable(); // Editor
            $table->longText('theme__seoRankings')->nullable(); // Enable, Title, Text, Url
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
        Schema::dropIfExists('cseo_theme_options');
    }
}