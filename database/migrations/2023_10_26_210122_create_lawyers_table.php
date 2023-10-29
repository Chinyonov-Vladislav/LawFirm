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
            $table->string("FirstName");
            $table->string("SecondName");
            $table->string("MiddleName");
            $table->date("HireDate")->nullable();
            $table->json("Images")->nullable();
            $table->string("NumberPhone");
            $table->BigInteger('university_id')->unsigned();
            $table->foreign('university_id')->references('id')->on('universities');
            $table->BigInteger('user_id')->unsigned()->unique(); //для связи один-к-одному
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum("LevelEducation",["Бакалавр", "Магистр", "Аспирант", "Доктор наук"]);
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
