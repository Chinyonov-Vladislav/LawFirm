<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseProceedingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_proceedings', function (Blueprint $table) {
            $table->id();
            $table->date("start_date");
            $table->date("finish_date");
            $table->BigInteger('judge_id')->unsigned();
            $table->foreign('judge_id')->references('id')->on('judges')->restrictOnDelete();
            $table->BigInteger('instance_id')->unsigned();
            $table->foreign('instance_id')->references('id')->on('instances')->restrictOnDelete();
            $table->BigInteger('court_stage_id')->unsigned();
            $table->foreign('court_stage_id')->references('id')->on('court_stages')->restrictOnDelete();
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
        Schema::dropIfExists('case_proceedings');
    }
}
