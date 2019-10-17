<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('media_name')->nullable();
            $table->string('media_thumbnail')->nullable();
            $table->string('media_attachments')->nullable();
            $table->string('title_name')->nullable();
            $table->text('caption_text')->nullable();
            $table->text('alt_text')->nullable();
            $table->text('description')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->string('dimension')->nullable();
            $table->integer('view_stat')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status_id')->nullable();
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
        Schema::dropIfExists('cseo_media');
    }
}
