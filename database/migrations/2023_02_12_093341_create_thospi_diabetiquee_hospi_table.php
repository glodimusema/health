<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiDiabetiqueeHospiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_diabetiquee_hospi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSurvHospi')->constrained('thospi_surveillance_hospie')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateDiab');
            $table->string('glycemieMatin');
            $table->string('doseMatin');
            $table->string('siteMatin');
            $table->string('ObservationMatin');
            $table->string('glycemieSoir');
            $table->string('doseSoir');
            $table->string('siteSoir');
            $table->string('observationSoir');
            $table->string('author');
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
        Schema::dropIfExists('thospi_diabetiquee_hospi');
    }
}
