<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->enum("status", ["В процессе", "Выиграно","Проиграно"])->default("В процессе");
            $table->string("feedback")->nullable();
            $table->unsignedInteger("rating")->nullable();
            $table->BigInteger('request_id')->unsigned()->unique();
            $table->foreign('request_id')->references('id')->on('requests')->restrictOnDelete();
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
        Schema::dropIfExists('instances');
    }
}
