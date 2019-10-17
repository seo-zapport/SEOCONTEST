<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_name');
            $table->text('title_banner')->nullable();
            $table->text('alt_text_banner')->nullable();
            $table->text('target_url')->nullable();
            $table->text('description')->nullable();
            $table->text('url_dns')->nullable();
            $table->integer('cseo_media_id')->nullable();
            $table->integer('cseo_categories_id');
            $table->integer('rev_count')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('curr_status_id')->nullable();
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
        Schema::dropIfExists('cseo_banners');
    }
}
