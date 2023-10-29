<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("second_name");
            $table->string("middle_name");
            $table->date("hire_date")->nullable();
            $table->json("images")->nullable();
            $table->string("number_phone");
            $table->BigInteger('university_id')->unsigned();
            $table->foreign('university_id')->references('id')->on('universities');
            $table->BigInteger('user_id')->unsigned()->unique(); //для связи один-к-одному
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum("level_education",["Бакалавр", "Магистр", "Аспирант", "Доктор наук"]);
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
        Schema::dropIfExists('lawyers');
    }
}
