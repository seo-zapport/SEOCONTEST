<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_name');
            $table->string('page_title')->nullable();
            $table->string('page_content')->nullable();
            $table->string('url_path')->nullable();
            $table->string('page_type')->nullable();
            $table->string('rev_count')->nullable();
            $table->integer('cseo_category_id')->nullable();
            $table->integer('cseo_media_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('curr_status_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('cseo_pages');
    }
}
