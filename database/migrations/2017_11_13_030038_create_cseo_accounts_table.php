<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('display_name');
            $table->string('position');
            $table->string('email');
            $table->string('password');
            $table->string('skype_id');
            $table->string('mobile_no');
            $table->integer('account_id');
            $table->integer('status_id');
            $table->integer('cseo_media_id');
            $table->string('is_logged_in');
            $table->string('remember_token');
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
        Schema::dropIfExists('cseo_accounts');
    }
}
