<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoMenuSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_menu_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->integer('parent_id');
            $table->string('label');
            $table->string('link');
            $table->string('tile_attrib');
            $table->integer('tab_status');
            $table->integer('tab_cat');
            $table->integer('custom_menu');
            $table->string('css_class');
            $table->string('link_rel');
            $table->string('description');
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
        Schema::dropIfExists('cseo_menu_setups');
    }
}
