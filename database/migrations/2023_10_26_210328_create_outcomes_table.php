<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcomes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('type_outcome_id')->unsigned();
            $table->foreign('type_outcome_id')->references('id')->on('type_outcomes')->restrictOnDelete();
            $table->BigInteger('instance_id')->unsigned();
            $table->foreign('instance_id')->references('id')->on('instances')->restrictOnDelete();
            $table->decimal("monetary_penalty", 15,2)->nullable();
            $table->unsignedInteger("count_years")->nullable();
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
        Schema::dropIfExists('outcomes');
    }
}
