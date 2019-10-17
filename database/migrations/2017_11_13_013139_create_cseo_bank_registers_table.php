<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCseoBankRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cseo_bank_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('regsiter_id');
            $table->integer('bank_id');
            $table->string('account_no');
            $table->string('behalfofaccount');
            $table->integer('status_id');
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
        Schema::dropIfExists('cseo_bank_registers');
    }
}
