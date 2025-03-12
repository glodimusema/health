<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiSurveilNeonatologieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thospi_surveil_neonatologie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospi')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('assistantMedical',100);
            $table->date('dateSurvNeo',100);
            $table->string('heure',20);
            $table->double('poidsSurvNeo');
            $table->string('temperatureSurvNeo',100);
            $table->string('FcSurvNeo',100);
            $table->string('FrSurvNeo',100);
            $table->string('SaOxygene',100);
            $table->string('Repme',100);
            $table->string('Resme',100);
            $table->string('v',100);
            $table->string('s',100);
            $table->string('u',100);
            $table->string('photo',100);
            $table->string('traitement',100);
            $table->string('natureRepas',100);
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
        Schema::dropIfExists('thospi_surveil_neonatologie');
    }
}
