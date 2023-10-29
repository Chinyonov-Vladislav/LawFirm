<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_services', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('instance_id')->unsigned();
            $table->foreign('instance_id')->references('id')->on('instances');
            $table->BigInteger('service_lawyer_id')->unsigned();
            $table->foreign('service_lawyer_id')->references('id')->on('service_lawyers');
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
        Schema::dropIfExists('case_services');
    }
}
