<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiSurveillanceHospieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //author
        Schema::create('thospi_surveillance_hospie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospi')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('medecinAssistant',100);
            $table->string('author',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
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
        Schema::dropIfExists('thospi_surveillance_hospie');
    }
}
