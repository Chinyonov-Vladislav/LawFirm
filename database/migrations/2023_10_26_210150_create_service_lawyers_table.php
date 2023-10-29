<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceLawyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_lawyers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->BigInteger('lawyer_id')->unsigned();
            $table->foreign('lawyer_id')->references('id')->on('lawyers');
            $table->decimal("Cost", 15, 2);
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
        Schema::dropIfExists('service_lawyers');
    }
}
