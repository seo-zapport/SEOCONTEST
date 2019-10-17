<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile_number');
            $table->string('pin_bbm');
            $table->string('url_web_contest');
            $table->text('description')->nullable();
            $table->integer('user_id');
            $table->integer('status_id');
            $table->integer('curr_status_id')->nullable();
            $table->boolean('verify_status')->default(0);
            $table->text('verify_token')->nullable();
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
        Schema::dropIfExists('cseo_registers');
    }
}
