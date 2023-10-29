<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("first_name")->nullable();
            $table->string("second_name")->nullable();
            $table->string("middle_name")->nullable();
            $table->string("number_phone")->nullable();
            $table->string("address")->nullable();
            $table->date("birthday")->nullable();
            $table->BigInteger('user_id')->unsigned()->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('clients');
    }
}
