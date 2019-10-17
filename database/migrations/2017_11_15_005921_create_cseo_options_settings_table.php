<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoOptionsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_options_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('parent_id');
            $table->bigInteger('current_id');
            $table->string('site_url');
            $table->longText('site_identity')->nullable();
            $table->string('site_status', 20)->nullable();
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
        Schema::dropIfExists('cseo_options_settings');
    }
}
